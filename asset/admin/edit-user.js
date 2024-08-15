Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#edit-user',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        level: null,
        disops: {
            'klinik': false
        },
        klinik: null,
        klinik_options: [],
        user_id: null
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
      this.user_id = this.$refs.uid.value;
      this.fetchKlinik();
    },
    methods: {
      fetchKlinik: function() {
         axios.post('../xhrMyKlinik', JSON.stringify({
         params: {
               ref: 'klinik-single',
               user_id: this.user_id
         }
         })).then(res => {
               this.klinik_options = res.data;
               this.klinik = res.data[0].id;
         }).catch(err => {
               console.log(err);
         });
      },
      fetchOptionsKlinik: function(search) {
         axios.post('../xhrKlinik', JSON.stringify({
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