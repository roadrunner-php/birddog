<template>
  <div v-if="config.http">
    <div class="card">
      <div class="card-header">Config</div>
      <div class="list-group">
        <div class="list-group-item">
          <strong>Address</strong>
          <span class="badge badge-light">{{ config.http.address }}</span>
        </div>
        <div class="list-group-item">
          <strong>Middleware</strong>
          <span class="badge badge-light" v-for="m in (config.http.middleware || [])">{{ m }}</span>
        </div>
      </div>
      <div class="card-body" v-if="showJson">
        {{ config.http }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showJson: false
    }
  },
  computed: {
    config() {
      return this.$store.getters['config/getConfig']
    }
  }
}
</script>
