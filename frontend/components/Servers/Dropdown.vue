<template>
  <div>
    <b-dropdown
      variant="outline-primary"
      :text="`Server: ${defaultServer}` || `Select server`"
    >
      <b-dropdown-item
        v-for="server in servers"
        :key="server"
        @click="selectServer(server)"
      >
        {{ server }}
      </b-dropdown-item>
    </b-dropdown>
  </div>
</template>

<script>
export default {
  async fetch() {
    await this.$store.dispatch('servers/fetchServers')
  },
  methods: {
    selectServer(server) {
      this.$store.commit('servers/setDefaultServer', server)
    }
  },
  computed: {
    servers() {
      return this.$store.getters['servers/getServers']
    },
    defaultServer() {
      return this.$store.getters['servers/getDefaultServer']
    }
  }
}
</script>
