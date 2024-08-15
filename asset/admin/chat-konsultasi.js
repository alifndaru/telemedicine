var application = new Vue({
    el: '#navue',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        all: 0,
        items: []
    },
    watch: {
    },
    computed: {
    },
    mounted() {
        this.fetchChats();
        setInterval(() => this.fetchChats(), 3000);
        console.log(4);
    },
    updated() {
    },
    methods: {
        fetchChats: function() {
            axios.post('../konsultasi/unread', JSON.stringify({
                ref: 'chats'
            })).then(res => {
                console.log(res.data);
                this.all = res.data.all;
                this.items = res.data.details;
            }).catch(err => {
                console.log(err);
            });
        }
    }
});