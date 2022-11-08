let timeout = null

const fetchData = async ($api, commit, server) => {
  const metrics = await $api.metrics.get(server)
  if (metrics instanceof Array && metrics.length > 0) {
    commit('setMetrics', metrics)
  } else {
    commit('setMetrics', null)
  }
}

const refreshPeriodically = ($api, commit, server) => {
  Promise.all([
    fetchData($api, commit, server),
  ]).then(() => {
    timeout = setTimeout(() => {
      refreshPeriodically($api, commit, server);
    }, 5000);
  });
}


export const state = () => ({
  metrics: null,
  enabled: [],
})

export const mutations = {
  setMetrics(state, metrics) {
    state.metrics = metrics
  },
  enable(state, metrics) {
    state.enabled.push(metrics)
  },
  disable(state, metric) {
    state.enabled = state.enabled.filter((m) => m.id !== metric.id)
  }
}

export const getters = {
  getEnabledMetrics(state) {
    return state.enabled
  },
  getMetrics(state) {
    return state.metrics
  },
  hasMetrics(state) {
    return state.metrics !== null
  }
}

export const actions = {
  async fetchMetrics({commit}, server) {
    clearTimeout(timeout)
    refreshPeriodically(this.$api, commit, server)
  }
}
