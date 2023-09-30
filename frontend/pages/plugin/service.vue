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
          <strong>Service</strong> plugin
        </li>
      </ol>
    </nav>

    <h4 class="mb-4 d-flex align-items-center">
      <b-icon icon="puzzle" font-scale="1.4" class="me-3"/> Service plugin
    </h4>

    <ServicesList :server="server" />
  </div>
</template>

<script>
export default {
  head() {
    return {
      title: `Service plugin - ${this.server}`
    }
  },
  computed: {
    server() {
      return this.$store.getters['servers/getDefaultServer']
    }
  }
}
</script>

