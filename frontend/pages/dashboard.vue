<template>
  <div v-if="server">
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
          <NuxtLink :to="`/`">
            Server <strong>{{ server }}</strong>
          </NuxtLink>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          Metrics
        </li>
      </ol>
    </nav>

    <h4 class="d-flex align-items-center">
      <b-icon icon="graph-up" font-scale="1.4" class="mr-3"/> Metrics dashboard
    </h4>

    <MetricsDashboard :server="server" class="mt-4" />
  </div>
</template>

<script>
export default {
  head() {
    return {
      title: `Metrics dashboard - ${this.server}`
    }
  },
  computed: {
    server() {
      return this.$store.getters['servers/getDefaultServer']
    }
  }
}
</script>
