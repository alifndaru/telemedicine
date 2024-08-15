Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#tambah-user',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        level: null,
        disops: {
            'klinik': false
        },
        klinik: null,
        klinik_options: []
    },
    watch: {
        level: function() {
            if (this.level !== 'klinik') {
                this.klinik_options = [];
                this.klinik = null;
            }
        }
    },
    computed: {
    },
    mounted() {
    },
    methods: {
        fetchOptionsKlinik: function(search) {
            axios.post('../administrator/xhrKlinik', JSON.stringify({
            params: {
                ref: 'klinik',
                search: search
            }
            })).then(res => {
                this.klinik_options = res.data;
            }).catch(err => {
                console.log(err);
            });
        },
        selectedOptionKlinik: function(value) {
            this.klinik = value;
        },
    }
});