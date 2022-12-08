import {
  has as hasObjectValue,
} from 'lodash'

const defaultSettings = {
  collapsed_plugins: {},
  settings: {
    charts: []
  }
}

export const state = () => ({
  collapsed_plugins: {},
  settings: {
    charts: {}
  }
})

export const mutations = {
  setSettings(state, settings) {
    this.state.settings =  Object.assign(this.state.settings, settings)
  },
  updateCharts(state, charts) {
    state.settings['charts'] = charts
    this.dispatch('settings/saveSettings')
  },
  setDefaultServer(state, server) {
    state.settings['default_server'] = server
    this.dispatch('settings/saveSettings')
  },
  setPluginState(state, {server, plugin}) {
    const currentState = this.getters['settings/isCollapsedPlugin'](server, plugin)

    if (!hasObjectValue(state.collapsed_plugins, `${server}`)) {
      state.collapsed_plugins = Object.assign({[server]: {}}, state.collapsed_plugins)
    }

    if (!hasObjectValue(state.collapsed_plugins, `${server}.${plugin}`)) {
      state.collapsed_plugins[server] = Object.assign({[plugin]: false}, state.collapsed_plugins[server])
    }

    state.collapsed_plugins[server][plugin] = !currentState
    this.dispatch('settings/saveSettings')
  }
}

export const getters = {
  getDefaultServer(state) {
    return state.settings['default_server'] || null
  },
  getCharts(state) {
    return state.settings['charts'] || []
  },
  isCollapsedPlugin: (state) => (server, plugin) => {
    if (!hasObjectValue(state.collapsed_plugins, `${server}`)) {
      return false
    }

    return state.collapsed_plugins[server][plugin] || false
  }
}

export const actions = {
  async fetchSettings({commit}) {
    const settings = await this.$settings.getSettings()
    commit('setSettings', Object.assign(defaultSettings, settings))
  },

  saveSettings({state}) {
    this.$settings.store(
      JSON.parse(JSON.stringify(Object.assign(defaultSettings, state)))
    )
  }
}
