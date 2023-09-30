<template>
  <div class="card">
    <UILoading :active="loading"/>
    <div class="card-header">
      <div class="d-flex flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <h6 class="d-flex align-items-center">
            <b-icon icon="hdd-network" font-scale="1.5" class="me-3"/>
            <strong>{{ name }}</strong>
          </h6>

          <button type="button" class="btn btn-sm btn-danger ms-2" @click.prevent="restart" title="Restart service">
            <b-icon icon="arrow-clockwise"/>
          </button>
        </div>
        <span v-if="command" class="badge border bg-dark mt-2">Command: <strong>{{ command }}</strong></span>
      </div>
    </div>
    <div class="list-group list-group-flush" v-if="hasStatuses">
      <ServicesStatus :service="status" :key="status.pid" v-for="status in statuses"/>
    </div>
  </div>
</template>

<script>
import Loading from 'vue-loading-overlay'
import PeriodicallyTimer from '~/mixins/PeriodicallyTimer'

export default {
  components: {Loading},
  mixins: [PeriodicallyTimer],
  props: {
    server: String,
    name: String
  },
  data() {
    return {
      loading: false,
      statuses: [],
    }
  },
  watch: {
    server() {
      this.fetchData()
      this.listenEvents()
    }
  },
  mounted() {
    this.listenEvents()
  },
  beforeDestroy() {
    this.$ws.serverChannel(this.server).stopListening('service.restarted')
  },
  methods: {
    listenEvents() {
      this.$ws.serverChannel(this.server).listen('service.restarted', (data) => {
        if (data.service !== this.name) return

        if (data.status) {
          this.$toast.success(`${data.service} processes on server ${data.server} were restarted.`)
        } else {
          this.$toast.error('Something went wrong.')
        }

        this.$emit('restarted')
        this.fetchData()
      })
    },
    async restart() {
      this.loading = true
      try {
        await this.$api.services.restart(this.server, this.name)
      } catch (e) {
        this.$toast.error(e.message)
      }

      this.loading = false
    },
    async fetchData() {
      this.loading = true
      this.statuses = await this.$api.services.status(this.server, this.name)
      this.loading = false
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
