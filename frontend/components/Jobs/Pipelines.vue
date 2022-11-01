<template>
  <div>
    <div v-if="hasPipelines" class="list-group">
      <h4 class="mb-4">Pipelines</h4>

      <JobsPipeline
        :pipeline="pipeline"
        :server="server"
        :key="pipeline.name"
        v-for="pipeline in sortedPipelines"
        @paused="onPause"
        @resumed="onResume"/>
    </div>

    <UIWarningMessage v-else>
      There are no available Jobs pipelines on <strong>{{ server }}</strong> server.
    </UIWarningMessage>
  </div>
</template>

<script>
import PeriodicallyTimer from '~/mixins/PeriodicallyTimer'

export default {
  props: {
    server: String
  },
  mixins: [PeriodicallyTimer],
  data() {
    return {
      pipelines: [],
      loading: false
    }
  },
  watch: {
    server() {
      this.fetchData()
    }
  },
  methods: {
    onPause() {
      this.fetchData()
    },
    onResume() {
      this.fetchData()
    },
    async fetchData() {
      try {
        this.pipelines = await this.$api.jobs.pipelines(this.server)
      } catch (e) {
        this.pipelines = []
      }
    }
  },
  computed: {
    hasPipelines() {
      return this.pipelines.length > 0
    },
    sortedPipelines() {
      return this.pipelines.sort(
        (a, b) => (a.name.substr(1) > b.name.substr(1)) ? -1 : ((b.name.substr(1) > a.name.substr(1) ? 1 : 0))
      )
    }
  },
}
</script>
