export const state = () => ({
  config: null,
})

export const mutations = {
  setConfig(state, config) {
    state.config = config
  }
}

export const getters = {
  getConfig(state) {
    return state.config
  },
  hasConfig(state) {
    return state.config !== null
  }
}

export const actions = {
  async fetchConfig({commit}, server) {
    try {
      const config = await this.$api.config.get(server)
      commit('setConfig', config || {})
    } catch {
      // Not supports
    }
  }
}
