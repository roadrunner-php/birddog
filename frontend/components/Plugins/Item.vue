<template>
  <div class="card mb-4 shadow-sm">
    <div class="card-header d-flex justify-content-between">
      <div class="d-flex align-items-center" v-if="showLink">
        <b-icon icon="puzzle" font-scale="1.4"/>
        <h5 class="ms-3 mb-0">
          <NuxtLink :to="`/plugin/${plugin.name}`" v-if="hasSettings">
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
        <div class="border me-2" v-if="supportsWorkersManagement">
          <button
            class="btn btn-light-outline btn-sm border-right"
            @click="removeWorker"
            :disabled="totalWorkers <= 1"
          >
            <b-icon icon="arrow-down-short"/>
          </button>

          <span class="badge" :class="{'badge-warning': !hasWorkers, 'badge-light': hasWorkers}">
            Workers: <strong>{{ totalWorkers }}</strong>
          </span>

          <button class="btn btn-light-outline btn-sm border-left"
                  @click="addWorker">
            <b-icon icon="arrow-up-short"/>
          </button>
        </div>

        <button v-if="plugin.is_resettable" title="restart workers"
                type="button"
                class="btn btn-sm btn-danger mx-2"
                @click="reset">
          <b-icon icon="arrow-clockwise"/>
        </button>

        <button class="btn btn-light-outline btn-sm" @click="toggle">
          <b-icon icon="chevron-up" v-if="!isCollapsed"/>
          <b-icon icon="chevron-down" v-else/>
        </button>
      </div>
    </div>

    <div v-if="!isCollapsed">
      <div class="list-group list-group-flush" v-if="hasWorkers">
        <PluginsWorker v-for="worker in sortedWorkers" :worker="worker" :key="worker.pid"/>
      </div>
      <UIWarningMessage v-else>
        There are no run workers.
      </UIWarningMessage>
    </div>
  </div>
</template>

<script>
import {mapState} from 'vuex'

const PLUGINS_WITH_WORKERS = ['jobs', 'http', 'grpc', 'temporal', 'centrifuge']

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
    async addWorker() {
      try {
        this.loading = true
        await this.$api.informer.addWorker(this.server, this.plugin.name)
        this.loading = false

        // this.$toast.success(`${this.pluginName} workers on server ${this.server} were added.`)
        this.$emit('addedWorker')
      } catch (e) {
        this.$toast.error(e.message)
      }
    },
    async removeWorker() {
      try {
        this.loading = true
        await this.$api.informer.removeWorker(this.server, this.plugin.name)
        this.loading = false

        // this.$toast.success(`${this.pluginName} workers on server ${this.server} were removed.`)
        this.$emit('removedWorker')
      } catch (e) {
        this.$toast.error(e.message)
      }
    },
    toggle() {
      this.$store.commit('settings/setPluginState', {server: this.server, plugin: this.plugin.name})
    },
    async reset() {
      try {
        this.loading = true
        await this.$api.plugins.reset(this.server, this.plugin.name)
        this.loading = false

        this.$toast.success(`${this.pluginName} workers on server ${this.server} were restarted.`)
        this.$emit('reset')
      } catch (e) {
        this.$toast.error(e.message)
      }
    }
  },
  computed: {
    supportsWorkersManagement() {
      return PLUGINS_WITH_WORKERS.indexOf(this.plugin.name) > -1
    },
    ...mapState('settings', ['collapsed_plugins']),
    isCollapsed() {
      return this.$store.getters['settings/isCollapsedPlugin'](this.server, this.plugin.name)
    },
    hasSettings() {
      return this.settings.indexOf(this.plugin.name) > -1
    },
    pluginName() {
      return this.plugin.name.capitalize()
    },
    totalWorkers() {
      return this.sortedWorkers.length
    },
    hasWorkers() {
      return this.totalWorkers > 0
    },
    sortedWorkers() {
      return this.plugin.workers.data
    }
  }
}
</script>
