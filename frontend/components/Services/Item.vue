<template>
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-start">
        <h6>
          <strong>{{ name }}</strong>
          <br/>
          <span v-if="command" class="badge border bg-light mt-2">Command: <strong>{{ command }}</strong></span>
        </h6>
        <div class="spinner-border text-success" style="width: 20px; height: 20px" v-if="hasStatus"></div>
      </div>
    </div>
    <ServicesStatus :service="status" :key="status.pid" v-for="status in statuses"/>
    <div class="card-footer">
      <button type="button" class="btn btn-sm btn-danger ml-2" @click.prevent="restart">
        Restart
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
    hasStatus() {
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
