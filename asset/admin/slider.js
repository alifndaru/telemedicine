var application = new Vue({
    el: '#slider',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        id1: null,
        file1: null,
        image1: null,
        title1: null,
        subtitle1: null,
        id2: null,
        file2: null,
        image2: null,
        title2: null,
        subtitle2: null,
        id3: null,
        file3: null,
        image3: null,
        title3: null,
        subtitle3: null,
        id4: null,
        file4: null,
        image4: null,
        title4: null,
        subtitle4: null,
        id5: null,
        file5: null,
        image5: null,
        title5: null,
        subtitle5: null,
        status1: 'aktif',
        status2: 'aktif',
        status3: 'aktif',
        status4: 'aktif',
        status5: 'aktif'
    },
    watch: {
    },
    computed: {
    },
    mounted() {
        this.fetchSlider();
    },
    methods: {
        resetFile: function() {
            this.file1 = null;
            this.file2 = null;
            this.file3 = null;
            this.file4 = null;
            this.file5 = null;
        },
        fetchSlider: function() {
            axios.post('../administrator/slider_', JSON.stringify({
                ref: 'slider',
            })).then(res => {
                var x = res.data;
                for (var i=0; i < x.length; i++) {
                    if (i == 0) {
                        this.id1 = x[i].id;
                        this.image1 = '../asset/foto_slider/' + x[i].image;
                        this.title1 = x[i].title;
                        this.subtitle1 = x[i].sub_title;
                        this.status1 = x[i].status;
                    }

                    if (i == 1) {
                        this.id2 = x[i].id;
                        this.image2 = '../asset/foto_slider/' + x[i].image;
                        this.title2 = x[i].title;
                        this.subtitle2 = x[i].sub_title;
                        this.status2 = x[i].status;
                    }

                    if (i == 2) {
                        this.id3 = x[i].id;
                        this.image3 = '../asset/foto_slider/' + x[i].image;
                        this.title3 = x[i].title;
                        this.subtitle3 = x[i].sub_title;
                        this.status3 = x[i].status;
                    }

                    if (i == 3) {
                        this.id4 = x[i].id;
                        this.image4 = '../asset/foto_slider/' + x[i].image;
                        this.title4 = x[i].title;
                        this.subtitle4 = x[i].sub_title;
                        this.status4 = x[i].status;
                    }

                    if (i == 4) {
                        this.id5 = x[i].id;
                        this.image5 = '../asset/foto_slider/' + x[i].image;
                        this.title5 = x[i].title;
                        this.subtitle5 = x[i].sub_title;
                        this.status5 = x[i].status;
                    }
                }
            }).catch(err => {
                console.log(err);
            });
        },
        submit: function(d) {
            var id = null;
            var file = null;
            var title = null;
            var subtitle = null;
            var status = null;

            if (d === 1) {
                id = d;
                file = this.$refs.file1.files[0];
                this.image1 = '../asset/foto_slider/loading-preview.gif';
                title = this.title1;
                subtitle = this.subtitle1;
                status = this.status1;
            }

            if (d === 2) {
                id = d;
                file = this.$refs.file2.files[0];
                this.image2 = '../asset/foto_slider/loading-preview.gif';
                title = this.title2;
                subtitle = this.subtitle2;
                status = this.status2;
            }

            if (d === 3) {
                id = d;
                file = this.$refs.file3.files[0];
                this.image3 = '../asset/foto_slider/loading-preview.gif';
                title = this.title3;
                subtitle = this.subtitle3;
                status = this.status3;
            }

            if (d === 4) {
                id = d;
                file = this.$refs.file4.files[0];
                this.image4 = '../asset/foto_slider/loading-preview.gif';
                title = this.title4;
                subtitle = this.subtitle4;
                status = this.status4;
            }

            if (d === 5) {
                id = d;
                file = this.$refs.file5.files[0];
                this.image5 = '../asset/foto_slider/loading-preview.gif';
                title = this.title5;
                subtitle = this.subtitle5;
                status = this.status5;
            }

            const formData = new FormData();
            formData.append('id', id);
            formData.append('file', file);
            formData.append('title', title);
            formData.append('subtitle', subtitle);
            formData.append('status', status);
            const headers = { 'Content-Type': 'multipart/form-data' };
            axios.post('../administrator/slider_process', formData, { headers }).then((res) => {
                if (res.data.info == 'berhasil') {
                    setTimeout(() => {
                        this.fetchSlider();
                        this.resetFile();
                    }, 2000);
                }
            });
        }
    }
})