<template>
  <div class="card mb-4 shadow-sm">
    <div class="card-header d-flex justify-content-between">
      <div class="d-flex align-items-center" v-if="showLink">
        <b-icon icon="puzzle" font-scale="1.4"/>
        <h5 class="ml-3 mb-0">
          <NuxtLink :to="`/plugin/${plugin.name}`" v-if="hasSettings()">
            {{ pluginName }} plugin
          </NuxtLink>
          <span v-else>
            {{ pluginName }} plugin
          </span>
        </h5>
      </div>
      <span v-else>
          Workers
      </span>
      <div class="d-flex align-items-center">
        <span class="badge badge-light border mr-2">
          Workers: <strong>{{ plugin.workers.length }}</strong>
        </span>
      </div>
    </div>

    <div class="list-group list-group-flush" v-if="hasWorkers">
      <PluginsWorker v-for="worker in sortedWorkers" :worker="worker" :key="worker.pid"/>
    </div>
    <UIWarningMessage v-else>
      There are no run workers.
    </UIWarningMessage>
    <div class="card-footer p-2" v-if="plugin.is_ressetable">
      <button type="button" class="btn btn-sm btn-danger ml-2" @click="reset">
        <b-icon icon="arrow-clockwise"/>
        Restart
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    server: String,
    plugin: Object,
    showLink: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      loading: false,
      settings: ['jobs', 'service']
    }
  },
  methods: {
    hasSettings() {
      return this.settings.indexOf(this.plugin.name) > -1
    },
    async reset() {
      this.loading = true
      await this.$api.plugins.reset(this.server, this.plugin.name)
      this.loading = false

      this.$emit('reset')
    }
  },
  computed: {
    pluginName() {
      return this.plugin.name.capitalize()
    },
    hasWorkers() {
      return this.plugin.workers.length > 0
    },
    sortedWorkers() {
      return this.plugin.workers
    }
  }
}
</script>
