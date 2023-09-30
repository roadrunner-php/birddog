export default {
  mounted() {
    this.refreshPeriodically()
  },
  beforeDestroy() {
    this.resetPeriodically()
  },
  methods: {
    async fetchData() {

    },
    resetPeriodically() {
      clearTimeout(this.timeout)
    },
    refreshPeriodically() {
      // Promise.all([
        this.fetchData()
      // ]).then(() => {
      //   this.timeout = setTimeout(() => {
      //     this.refreshPeriodically();
      //   }, this.refreshTimeout || 5000);
      // });
    }
  }
}
