var application = new Vue({
  el: "#vue-jadwal",
  components: { VueTimepicker: VueTimepicker.default },
  created() {
    axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
  },
  data: {
    message: null,
    valid: false,
    show: false,
    actAdd: true,
    actEdit: false,
    transitionName: "fade",
    msg: null,
    totalPage: null,
    currentPage: 1,
    perPage: 5,
    page: null,
    disops: { dokter: false },
    jadwal_id: null,
    dokter: null,
    dokter_options: [],
    dokter_id: null,
    action: null,
    nama_klinik: null,
    alamat_klinik: null,
    pos_klinik: null,
    email_klinik: null,
    telp_klinik: null,
    foto_klinik: null,
    status: null,
    search: null,
    jadwal: null,
    timezone: "wib",
    timestatus: "aktif",
    tstart: "",
    tend: "",
    kuota_pasien: null,
    biaya_tarif: null,
  },
  watch: {
    dokter_id: function () {
      if (this.dokter_id === null) {
        this.clearFields();
      }
    },
  },
  computed: {
    getPageCount: function () {
      return this.totalPage;
    },
  },
  mounted() {
    let kid = this.$refs.kid.value;
    this.fetchData(kid);
    this.fetchJadwalDokter();
    console.log(Intl.DateTimeFormat().resolvedOptions().timeZone);
  },
  methods: {
    clickCallback: function (pageNum) {
      this.currentPage = Number(pageNum);
      this.fetchJadwalDokter();
    },
    fetchData: function (kid) {
      axios
        .post(
          "../administrator/fetch_single_klinik",
          JSON.stringify({
            headers: { "Access-Control-Allow-Origin": "*" },
            data: { kid: kid },
          })
        )
        .then((res) => {
          if (res.data.length > 0) {
            this.status = res.data[0].status;
            this.foto_klinik = res.data[0].foto;
            this.nama_klinik = res.data[0].klinik;
            this.alamat_klinik = res.data[0].alamat;
            this.pos_klinik = res.data[0].pos;
            this.email_klinik = res.data[0].email;
            this.telp_klinik = res.data[0].phone;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    time_handler(event, tref) {
      if (tref === "tstart") {
        this.tstart = event.displayTime;
      }
      if (tref === "tend") {
        this.tend = event.displayTime;
      }
    },
    fetchOptionsDokter: function (search) {
      axios
        .post(
          "../administrator/xhrDokter",
          JSON.stringify({ params: { ref: "dokter", search: search } })
        )
        .then((res) => {
          this.dokter_options = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    selectedOptionDokter: function (value) {
      this.dokter = value;
      this.dokter_id = this.dokter;
      this.fetchJadwalDokter();
      this.clearFields();
    },
    fetchJadwalDokter: function () {
      axios
        .post(
          "../administrator/xhrJadwalDokter",
          JSON.stringify({
            data: {
              ref: "semua",
              kid: this.$refs.kid.value,
              did: this.dokter_id,
              perPage: this.perPage,
              currentPage: this.currentPage,
            },
          })
        )
        .then((res) => {
          this.jadwal = res.data.items;
          this.totalPage = res.data["totalPage"];
          this.index = this.currentPage * this.perPage;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    tambahJadwal: function () {
      var valide = this.validateJadwalF();
      if (valide) {
        axios
          .post(
            "../administrator/xhrJadwal",
            JSON.stringify({
              data: {
                ref: "tambah",
                dokter_id: this.dokter_id,
                klinik_id: this.$refs.kid.value,
                tstart: this.tstart,
                tend: this.tend,
                kuota: this.kuota_pasien,
                biaya_tarif: this.biaya_tarif,
                timezone: this.timezone,
                timestatus: this.timestatus,
              },
            })
          )
          .then((res) => {
            this.fetchJadwalDokter();
          })
          .catch((err) => {
            console.log(err);
          });
      } else {
        this.message = "Data tidak valid";
      }
      setTimeout(() => (this.message = null), 3000);
    },
    statusJadwal: function (val) {
      let t = "";
      for (let i = 0; i < this.jadwal.length; i++) {
        if (this.jadwal[i].id == val) {
          t = this.jadwal[i].status;
        }
      }
      axios
        .post(
          "../administrator/xhrJadwal",
          JSON.stringify({ data: { ref: "status", id: val, status: t } })
        )
        .then((res) => {
          this.fetchJadwalDokter();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    statusDel: function (val) {
      axios
        .post(
          "../administrator/xhrJadwal",
          JSON.stringify({ data: { ref: "delete", id: val } })
        )
        .then((res) => {
          this.fetchJadwalDokter();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    editMode: function (
      id,
      tstart,
      tend,
      kuota_pasien,
      timezone,
      status,
      biaya_tarif
    ) {
      this.actAdd = false;
      this.actEdit = true;
      this.tstart = tstart;
      this.tend = tend;
      this.kuota_pasien = kuota_pasien;
      this.biaya_tarif = biaya_tarif;
      this.timezone = timezone;
      this.timestatus = status;
      this.jadwal_id = id;
    },
    editJadwal: function () {
      var valide = this.validateJadwalF();
      if (valide) {
        axios
          .post(
            "../administrator/xhrJadwal",
            JSON.stringify({
              data: {
                ref: "edit",
                id: this.jadwal_id,
                dokter_id: this.dokter_id,
                klinik_id: this.$refs.kid.value,
                tstart: this.tstart,
                tend: this.tend,
                kuota: this.kuota_pasien,
                biaya_tarif: this.biaya_tarif,
                timezone: this.timezone,
                timestatus: this.timestatus,
              },
            })
          )
          .then((res) => {
            this.fetchJadwalDokter();
            this.actAdd = true;
            this.actEdit = false;
            this.clearFields();
          })
          .catch((err) => {
            console.log(err);
          });
      } else {
        this.message = "Data tidak valid";
      }
      setTimeout(() => (this.message = null), 3000);
    },
    clearFields: function () {
      this.jadwal_id = null;
      this.tstart = { HH: "", mm: "" };
      this.tend = { HH: "", mm: "" };
      this.timezone = "wib";
      this.timestatus = "aktif";
      this.actAdd = true;
      this.actEdit = false;
    },
    convertTimeToNumber: function (time) {
      const hours = Number(time.split(":")[0]);
      const minutes = Number(time.split(":")[1]) / 60;
      return hours + minutes;
    },
    sortIntervals: function (intervals) {
      return intervals.sort((intA, intB) => {
        const startA = this.convertTimeToNumber(intA[0]);
        const endA = this.convertTimeToNumber(intA[1]);
        const startB = this.convertTimeToNumber(intB[0]);
        const endB = this.convertTimeToNumber(intB[1]);

        if (startA > endB) {
          return 1;
        }

        if (startB > endA) {
          return -1;
        }

        return 0;
      });
    },
    isOverlapping: function (intervals, newInterval) {
      const a = this.convertTimeToNumber(newInterval[0]);
      const b = this.convertTimeToNumber(newInterval[1]);
      for (const interval of intervals) {
        const c = this.convertTimeToNumber(interval[0]);
        const d = this.convertTimeToNumber(interval[1]);

        if (a < d && c < b) {
          return true;
        }
      }
      return false;
    },
    validateJadwalF: function () {
      let currentJadwals = [];
      for (let i = 0; i < this.jadwal.length; i++) {
        if (this.jadwal[i].id_dokter === this.dokter_id) {
          currentJadwals.push([this.jadwal[i].tstart, this.jadwal[i].tend]);
        }
      }

      const isOverlap = this.isOverlapping(currentJadwals, [
        this.tstart,
        this.tend,
      ]);
      if (isOverlap) {
        this.message = "Jadwal berbenturan dengan jadwal lain.";
        return false;
      }
      return true;
    },
  },
});
