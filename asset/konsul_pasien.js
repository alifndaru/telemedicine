var application = new Vue({
    el: '#vue_konsul_pasien',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        pasien_id: null,
        dokter_id: null,
        dokter: null,
        chats: null,
        cinput: null,
        file: null,
        cstatus: null,
        tstart: null,
        tend: null,
        interval_id: null,
        statusx: null
    },
    watch: {
        cinput: _.debounce(
            function() {
                this.fetchChats();
            }, 500
        ),
        statusx: function() {
            console.log(this.interval_id);
            if (this.statusx === 'Y') {
                this.timeCounter();
            } else if (this.statusx === 'N0') {
                document.getElementById("time-counter").innerHTML = "Belum mulai";
            } else {
                clearInterval(this.interval_id);
                document.getElementById("time-counter").innerHTML = "0h 0m 0s";
            }
        }
    },
    computed: {
    },
    mounted() {
        this.fetchChats();
        setInterval(() => this.fetchChats(), 3000);
    },
    updated() {
        this.scrollToEnd();
    },
    methods: {
        uploadFile: function() {
            this.file = this.$refs.file.files[0];
            // console.log(this.file);
            const formData = new FormData();
            formData.append('ref', 'file');
            formData.append('file', this.file);
            formData.append('kid', this.$refs.kid.value);
            const headers = { 'Content-Type': 'multipart/form-data' };
            axios.post('../konsul_chat', formData, { headers }).then((res) => {
                res.data.files; // binary representation of the file
                res.status; // HTTP status
                if (res.data.info === 'failed') {
                    console.log('failed');
                } else {
                    var fi = res.data.info.substring(0, 25);
                    if (fi === 'Ukuran file terlalu besar') {
                        alert(res.data.info);
                    }
                    console.log(res.data.info);
                }
                this.fetchChats();
            });
        },
        fetchChats: function() {
            axios.post('../konsul_chat', JSON.stringify({
                ref: 'chats',
                kid: this.$refs.kid.value
            })).then(res => {
                this.pasien_id = this.$refs.pasien.value;
                this.dokter_id = this.$refs.dokter.value;
                this.cstatus = res.data[0].status;
                this.dokter = res.data[0].dokter;
                this.tstart = res.data[0].tstart;
                this.tend = res.data[0].tend;
                this.keluhan = res.data[0].isi_konsul;
                var el = document.createElement("div");
                el.className = "bs-callout bs-callout-info";
                el.innerHTML = this.keluhan;
                this.$refs.keluhan.replaceChildren(el);
                this.chats = res.data;
                this.scrollToEnd();
                this.statusx = res.data[0].statusx;
            }).catch(err => {
                console.log(err);
            });
        },
        cinputEnter: function() {
            if (this.dokter === null || this.dokter === '') {
                this.fetchChats();
                if (this.dokter !== null || this.dokter !== '') {
                    window.location.reload();
                }
            } else {
                axios.post('../konsul_chat', JSON.stringify({
                    ref: 'kirim',
                    kid: this.$refs.kid.value,
                    chat: this.cinput 
                })).then(res => {
                    this.fetchChats();
                }).catch(err => {
                    console.log(err);
                });
                this.cinput = "";
            }
        },
        scrollToEnd: function() {
            var container = this.$el.querySelector(".chat-history");
            var scrollHeight = container.scrollHeight;
            container.scrollTop = scrollHeight;
        },
        timeCounter: function() {
            const m2 = new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta", hour12: false, dateStyle: 'medium'});
            const t1 = new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta", hour12: false, timeStyle: 'medium'});
            const dx = m2 + ' ' + this.tend;
            // console.log(dx);

            // Set the date we're counting down to
            var countDownDate = new Date(dx).getTime();
            // console.log(countDownDate);

            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                // document.getElementById("time-counter").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                document.getElementById("time-counter").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("time-counter").innerHTML = "0h 0m 0s";
                }
            }, 1000);

            this.interval_id = x;
        }
    }
});