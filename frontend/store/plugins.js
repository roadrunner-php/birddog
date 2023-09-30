export const state = () => ({
  plugins: [],
})

export const mutations = {
  setPlugins(state, plugins) {
    state.plugins = plugins.sort((a, b) => (a.name.substr(1) > b.name.substr(1)) ? -1 : ((b.name.substr(1) > a.name.substr(1) ? 1 : 0)))
  },

  updatePlugin(state, plugin) {
    const index = state.plugins.findIndex(p => p.name === plugin.name)
    if (index !== -1) {
      state.plugins.splice(index, 1, plugin)
    }
  },

  deletePlugin(state, plugin) {
    const index = state.plugins.findIndex(p => p.name === plugin)
    if (index !== -1) {
      state.plugins.splice(index, 1)
    }
  }
}

export const getters = {
  getPlugins(state) {
    return state.plugins
  }
}

export const actions = {
  async fetchPlugins({commit}, server) {
    const plugins = await this.$api.plugins.list(server)
    commit('setPlugins', plugins)

    this.$ws.centrifuge.on('publication', function (context) {
      if (context.channel === `server.${server}` && context.data.event === 'plugin.list') {

        commit('updatePlugin', context.data.data)

        console.log('publication', context.data.data)
      }
    });
  }
}
