<template>
  <div v-if="server">
    <PluginsList :server="server"/>
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
