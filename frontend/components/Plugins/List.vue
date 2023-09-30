<template>
  <div>
    <div v-if="hasPlugins">
      <PluginsItem
        :server="server"
        :plugin="plugin"
        v-for="plugin in plugins"
        :key="plugin.name"
        @reset="onReset"
        @addedWorker="onWorkerAdded"
        @removedWorker="onWorkerRemoved"
      />
    </div>
    <UIWarningMessage v-else>
      There are no available plugins on <strong>{{ server }}</strong> server.
    </UIWarningMessage>
  </div>
</template>

<script>
import PeriodicallyTimer from '~/mixins/PeriodicallyTimer'

export default {
  mixins: [PeriodicallyTimer],
  props: {
    server: String,
    refreshTimeout: {
      type: Number,
      default: 2000
    }
  },
  methods: {
    onReset() {
      this.fetchData()
    },
    onWorkerAdded() {
      this.fetchData()
    },
    onWorkerRemoved() {
      this.fetchData()
    },
    async fetchData() {
      await this.$store.dispatch('plugins/fetchPlugins', this.server)
    }
  },
  watch: {
    server() {
      this.fetchData()
    }
  },
  computed: {
    plugins() {
      return this.$store.getters['plugins/getPlugins']
    },
    hasPlugins() {
      return this.plugins.length > 0
    }
  },
}
</script>
