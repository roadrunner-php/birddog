<template>
  <div class="flex-fill">
    <div class="card shadow-sm" v-if="metrics">
      <div class="card-body">
        <ChartsLine :metrics="metrics" />
      </div>
    </div>
    <UIWarningMessage v-else>
      Metric with name {{ name }} not found.
    </UIWarningMessage>
  </div>
</template>

<script>
import PeriodicallyTimer from '~/mixins/PeriodicallyTimer'

export default {
  mixins: [PeriodicallyTimer],
  props: {
    server: String,
    keys: Array
  },
  data() {
    return {
      metrics: []
    }
  },
  watch: {
    server() {
      this.fetchData()
    }
  },
  methods: {
    async fetchData() {
      let metrics = []
      for (let key of this.keys) {
        const metric = await this.$api.metrics.getByKey(this.server, key)
        metrics.push(metric)
      }

      this.metrics = metrics
    }
  }
}
</script>
