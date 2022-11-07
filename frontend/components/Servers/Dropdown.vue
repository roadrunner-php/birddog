<template>
  <div>
    <b-dropdown
      v-if="hasMultipleServers"
      variant="primary"
      size="sm"
      no-caret
    >
      <template #button-content>
        <span v-if="defaultServer">
          <b-icon icon="broadcast-pin" class="mr-2" font-scale="1.5" />
          <small>Server</small> <strong>{{ defaultServer }}</strong>
        </span>
        <span v-else>Select server</span>
      </template>

      <b-dropdown-item
        v-for="server in servers"
        :key="server"
        @click="selectServer(server)"
      >
        {{ server }}
      </b-dropdown-item>
    </b-dropdown>
    <div v-else>
      <span class="badge badge-primary d-flex align-items-center p-2">
        <b-icon icon="broadcast-pin" class="mr-2" font-scale="1.5" />
        Server <strong class="ml-1">{{ defaultServer }}</strong>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    selectServer(server) {
      this.$store.commit('servers/setDefaultServer', server)
    }
  },
  mounted() {
    this.$ws.channel('public')
      .listen('server.registered', ({ server }) => {
        this.$store.dispatch('servers/fetchServers')
      })
  },
  computed: {
    hasMultipleServers() {
      return this.servers.length > 1
    },
    servers() {
      return this.$store.getters['servers/getServers']
    },
    defaultServer() {
      return this.$store.getters['servers/getDefaultServer']
    }
  }
}
</script>
