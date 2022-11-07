<template>
  <div>
    <MetricsItem :server="server"
                 :keys="['go_memstats_heap_alloc_bytes', 'go_memstats_heap_sys_bytes',]"
                 units="bytes"
                 class="mb-4" />
    <MetricsItem :server="server"
                 :keys="['process_open_fds']"
                 units="bytes"
                 class="mb-4" />
  </div>
</template>

<script>
export default {
  props: {
    server: String,
  },
}
</script>
