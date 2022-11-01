<template>
  <div class="border border-4 p-3" :class="{'border-warning': failed, 'border-success': !failed}">
    <div>
      <span class="badge badge-light border mr-2">PID #{{ service.pid }}</span>
      <span class="badge badge-light border mr-2">CPU - {{ cpuUsage }}</span>
      <span class="badge badge-light border mr-2">Memory - {{ memoryUsage }}</span>
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
