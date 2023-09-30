<template>
  <div v-if="server">
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
          <NuxtLink :to="`/`">
            Server <strong>{{ server }}</strong>
          </NuxtLink>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          <strong>HTTP</strong> plugin
        </li>
      </ol>
    </nav>

    <h4 class="mb-4 d-flex align-items-center">
      <b-icon icon="puzzle" font-scale="1.4" class="me-3"/> Http plugin
    </h4>

    <PluginsItem :server="server" :plugin="plugin" :showLink="false"/>
    <ConfigHttp :server="server"/>
  </div>
</template>

<script>
import PeriodicallyTimer from '~/mixins/PeriodicallyTimer'

export default {
  mixins: [PeriodicallyTimer],
  head() {
    return {
      title: `HTTP plugin - ${this.server}`
    }
  },
  data() {
    return {
      workers: []
    }
  },
  methods: {
    async fetchData() {
      if (!this.server) {
        return
      }

      this.workers = await this.$api.plugins.workers(this.server, 'http')
    },
    async fetchConfig() {
      await this.$store.dispatch('config/fetchConfig', this.server)
    }
  },
  watch: {
    server() {
      this.fetchData()
      this.fetchConfig()
    }
  },
  computed: {
    plugin() {
      return {
        name: 'http',
        workers: this.workers,
        is_resettable: true
      }
    },
    server() {
      return this.$store.getters['servers/getDefaultServer']
    }
  }
}
</script>

