<template>
  <div class="list-group-item" :class="{'border-warning': failed, 'border-success': !failed}">
    <div class="d-flex justify-content-between align-items-center">
      <div class="d-flex  align-items-center">
        <span class="badge badge-light border mr-2" >PID #{{ service.pid }}</span>
        <span class="badge badge-light border mr-2">CPU - {{ cpuUsage }}</span>
        <span class="badge badge-light border mr-2" >Memory - {{ memoryUsage }}</span>
      </div>
      <div class="spinner-border text-success" style="width: 20px; height: 20px" v-if="!failed"></div>
      <span class="text-danger" v-else>
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
