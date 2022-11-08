<template>
  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <h6 class="mb-0">New metric</h6>

      <div v-if="hasSelected">
        <button class="btn btn-primary bt-sm" @click="create">
          <b-icon icon="plus"/>
          Create
        </button>
        <button class="btn border btn-light btn-sm ml-4" @click="clear">
          <b-icon icon="x"/>
          Clear
        </button>
      </div>
    </div>
    <div class="card-body p-2" style="max-height: 100px; overflow-y: auto">
      <small
        :class="{'badge-primary': enabled(metric), 'badge-light': !enabled(metric) }"
        style="cursor: pointer"
        class="badge border"
        v-for="metric in metrics"
        @click="toggle(metric)"
      >
        {{ metric.name }}
        <small v-for="tag in metric.tags">
          {{ tag.name }}={{ tag.value }}
        </small>
      </small>
    </div>

    <MetricsItem v-if="hasSelected" :server="server" :metric="selected"/>
  </div>
</template>

<script>
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
      this.selected = {id: d.getMilliseconds(), metrics: []}
      this.selectedIds = []
    },
    toggle(metric) {
      if (this.enabled(metric)) {
        this.selected.metrics = this.selected.metrics.filter(m => m.id !== metric.id)
        this.selectedIds = this.selectedIds.filter(id => id !== metric.id)
      } else {
        this.selected.metrics.push(metric)
        this.selectedIds.push(metric.id)
      }
    },
    enabled(metric) {
      return this.selectedIds.includes(metric.id)
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
