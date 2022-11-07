let timeout = null

const fetchData = async ($api, commit, server) => {
  const metrics = await $api.metrics.get(server)
  if (metrics instanceof Array) {
    commit('setMetrics', metrics)
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
})

export const mutations = {
  setMetrics(state, metrics) {
    state.metrics = metrics
  }
}

export const getters = {
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
