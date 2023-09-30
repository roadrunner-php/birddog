<template>
  <div class="list-group-item d-flex justify-content-between">
    <div class="d-flex align-items-center">
      <div class="rounded-circle worker-status me-2" role="status" :class="classStr"></div>
      <span class="badge badge-light border me-2">PID #{{ worker.pid }}</span>
      <span class="badge badge-light border me-2">CPU - {{ cpuUsage }}</span>
      <span class="badge badge-light border me-2">Memory - {{ memoryUsage }}</span>
      <span class="badge badge-light border me-2">Execs - {{ worker.numExecs }}</span>
      <span class="badge badge-light border me-2" v-if="worker.created > 0">Created - {{ created }}</span>
    </div>
    <span class="badge text-white border me-2" v-if="worker.statusStr" :class="classStr">
      Status - {{ worker.statusStr }}
    </span>
  </div>
</template>

<script>
import NanoDate from 'nano-date'
import {humanFileSize, humaCpuUsage} from '~/helpers/utils'

export default {
  props: {
    worker: Object
  },
  computed: {
    classStr() {
      if (this.failed) {
        return 'bg-warning'
      }

      if (this.ready) {
        return 'bg-success'
      }
      return 'bg-primary'
    },
    working() {
      return this.worker.status === 2
    },
    failed() {
      return this.worker.status === 0
    },
    ready() {
      return this.worker.status === 1
    },
    cpuUsage() {
      return humaCpuUsage(this.worker.cpu_percent)
    },
    memoryUsage() {
      return humanFileSize(this.worker.memory_usage)
    },
    created() {
      const date = new NanoDate(this.worker.created)
      return this.$moment(date.toISOStringFull()).fromNow()
    }
  }
}
</script>


<style type="text/css">
.worker-status {
  width: 12px;
  height: 12px;
}
</style>
