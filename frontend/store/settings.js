export const state = () => ({
  settings: {},
})

export const mutations = {
  setSettings(state, settings) {
    state.settings = settings
  },
  updateCharts(state, charts) {
    state.settings['charts'] = charts
    this.dispatch('settings/saveSettings', state.settings)
  },
  setDefaultServer(state, server) {
    state.settings['default_server'] = server
    this.dispatch('settings/saveSettings', state.settings)
  }
}

export const getters = {
  getDefaultServer(state) {
    return state.settings['default_server'] || null
  },
  getCharts(state) {
    return state.settings['charts'] || []
  }
}

export const actions = {
  async fetchSettings({commit}) {
    const settings = await this.$settings.getSettings()
    commit('setSettings', settings)
  },

  async saveSettings({state}, settings) {
    await this.$settings.store(
      JSON.parse(JSON.stringify(Object.assign({}, settings)))
    )
  }
}
