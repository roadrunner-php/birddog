export const state = () => ({
  plugins: [],
})

export const mutations = {
  setPlugins(state, plugins) {
    state.plugins = plugins.sort((a,b) => (a.name.substr(1) > b.name.substr(1)) ? -1 : ((b.name.substr(1) > a.name.substr(1) ? 1 : 0)))
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
  }
}
