export const state = () => ({
  config: null,
  version: '0.0'
})

export const mutations = {
  setConfig(state, config) {
    state.config = config
  },
  setVersion(state, version) {
    state.version = version
  }
}

export const getters = {
  getVersion(state) {
    return state.version
  },
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
      const config = await this.$api.rr.config(server)
      commit('setConfig', config || {})
    } catch {
      // Not supports
    }
    try {
      const version = await this.$api.rr.version(server)
      commit('setVersion', version)
    } catch {
      // Not supports
    }
  }
}
