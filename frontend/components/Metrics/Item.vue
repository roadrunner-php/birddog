<template>
  <div class="flex-fill">
    <div class="card shadow-sm position-relative" v-if="hasMetrics">
      <button class="btn btn-light-outline btn-sm position-absolute" style="top: 0; right: 0" @click="disable"
              v-if="showCloseButton">
        <b-icon icon="x"/>
      </button>
      <div class="py-2 pl-2">
        <ChartsLine :metrics="m"/>
      </div>
    </div>
    <UIWarningMessage v-else>
      There is no metric.
    </UIWarningMessage>
  </div>
</template>

<script>
import PeriodicallyTimer from '~/mixins/PeriodicallyTimer'

export default {
  mixins: [PeriodicallyTimer],
  props: {
    server: String,
    metric: Object,
    showCloseButton: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      m: []
    }
  },
  watch: {
    'metric.metrics'() {
      this.fetchData()
    },
    server() {
      this.fetchData()
    }
  },
  methods: {
    disable() {
      this.$store.commit('metrics/disable', this.metric)
    },
    async fetchData() {
      let metrics = []
      for (let m of this.metric.metrics) {
        let t = {}

        for (let tag of m.tags) {
          t[tag.name] = tag.value
        }

        const metric = await this.$api.metrics.getRangeByKey(this.server, m.name, t)
        metrics.push(metric)
      }

      this.m = metrics
    }
  },
  computed: {
    hasMetrics() {
      return this.m.length > 0
    }
  }
}
</script>
