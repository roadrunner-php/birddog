<template>
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h6 class="d-flex align-items-center">
            <b-icon icon="hdd-network" font-scale="1.5" class="mr-3" /> <strong>{{ name }}</strong>
          </h6>
          <span v-if="command" class="badge border bg-light mt-2">Command: <strong>{{ command }}</strong></span>
        </div>
      </div>
    </div>
    <div class="list-group list-group-flush" v-if="hasStatuses">
      <ServicesStatus :service="status" :key="status.pid" v-for="status in statuses"/>
    </div>
    <div class="card-footer p-2">
      <button type="button" class="btn btn-sm btn-danger ml-2" @click.prevent="restart">
        <b-icon icon="arrow-clockwise" /> Restart
      </button>
    </div>
  </div>
</template>

<script>
import PeriodicallyTimer from '~/mixins/PeriodicallyTimer'

export default {
  mixins: [PeriodicallyTimer],
  props: {
    server: String,
    name: String
  },
  data() {
    return {
      statuses: []
    }
  },
  watch: {
    server() {
      this.fetchData()
    }
  },
  methods: {
    async restart() {
      await this.$api.services.restart(this.server, this.name)
      this.fetchData()
    },
    async fetchData() {
      this.statuses = await this.$api.services.status(this.server, this.name)
    }
  },
  computed: {
    hasStatuses() {
      return this.statuses.length > 0
    },
    command() {
      if (this.statuses[0]) {
        return this.statuses[0].command
      }

      return ''
    }
  }
}
</script>
