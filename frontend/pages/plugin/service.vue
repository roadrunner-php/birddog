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

    <ServicesList :server="server" />
  </div>
</template>

<script>
export default {
  computed: {
    server() {
      return this.$store.getters['servers/getDefaultServer']
    }
  }
}
</script>

