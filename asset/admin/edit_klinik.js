Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#vue-regklinik',
    components: { VueTimepicker: VueTimepicker.default },
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        valid: false,
        show: false,
        transitionName: 'fade',
        msg: null,
        disops: {
            'provinsi': false,
            'kabupaten': false,
            'kecamatan': false,
            'kelurahan': false
        },
        provinsi: null,
        provinsi_options: [],
        kabupaten: null,
        kabupaten_options: [],
        kecamatan: null,
        kecamatan_options: [],
        kelurahan: null,
        kelurahan_options: [],
        action: null,  
        prov_klinik: null,
        kab_klinik: null,
        kec_klinik: null,
        kel_klinik: null,
        nama_klinik: null,
        alamat_klinik: null,
        pos_klinik: null,
        email_klinik: null,
        telp_klinik: null,
        foto_klinik: null,
        status: null
    },
    watch: {
    },
    mounted() {
        let kid = this.$refs.kid.value;
        this.fetchData(kid);
    },
    methods: {
        fetchData: function(kid) {
            axios.post('../administrator/fetch_single_klinik', JSON.stringify({
                headers: {
                    'Access-Control-Allow-Origin': '*',
                  },
               data: {
                  kid: kid
               }
            })).then(res => {
                if (res.data.length > 0) {
                    console.log(res.data);
                    this.status = res.data[0].status,
                    this.foto_klinik = res.data[0].foto;
                    this.nama_klinik = res.data[0].klinik;
                    this.alamat_klinik = res.data[0].alamat;
                    this.pos_klinik = res.data[0].pos;
                    this.email_klinik = res.data[0].email;
                    this.telp_klinik = res.data[0].phone;
                    this.fetchOptionsProvinsi(res.data[0].provinsi);
                    this.selectedOptionProvinsi(res.data[0].provinsi_id);
                    this.fetchOptionsKabupaten(res.data[0].kabupaten);
                    this.selectedOptionKabupaten(res.data[0].kabupaten_id);
                    this.fetchOptionsKecamatan(res.data[0].kecamatan);
                    this.selectedOptionKecamatan(res.data[0].kecamatan_id);
                    this.fetchOptionsKelurahan(res.data[0].kelurahan);
                    this.selectedOptionKelurahan(res.data[0].kelurahan_id);
               }
            }).catch(err => {
               console.log(err);
            })
        },
        fetchOptionsProvinsi: function(search) {
            axios.post('../administrator/xhrRefPemda', JSON.stringify({
            params: {
                ref: 'provinsi',
                search: search
            }
            })).then(res => {
            this.provinsi_options = res.data;
            // console.log(this.provinsi_options);
            }).catch(err => {
            console.log(err);
            });
        },
        selectedOptionProvinsi: function(value) {
            this.provinsi = value;
            console.log("provinsi: " + this.provinsi);
            this.kabupaten = null;
            this.kabupaten_options = [];
            this.kecamatan = null;
            this.kecamatan_options = [];
            this.kelurahan = null;
            this.kelurahan_options = [];
            this.prov_klinik = this.provinsi;
        },
        fetchOptionsKabupaten: function(search) {
            axios.post('../administrator/xhrRefPemda', JSON.stringify({
            params: {
                ref: 'kabupaten',
                provinsi: this.provinsi,
                search: search
            }
            })).then(res => {
            this.kabupaten_options = res.data;
            }).catch(err => {
            console.log(err);
            });
        },
        selectedOptionKabupaten: function(value) {
            this.kabupaten = value;
            console.log("kabupaten: " + this.kabupaten);
            this.kecamatan = null;
            this.kecamatan_options = [];
            this.kelurahan = null;
            this.kelurahan_options = [];
            this.kab_klinik = this.kabupaten;
        },
        fetchOptionsKecamatan: function(search) {
            axios.post('../administrator/xhrRefPemda', JSON.stringify({
            params: {
                ref: 'kecamatan',
                kabupaten: this.kabupaten,
                search: search
            }
            })).then(res => {
            this.kecamatan_options = res.data;
            }).catch(err => {
            console.log(err);
            });
        },
        selectedOptionKecamatan: function(value) {
            this.kecamatan = value;
            console.log("kecamatan: " + this.kecamatan);
            this.kelurahan = null;
            this.kelurahan_options = [];
            this.kec_klinik = this.kecamatan;
        },
        fetchOptionsKelurahan: function(search) {
            axios.post('../administrator/xhrRefPemda', JSON.stringify({
            params: {
                ref: 'kelurahan',
                kabupaten: this.kabupaten,
                kecamatan: this.kecamatan,
                search: search
            }
            })).then(res => {
            this.kelurahan_options = res.data;
            }).catch(err => {
            console.log(err);
            });
        },
        selectedOptionKelurahan: function(value) {
            this.kelurahan = value;
            console.log("kelurahan: " + this.kelurahan);
            this.kel_klinik = this.kelurahan;
        }
    }
});

// Zoom foto klinik
Zoom(document.querySelector(".zoomable"));