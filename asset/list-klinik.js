Vue.component('paginate', VuejsPaginate);
var application = new Vue({
    el: '#list-klinik',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        show: false,
        msg: null,
        search: "",
        sfilter: 'klinik',
        items: null,
        ritems: null,
        action: null,
        totalPage: null,
        currentPage: 1,
        perPage: 8,
        page: null,
        status: null,
    },
    watch: {
        search: _.debounce(
            function() {
               this.fetchData();
            }, 500
        ),
    },
    computed: {
        getPageCount: function() {
            return this.totalPage;
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        clickCallback: function(pageNum) {
            this.currentPage = Number(pageNum);
            this.fetchData();
        },
        fetchData: function() {
            axios.post('user/fetch_klinik', JSON.stringify({
                data: {
                    filter: this.sfilter,
                    search: this.search,
                    perPage: this.perPage,
                    currentPage: this.currentPage
                }
            })).then(res => {
                // console.log(res.data);
                this.items = res.data['items'];
                this.ritems = res.data['recoms'];

                console.log(this.ritems);
                res.data['items'].forEach(e => {
                    if (e.kode_bc_eselon3) {
                        this.checkedWilayah.push(e.id_wilayah);
                    }
                });
                this.totalPage = res.data['totalPage'];
                this.index = this.currentPage * this.perPage;
            }).catch(err => {
                console.log(err);
            });
        }
    }
});