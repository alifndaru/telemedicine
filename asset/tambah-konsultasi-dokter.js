Vue.component("v-select", VueSelect.VueSelect);

var application = new Vue({
  el: "#tambah-konsultasi",
  components: { VueTimepicker: VueTimepicker.default },
  created() {
    axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
    this.users_id = localStorage.getItem("users_id") || null;
  },
  data: {
    baseUrl: baseUrl,
    disops: {
      provinsi: false,
      klinik: false,
    },
    provinsi: null,
    provinsi_options: [],
    klinik: null,
    klinik_options: [],
    dokter_options: [],
    selected_kuota: {},
    biaya_tarif: null,
    bank: null,
    rekening: null,
    atas_nama: null,
    kodeVoucher: "", // Voucher code input
    voucher_info: null, // To store voucher information after applying
    discount: 0, // New property to hold the discount amount
    total_biaya: 0, // New property to hold the total amount after discount
    discountAmount: 0,
    jadwalId: 0,
    users_id: null,
    paymentStatus: null, // Deklarasikan paymentStatus di sini
  },
  watch: {
    klinik: function (newKlinik) {
      if (this.provinsi && newKlinik) {
        this.fetchAvailableDoctors();
      }
    },
  },
  methods: {
    formatCurrency(value) {
      const numberValue = Number(value);
      if (isNaN(numberValue)) {
        return value;
      }
      return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(numberValue);
    },
    handleKuotaChange(dokter, kuotaIndex) {
      console.log("dokter", dokter);
      this.$set(this.selected_kuota, dokter.id, kuotaIndex);
      const selectedKuotaIndex = this.selected_kuota[dokter.id];
      this.jadwalId = dokter.jadwal_id[selectedKuotaIndex];
      console.log("this.jadwalId", this.jadwalId);
      if (selectedKuotaIndex !== undefined) {
        this.biaya_tarif = dokter.biaya_tarif[selectedKuotaIndex] || null;
        this.bank = dokter.bank[selectedKuotaIndex] || null;
        this.rekening = dokter.rekening[selectedKuotaIndex] || null;
        this.atas_nama = dokter.atas_nama[selectedKuotaIndex] || null;
      } else {
        this.biaya_tarif = null;
        this.bank = null;
        this.rekening = null;
        this.atas_nama = null;
      }
    },
    fetchOptionsProvinsi(search) {
      axios
        .post(
          "../administrator/xhrRefPemda",
          JSON.stringify({ params: { ref: "provinsi", search: search } })
        )
        .then((res) => {
          this.provinsi_options = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    selectedOptionProvinsi(value) {
      this.provinsi = value;
      this.klinik = null;
      this.klinik_options = [];
      this.dokter_options = [];
      this.selected_kuota = {};
      this.biaya_tarif = null;
      this.bank = null;
      this.rekening = null;
      this.atas_nama = null;
    },
    fetchOptionsKlinik(search) {
      axios
        .post(
          "../administrator/xhrKlinik",
          JSON.stringify({
            params: { ref: "klinik", provinsi: this.provinsi, search: search },
          })
        )
        .then((res) => {
          this.klinik_options = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    selectedOptionKlinik(value) {
      this.klinik = value;
      this.dokter_options = [];
      this.selected_kuota = {};
      this.biaya_tarif = null;
      this.bank = null;
      this.rekening = null;
      this.atas_nama = null;
    },
    fetchAvailableDoctors() {
      const params = { provinsi: this.provinsi, klinik: this.klinik };

      axios
        .post(
          "../administrator/getDoctorsByProvinceAndClinic",
          JSON.stringify({ params })
        )
        .then((res) => {
          this.dokter_options = res.data;
          if (res.data.length > 0) {
            const firstDoctor = res.data[0];
            this.biaya_tarif = Number(firstDoctor.biaya_tarif[0]) || null;
            this.bank = firstDoctor.bank;
            this.rekening = firstDoctor.rekening;
            this.atas_nama = firstDoctor.atas_nama;
          } else {
            this.biaya_tarif = null;
            this.bank = null;
            this.rekening = null;
            this.atas_nama = null;
          }
        })
        .catch((err) => {
          console.log("Error:", err);
        });
    },
    applyVoucher() {
      if (this.kodeVoucher.trim() === "") {
        alert("Silakan masukkan kode voucher.");
        return;
      }

      axios
        .post(
          "../administrator/applyVoucher",
          JSON.stringify({ kode_voucher: this.kodeVoucher })
        )
        .then((res) => {
          console.log(res.data);
          if (res.data.valid) {
            this.voucher_info = res.data.voucher;
            this.discount = res.data.voucher.nilai || 0; // Menyimpan nilai diskon dari voucher
            this.calculateTotal(); // Hitung total setelah diskon
            // alert("Voucher berhasil diterapkan.");
          } else {
            this.voucher_info = false;
            this.discount = 0;
            alert(res.data.message || "Kode voucher tidak valid.");
          }
          console.log("discount", this.discount);
          console.log("voucher_info", this.voucher_info);
        })
        .catch((err) => {
          console.log("Error:", err);
          alert("Terjadi kesalahan saat mengaplikasikan voucher.");
        });
    },

    calculateTotal() {
      if (this.biaya_tarif) {
        if (this.discount > 0) {
          let discountAmount = (this.biaya_tarif * this.discount) / 100;
          this.discountAmount = discountAmount;
          this.total_biaya = this.biaya_tarif - this.discountAmount;
        } else {
          // Jika tidak ada diskon, total_biaya sama dengan biaya_tarif
          this.total_biaya = this.biaya_tarif;
        }
      }
      console.log("total_biaya", this.total_biaya);
      console.log("biaya_tarif", this.biaya_tarif);
    },

    checkPaymentStatus() {
      if (!this.paymentId) {
        alert("ID Pembayaran tidak tersedia.");
        clearInterval(this.paymentCheckInterval); // Hentikan interval jika tidak ada paymentId
        return;
      }

      axios
        .get(`../administrator/checkPaymentStatus/${this.paymentId}`)
        .then((response) => {
          this.paymentStatus = response.data.aktif; // Simpan status pembayaran
          if (this.paymentStatus === "aktif") {
            clearInterval(this.paymentCheckInterval); // Hentikan pengecekan

            // Pindah ke step 4 jika status pembayaran aktif
            var active = document.querySelector(".wizard .nav-tabs li.active");
            if (active.nextElementSibling) {
              active.nextElementSibling.classList.remove("disabled");
            }

            // Simulate a click event on the next tab link (step 4)
            var nextTab = active.nextElementSibling.querySelector(
              'a[data-toggle="tab"]'
            );
            if (nextTab) {
              nextTab.click(); // Pindah ke step selanjutnya (step 4)
            }
          }
        })
        .catch((error) => {
          console.error("Error checking payment status:", error);
          alert("Terjadi kesalahan saat memeriksa status pembayaran.");
        });
    },

    submitForm() {
      this.calculateTotal();
      // Ensure that required data is present
      if (!this.provinsi || !this.klinik || !this.selected_kuota) {
        alert("Please complete all required fields.");
        return;
      }
      // Create FormData object
      let formData = new FormData();

      // Append the basic form data
      formData.append("provinsi_id", this.provinsi);
      formData.append("klinik_id", this.klinik);
      formData.append("jadwal_id", this.jadwalId);
      formData.append("biaya", this.total_biaya);
      formData.append("aktif", "tidak aktif");
      formData.append("users_id", this.users_id); // Tambahkan users_id ke FormData

      // Append the uploaded image
      if (this.total_biaya > 0) {
        const imageFile = document.querySelector('input[name="image"]')
          .files[0];
        if (imageFile) {
          formData.append("image", imageFile);
        } else {
          alert("Please upload a payment proof image.");
          return;
        }
      }

      console.log("formdata", formData);

      // Send form data via Axios
      axios
        .post("../administrator/insertPayment", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          if (response.data.success) {
            alert("Pembayaran sudah Tersimpan,Mohon pilih OK untuk next Step.");

            // Ambil paymentId dari response
            this.paymentId = response.data.paymentId;
            var active = document.querySelector(".wizard .nav-tabs li.active");
            if (active.nextElementSibling) {
              active.nextElementSibling.classList.remove("disabled");
            }

            // Simulate a click event on the next tab link
            var nextTab = active.nextElementSibling.querySelector(
              'a[data-toggle="tab"]'
            );

            if (nextTab) {
              nextTab.click();
            }
            // Mulai pengecekan status pembayaran setiap 5 detik
            this.paymentCheckInterval = setInterval(() => {
              this.checkPaymentStatus(); // Cek status pembayaran
            }, 5000); // Interval 5 detik
          } else {
            alert("Terjadi kesalahan: " + response.data.message);
          }
        })
        .catch((err) => {
          console.log("Error:", err);
          alert("Terjadi kesalahan saat mengirim data.");
        });
    },
  },
});
