export const state = () => ({
  servers: [],
  selectedServer: null,
  defaultServer: null
})

export const mutations = {
  setServers(state, servers) {
    state.servers = servers
  },
  setDefaultServer(state, server) {
    if (state.defaultServer) {
      this.$ws.serverChannel(state.defaultServer).unsubscribe()
    }

    this.$ws.serverChannel(server)

    state.defaultServer = server

    this.dispatch('config/fetchConfig', server)
    this.dispatch('metrics/fetchMetrics', server)

  }
}

export const getters = {
  getServers(state) {
    return state.servers
  },
  getDefaultServer(state) {
    if (state.selectedServer === null) {
      return state.defaultServer || state.servers[0] || null
    }
    return state.selectedServer
  }
}

export const actions = {
  async fetchServers({commit}) {
    const resp = await this.$api.servers.list()
    commit('setServers', resp.servers)
    commit('setDefaultServer', resp.default)
  }
}
