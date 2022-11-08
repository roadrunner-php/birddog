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
        <button class="btn btn-light-outline btn-sm" @click="toggle">
          <b-icon icon="chevron-up" v-if="open"/>
          <b-icon icon="chevron-down" v-else="open"/>
        </button>
      </div>
    </div>

    <div v-if="open">
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
      open: true,
      settings: ['jobs', 'service']
    }
  },
  methods: {
    toggle() {
      this.open = !this.open
    },
    hasSettings() {
      return this.settings.indexOf(this.plugin.name) > -1
    },
    async reset() {
      try {
        this.loading = true
        await this.$api.plugins.reset(this.server, this.plugin.name)
        this.loading = false

        this.$toast.success(`${this.pluginName} workers on server ${this.server} were restarted.`)
        this.$emit('reset')
      } catch(e) {
        this.$toast.error(e.message)
      }
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
