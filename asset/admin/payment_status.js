var application = new Vue({
  el: "#vue_payment_status",
  created() {
    axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
    axios.defaults.headers.post["Content-Type"] = "application/json"; // Set Content-Type untuk POST requests
  },
  data: {
    show: false,
    msg: null,
    search: "",
    items: [], // Defaultnya array
    action: null,
    totalPage: 0, // Defaultnya angka
    currentPage: 1,
    perPage: 8,
    page: null,
    status: null,
  },
  watch: {
    search: _.debounce(function () {
      this.fetchData();
    }, 500),
  },
  computed: {
    getPageCount: function () {
      return this.totalPage;
    },
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    clickCallback: function (pageNum) {
      this.currentPage = Number(pageNum);
      this.fetchData();
    },
    fetchData: function () {
      axios
        .post("../administrator/fetch_payment", {
          search: this.search,
          perPage: this.perPage,
          currentPage: this.currentPage,
        })
        .then((res) => {
          // Ambil data dari 'payment' di respons API
          this.items = res.data["payment"];
          this.totalPage = res.data["totalPage"] || 1; // Default jika tidak ada
          this.index = this.currentPage * this.perPage;
        })
        .catch((err) => {
          console.error("Fetch data error:", err);
        });
    },
    updatePaymentStatus: function (paymentId, newStatus) {
      let statusString = newStatus ? "aktif" : "tidak aktif";

      axios
        .post("../administrator/update_payment_status", {
          id: paymentId,
          aktif: statusString,
        })
        .then((res) => {
          this.fetchData(); // Refresh data setelah update
          this.msg = "Payment status updated successfully.";
          this.show = true;
        })
        .catch((err) => {
          console.error("Update status error:", err);
          this.msg = "Failed to update payment status.";
          this.show = true;
        });
    },
  },
});
