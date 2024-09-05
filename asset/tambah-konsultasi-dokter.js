Vue.component("v-select", VueSelect.VueSelect);

var application = new Vue({
  el: "#tambah-konsultasi",
  components: { VueTimepicker: VueTimepicker.default },
  created() {
    axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
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
      this.$set(this.selected_kuota, dokter.id, kuotaIndex);

      const selectedKuotaIndex = this.selected_kuota[dokter.id];
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
            alert("Voucher berhasil diterapkan.");
          } else {
            this.voucher_info = false;
            this.discount = 0;
            alert(res.data.message || "Kode voucher tidak valid.");
          }
        })
        .catch((err) => {
          console.log("Error:", err);
          alert("Terjadi kesalahan saat mengaplikasikan voucher.");
        });
    },

    calculateTotal() {
      if (this.biaya_tarif && this.discount > 0) {
        let discountAmount = (this.biaya_tarif * this.discount) / 100;
        this.total_biaya = this.biaya_tarif - discountAmount;
      } else {
        this.total_biaya = this.biaya_tarif;
      }
    },
    submitForm() {
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
      formData.append("users_id", "<?php echo $usr['users_id']; ?>");
      formData.append("jadwal_id", this.selected_kuota);
      formData.append("biaya", this.total_biaya);
      formData.append("aktif", "tidak aktif");

      // Append the uploaded image
      const imageFile = document.querySelector('input[name="image"]').files[0];
      if (imageFile) {
        formData.append("image", imageFile);
      } else {
        alert("Please upload a payment proof image.");
        return;
      }

      // Send form data via Axios
      axios
        .post("../administrator/insertPayment", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          if (response.data.success) {
            alert("Konsultasi berhasil ditambahkan.");
            window.location.href = "../user/konsultasi_tambahx";
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
