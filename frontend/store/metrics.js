let timeout = null

const fetchData = async ($api, commit, server) => {
  const data = await $api.metrics.get(server)
  const range = {start: data.start, end: data.end}
  const metrics = data.metrics

  if (metrics instanceof Array && metrics.length > 0) {
    commit('setMetrics', metrics)
    commit('setRange', range)
  } else {
    commit('setMetrics', null)
    commit('setRange', null)
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
  range: null,
  enabled: [],
})

export const mutations = {
  setMetrics(state, metrics) {
    state.metrics = metrics
  },
  setRange(state, range) {
    state.range = range
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
  getRange(state) {
    return state.range || {start: 0, end: 0}
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
