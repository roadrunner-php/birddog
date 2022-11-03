export const state = () => ({
  config: {},
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
}

export const actions = {
  async fetchConfig({commit}, server) {
    const config = await this.$api.config.get(server)
    commit('setConfig', config || {})
  }
}
