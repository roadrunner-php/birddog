<template>
  <div class="d-flex flex-column flex-shrink-0">
    <MetricsItem :server="server"
                 v-for="metrics in enabledMetrics"
                 :metric="metrics"
                 :key="metrics.id"
                 class="mb-4"/>
    <MetricsCreateChart :server="server"/>
  </div>
</template>

<script>
export default {
  props: {
    server: String,
  },
  computed: {
    enabledMetrics() {
      return this.$store.getters['metrics/getEnabledMetrics']
    }
  }
}
</script>
<style type="text/css">
.overflow-scroll {
  overflow-y: scroll;
}
</style>
