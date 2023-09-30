<template>
  <div class="card" :class="{'border-success': pipeline.ready}">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-start">
        <h5>
          <strong>{{ pipeline.name }}</strong>
          <span class="badge badge-success border ms-2" v-if="pipeline.ready">Consuming</span>
          <span class="badge badge-warning border ms-2" v-else>Paused</span>
        </h5>
        <div v-if="pipeline.ready" class="spinner-border text-primary"></div>
      </div>
    </div>
    <div class="card-body">
      <span class="badge badge-light border me-2">Driver - {{ pipeline.driver }}</span>
      <span class="badge badge-light border me-2">Priority - {{ pipeline.priority }}</span>
      <span class="badge badge-light border me-2">Active jobs - {{ pipeline.active }}</span>
      <span class="badge badge-light border me-2">Delayed jobs - {{ pipeline.delayed }}</span>
      <span class="badge badge-light border me-2">Reserved jobs - {{ pipeline.reserved }}</span>
    </div>
    <div class="card-footer">
      <button type="button" class="btn btn-sm btn-warning ms-2" @click="pause()" v-if="pipeline.ready">
        <b-icon icon="pause-circle" /> Pause
      </button>
      <button type="button" class="btn btn-sm btn-success ms-2" @click="resume()" v-else>
        <b-icon icon="power" /> Consume
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    server: String,
    pipeline: Object
  },
  data() {
    return {
      loading: false
    }
  },
  methods: {
    async pause() {
      this.loading = true
      await this.$api.jobs.pause(this.server, this.pipeline.name)
      this.loading = false
      this.$emit('paused')
    },
    async resume() {
      this.loading = true
      await this.$api.jobs.resume(this.server, this.pipeline.name)
      this.loading = false
      this.$emit('resumed')
    }
  }
}
</script>
