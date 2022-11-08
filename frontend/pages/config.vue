<template>
  <div v-if="hasConfig">
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
          <NuxtLink :to="`/`">
            Server <strong>{{ server }}</strong>
          </NuxtLink>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          Config
        </li>
      </ol>
    </nav>

    <h4 class="d-flex align-items-center">
      <b-icon icon="braces" font-scale="1.4" class="mr-3"/>
      Server config
    </h4>

    <div class="card mt-4" v-if="config || false">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
          <li class="nav-item">
            <button class="nav-link" :class="{'active': type === 'yaml'}" @click="type='yaml'">YAML</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" :class="{'active': type === 'json'}" @click="type='json'">JSON</button>
          </li>
        </ul>
      </div>

      <UICode v-if="type==='json'" lang="json" :code="config"/>
      <UICode v-if="type==='yaml'" lang="yaml" :code="yamlConfig"/>
    </div>
  </div>
</template>

<script>
const YAML = require('json-to-pretty-yaml')

export default {
  props: {
    type: {
      type: String,
      default: 'yaml'
    }
  },
  head() {
    return {
      title: `RoadRunner config - ${this.server}`
    }
  },
  computed: {
    server() {
      return this.$store.getters['servers/getDefaultServer']
    },
    config() {
      return this.$store.getters['config/getConfig']
    },
    yamlConfig() {
      return YAML.stringify(this.config)
    },
    hasConfig() {
      return this.$store.getters['config/hasConfig']
    }
  }
}
</script>
