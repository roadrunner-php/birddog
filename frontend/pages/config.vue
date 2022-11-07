<template>
  <div v-if="hasConfig">
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
          <NuxtLink :to="`/`">
            Server <strong>{{ server }}</strong>
          </NuxtLink>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          Config
        </li>
      </ol>
    </nav>

    <h4 class="d-flex align-items-center">
      <b-icon icon="braces" font-scale="1.4" class="mr-3"/> Server config
    </h4>

    <UICode lang="json" v-if="config.version || false">{{ config }}</UICode>
  </div>
</template>

<script>
export default {
  head() {
    return {
      title: `RoadRunner config - ${this.server}`
    }
  },
  computed: {
    server() {
      return this.$store.getters['servers/getDefaultServer']
    },
    config() {
      return this.$store.getters['config/getConfig']
    },
    hasConfig() {
      return this.$store.getters['config/hasConfig']
    }
  }
}
</script>
