Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#tambah-konsultasi',
    components: { VueTimepicker: VueTimepicker.default },
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        disops: {
            'provinsi': false,
            'klinik': false,
            'dokter': false
        },
        consent: false,
        provinsi: null,
        provinsi_options: [],
        klinik: null,
        klinik_options: [],
        prov_klinik: null,
        kab_klinik: null,
        kec_klinik: null,
        kel_klinik: null,
        dokter: null,
        dokter_id: null,
        dokter_options: [],
        dokter_selected: [],
        jadwal_options: [],
        jadwal_selected: [],
        judul: '',
        keluhan: ''
    },
    watch: {
        consent: function() {
            console.log(this.consent);
        },
        jadwal_selected: function() {
            if (this.jadwal_selected.length <= 0) {
                this.consent = false;
            }
        },
        judul: function() {
            if (this.judul == '') {
                this.consent = false;
            }
        },
        keluhan: function() {
            if (this.keluhan == '') {
                this.consent = false;
            }
        }
    },
    mounted() {
        console.log(this.dokter_selected);
    },
    methods: {
        fetchOptionsProvinsi: function(search) {
            axios.post('../administrator/xhrRefPemda', JSON.stringify({
            params: {
                ref: 'provinsi',
                search: search
            }
            })).then(res => {
                this.provinsi_options = res.data;
            }).catch(err => {
                console.log(err);
            });
        },
        selectedOptionProvinsi: function(value) {
            this.provinsi = value;
            this.kabupaten = null;
            this.kabupaten_options = [];
            this.kecamatan = null;
            this.kecamatan_options = [];
            this.kelurahan = null;
            this.kelurahan_options = [];
            this.klinik = null;
            this.klinik_options = [];
            this.prov_klinik = this.provinsi;
        },
        fetchOptionsKlinik: function(search) {
            axios.post('../administrator/xhrKlinik', JSON.stringify({
            params: {
                ref: 'klinik',
                provinsi: this.provinsi,
                kabupaten: this.kabupaten,
                kecamatan: this.kecamatan,
                kelurahan: this.kelurahan,
                search: search
            }
            })).then(res => {
                this.klinik_options = res.data;
                // console.log(res.data);
            }).catch(err => {
                console.log(err);
            });
        },
        selectedOptionKlinik: function(value) {
            this.klinik = value;
            this.dokter = null;
            this.dokter_options = [];
            this.dokter_selected = [];
            this.jadwal_options = [];
        },
        fetchOptionsDokter: function(search) {
            axios.post('../administrator/xhrDokter', JSON.stringify({
            params: {
                ref: 'dokter-klinik',
                klinik: this.klinik,
                search: search
            }
            })).then(res => {
                this.dokter_options = res.data;
            }).catch(err => {
                console.log(err);
            });
        },
        selectedOptionDokter: function(value) {
            this.dokter = value;
            this.fetchDokter();
        },
        fetchDokter: function() {
            axios.post('../administrator/xhrDokter', JSON.stringify({
                params: {
                    ref: 'dokter-jadwal',
                    klinik: this.klinik,
                    dokter: this.dokter
                }
            })).then(res => {
                if (res.data.res.length > 0) {
                    this.jadwal_options = res.data.res;
                    this.dokter_selected = [this.jadwal_options[0]];
                } else {
                    this.jadwal_options = [];
                    this.dokter_selected = [];
                }
            }).catch(err => {
                console.log(err);
            });
        }
    }
});