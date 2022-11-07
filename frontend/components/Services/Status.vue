<template>
  <div class="list-group-item" :class="{'border-warning': failed, 'border-success': !failed}">
    <div class="d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <div class="rounded-circle worker-status mr-3" role="status" :class="classStr"></div>
        <span class="badge badge-light border mr-2" >PID #{{ service.pid }}</span>
        <span class="badge badge-light border mr-2">CPU - {{ cpuUsage }}</span>
        <span class="badge badge-light border mr-2" >Memory - {{ memoryUsage }}</span>
      </div>
      <span class="text-danger" v-if="failed">
        <b-icon icon="exclamation-circle" font-scale="1.3" />
      </span>
    </div>

    <UIWarningMessage v-if="failed" class="mt-3">
      {{ service.error.message }}
    </UIWarningMessage>
  </div>
</template>

<script>
import {humanFileSize, humaCpuUsage} from '~/helpers/utils'

export default {
  props: {
    service: Object
  },
  computed: {
    classStr() {
      if (this.failed) {
        return 'bg-warning'
      }

      return 'bg-success'
    },
    cpuUsage() {
      return humaCpuUsage(this.service.cpu_percent)
    },
    memoryUsage() {
      return humanFileSize(this.service.memory_usage)
    },
    failed() {
      return this.service.error !== null
    }
  }
}
</script>
