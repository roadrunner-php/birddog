<template>
  <div class="card border-primary">
    <div class="card-header d-flex justify-content-between">
      <h6 class="mb-0">Create chart</h6>

      <div v-if="hasSelected">
        <b-button size="sm" variant="primary" @click="create">
          <b-icon icon="plus"/>
          Create
        </b-button>
        <b-button size="sm" variant="outline-danger" class="ml-2" @click="clear">
          <b-icon icon="x"/>
          Clear
        </b-button>
      </div>
    </div>

    <MetricsItem v-if="hasSelected"
                 :server="server"
                 :metric="selected"
                 :showCloseButton="false"
    />

    <div class="card-body p-2 d-flex flex-wrap">
      <MetricsPartialsSelectableMetric
        class="mr-2 mb-2"
        v-for="metric in metrics"
        :key="metric.name"
        :metric="metric"
        @toggle="toggle"
      />
    </div>
  </div>
</template>

<script>
function randomString() {
  return (Math.random() + 1).toString(36).substring(3)
}

export default {
  props: {
    server: String,
  },
  data() {
    return {
      selected: {id: null, metrics: []},
      selectedIds: []
    }
  },
  mounted() {
    this.clear()
  },
  methods: {
    create() {
      this.$store.commit('metrics/enable', this.selected)
      this.clear()
    },
    clear() {
      const d = new Date()
      this.selected = {id: randomString(), metrics: []}
      this.selectedIds = []
    },
    toggle(name, tag) {
      let metricId = name
      if (tag) {
        metricId = `${name}-{${tag.name}="${tag.value}"}`
      }

      if (this.enabled(metricId)) {
        this.selected.metrics = this.selected.metrics.filter(m => m.id !== metricId)
        this.selectedIds = this.selectedIds.filter(id => id !== metricId)
      } else {
        let tags = []
        if (tag) {
          tags = [tag]
        }

        this.selected.metrics.push({id: metricId, name, tags})
        this.selectedIds.push(metricId)
      }
    },
    enabled(name, tag) {
      let metricId = name
      if (tag) {
        metricId = `${name}-{${tag.name}="${tag.value}"}`
      }
      return this.selectedIds.includes(metricId)
    }
  },
  computed: {
    metrics() {
      return this.$store.getters['metrics/getMetrics']
    },
    hasSelected() {
      return this.selected.metrics.length > 0
    }
  }
}
</script>
