Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);
Vue.component("v-chart", VueECharts);
Vue.use(DatePicker);

var application = new Vue({
    el: '#vue-laporan',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        items: null,
        action: null,
        totalPage: null,
        currentPage: 1,
        perPage: 5,
        page: null,
        disops: {
            'klinik': false,
            'dokter': false,
            'layanan': false
        },
        klinik_id: null,
        klinik: null,
        klinik_options: [],
        dokter: null,
        dokter_id: null,
        dokter_options: [],
        layanan: null,
        layanan_options: [],
        gender: null,
        tstart: null,
        tend: null,
        chart_layanan: {},
        chart_gender: {},
        chart_layanan_pie: {}
    },
    watch: {
        klinik_options: function() {
            console.log(this.klinik_options);
        },
        gender: _.debounce(
            function() {
                this.fetchKonsul();
            }, 500
        ),
        tstart: function() {
            this.fetchKonsul();
        },
        tend: function() {
            this.fetchKonsul();
        }
    },
    computed: {
        getPageCount: function() {
            return this.totalPage;
        }
    },
    mounted() {
        this.klinik = this.$refs.klinik_id.value;
        this.klinik_options = [{'id': this.klinik, 'klinik': this.$refs.klinik_name.value}];
        this.fetchKonsul();
        if (this.klinik === null || this.klinik === '') {
            this.klinik = null;
            this.klinik_options = [];
        } else {
            
        }
    },
    methods: {
        exportExcel: function() {
            if (this.tstart !== null) {
                var tstart = this.formatDate(new Date(this.tstart));
            }
            if (this.tend !== null) {
                var tend = this.formatDate(new Date(this.tend));
            }
            axios.post('../administrator/xhrKonsulExcel', JSON.stringify({
                params: {
                    ref: 'konsul',
                    klinik: this.klinik,
                    dokter: this.dokter,
                    layanan: this.layanan,
                    gender: this.gender,
                    tstart: tstart,
                    tend: tend,
                    currentPage: this.currentPage,
                    perPage: this.perPage
                }
            })).then(res => {
                if (this.klinik === null) {var klinik = "";} else {var klinik = this.klinik;}
                if (this.dokter === null) {var dokter = "";} else {var dokter = this.dokter;}
                if (this.layanan === null) {var layanan = "";} else {var layanan = this.layanan}
                if (this.gender === null) {var gender = "";} else {var gender = this.gender}
                if (typeof tstart === 'undefined') {tstart = "";}
                if (typeof tend === 'undefined') {tend = "";}
                
                var baka = 'ref=' + 'konsul' + '&klinik=' + klinik + '&dokter=' + dokter + '&layanan=' + layanan + '&gender=' + gender + '&tstart=' + tstart + '&tend=' + tend + '&currentPage=' + this.currentPage + '&perPage=' + this.perPage;
                window.open('../administrator/xhrKonsulExcel?' + baka);
                // window.location = '../administrator/xhrKonsulExcel';
                // console.log(res.data);
                // const url = window.URL.createObjectURL(new Blob([res.data]));
                // console.log(url);
            }).catch(err => {
                console.log(err);
            });
        },
        formatDate: function(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();
        
            if (month.length < 2) 
                month = '0' + month;
            if (day.length < 2) 
                day = '0' + day;
        
            return [year, month, day].join('-');
        },
        clickCallback: function(pageNum) {
            this.currentPage = Number(pageNum);
            this.fetchKonsul();
        },
        fetchKonsul: function() {
            if (this.tstart !== null) {
                var tstart = this.formatDate(new Date(this.tstart));
            }
            if (this.tend !== null) {
                var tend = this.formatDate(new Date(this.tend));
            }
            axios.post('../administrator/xhrKonsul', JSON.stringify({
                    params: {
                        ref: 'konsul',
                        klinik: this.klinik,
                        dokter: this.dokter,
                        layanan: this.layanan,
                        gender: this.gender,
                        tstart: tstart,
                        tend: tend,
                        currentPage: this.currentPage,
                        perPage: this.perPage
                    }
            })).then(res => {
                this.items = res.data.items;
                this.totalPage = res.data.totalPage;
                this.index = this.currentPage * this.perPage;

                // Charts
                var it = res.data.all;
                var layan = [];
                var gender = [];
                for (var i = 0; i < it.length; i++) {
                    // layanan
                    if (it[i]['kategori_layanan'] !== "") {
                        var d1 = it[i]['kategori_layanan'].split(",");
                        var l1 = it[i]['kategori_layananx'].split(",");
                        layan.push(...l1);
                    }
                    // gender
                    var d2 = it[i]['gender_pasien'];
                    gender.push(d2);
                }

                // charts layanan
                var layanx = layan.reduce((a, c) => (a[c] = (a[c] || 0) + 1, a), Object.create(null));
                var labels_layanan = Object.keys(layanx);
                var values_layanan = Object.values(layanx);

                this.chart_layanan = {
                    toolbox: {
                        feature: {
                            saveAsImage: {
                                pixelRatio: 2
                            }
                        }
                    },
                    xAxis: {
                        type: 'category',
                        data: labels_layanan,
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            data: values_layanan,
                            type: 'bar',
                            showBackground: true,
                            backgroundStyle: {
                                color: 'rgba(180, 180, 180, 0.2)'
                            },
                            label: {
                                show: true,
                                position: 'top',
                                valueAnimation: true
                            }
                        }
                    ]
                }

                // chart gender
                var genderx = gender.reduce((a, c) => (a[c] = (a[c] || 0) + 1, a), Object.create(null));
                var labels_gender = Object.keys(genderx);
                var values_gender = Object.values(genderx);
                
                this.chart_gender = {
                    toolbox: {
                        feature: {
                            saveAsImage: {
                                pixelRatio: 2
                            }
                        }
                    },
                    xAxis: {
                        type: 'category',
                        data: labels_gender,
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            data: values_gender,
                            type: 'bar',
                            showBackground: true,
                            backgroundStyle: {
                                color: 'rgba(180, 180, 180, 0.2)'
                            },
                            label: {
                                show: true,
                                position: 'top',
                                valueAnimation: true
                            }
                        }
                    ]
                }

                // Pie
                x = it;

                // 1
                var o1 = []
                for (var i=0; i < x.length; i++) {
                    if (x[i]['kategori_layananx']) {
                        o1.push(x[i]['kategori_layananx'].split(","));
                    } else {
                        o1.push('None'.split(","));
                    }
                }

                var o2 = [];
                o1.forEach(function (e, i) {
                    e.forEach(function(j, k) {
                        o2.push(j);
                    });
                });

                var o3 = {};
                    o2.forEach(function(x) { 
                    o3[x] = (o3[x] || 0) + 1; 
                });

                var o4 = [];
                Object.entries(o3)
                .reduce((obj, [k, v]) => {
                    o4.push({'value': v, 'name': k})

                }, {});

                // 2
                var oe1 = [];
                var oex = [];
                for (var i = 0; i < x.length; i++) {
                    if (x[i]['kategori_layananx']) {
                        oe1.push(x[i]['kategori_layananx'].split(","));
                        oex.push({ 'ipes': x[i]['kategori_layananx'].split(","), 'gender': x[i]['gender_pasien']});
                    } else {
                        oe1.push('None'.split(","));
                        oex.push({ 'ipes': 'None'.split(","), 'gender': x[i]['gender_pasien'] });
                    }
                }

                var oy = [];
                oex.forEach(function(e, i) {
                    Object.entries(e).reduce((o, [v, k]) => {
                        // console.log(o[1]);
                        o[1].forEach(function (x, y) {
                            // console.log(x);
                            oy.push({'gender': x, 'ipes': k})
                        });
                    });
                });

                var ot1 = {};
                var ot2 = {};
                var ipess = [];
                oy.forEach(function(e, i) {
                    var ipes = Object.values(e)[0];
                    ipess.push(ipes);
                    var gender = Object.values(e)[1];
                    if (gender == 'Laki-laki') {
                        ot1[ipes] = (ot1[ipes] || 0) + 1;
                        ot2[ipes] += 0;
                    } else {
                        ot1[ipes] += 0;
                        ot2[ipes] = (ot2[ipes] || 0) + 1;
                    } 
                });

                var oi1 = [];

                for (const [key, value] of Object.entries(ot1)) {
                    oi1.push({ 'name1': key, 'value1': value })
                }

                var oi2 = [];

                for (const [key, value] of Object.entries(ot2)) {
                    oi2.push({ 'name2': key, 'value2': value })
                }

                var oi3 = [];
                for (var i = 0; i < oi1.length; i++) {
                    var name = o4[i]['name'];
                    var value = o4[i]['value'];
                    var name1 = 'Gender (Pria)';
                    var value1 = oi1[i]['value1'];
                    var name2 = 'Gender (Wanita)';
                    var value2 = oi2[i]['value2'];

                    if (isNaN(o4[i]['value'])) {
                        var value = 0;
                    }

                    if (isNaN(oi1[i]['value1'])) {
                        var value1 = 0;
                    }

                    if (isNaN(oi2[i]['value2'])) {
                        var value2 = 0;
                    }

                    oi3.push({
                        'name': name,
                        'value': value,
                        'name1': name1,
                        'value1': value1,
                        'name2': name2,
                        'value2': value2
                    });
                }

                console.log(oi3)

                this.chart_layanan_pie = {
                    title: {
                        show: false,
                        text: 'IPES',
                        subtext: 'Data IPES',
                        left: 'center'
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: function (params) {
                            return `<b>${params.seriesName}</b><br />
                                ${params.name}: ${params.data.value}<br />
                                ${params.data.name1}: ${params.data.value1}<br />
                                ${params.data.name2}: ${params.data.value2}`;
                        }
                    },
                    legend: {
                        show: false,
                        orient: 'vertical',
                        left: 'left'
                    },
                    series: [
                      {
                        name: 'IPES',
                        type: 'pie',
                        radius: [40, 140],
                        center: ['50%', '50%'],
                        roseType: 'area',
                        itemStyle: {
                            borderRadius: 8
                        },
                        data: oi3,
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                          }
                        }
                      }
                    ]   
                }
                
            }).catch(err => {
                console.log(err);
            });
        },
        fetchOptionsKlinik: function(search) {
            if (this.$refs.klinik_id.value == '') {
                axios.post('../administrator/xhrKlinik', JSON.stringify({
                params: {
                    ref: 'klinik',
                    search: search
                }
                })).then(res => {
                    this.klinik_options = res.data;
                    console.log(res.data);
                }).catch(err => {
                    console.log(err);
                });
            }
        },
        selectedOptionKlinik: function(value) {
            this.klinik = value;
            this.fetchKonsul();
        },
        fetchLayanan: function(search) {
            axios.post('../konsultasi/xhrLayanan', JSON.stringify({
            params: {
                ref: 'layanan',
                search: search
            }
            })).then(res => {
                this.layanan_options = res.data;
            }).catch(err => {
                console.log(err);
            });
        },
        selectedLayanan: function(value) {
            this.layanan = value;
            this.fetchKonsul();
        },
    }
});