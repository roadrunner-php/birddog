<template>
  <Loading :active="active" :height="30" :is-full-page="false"/>
</template>

<script>
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'

export default {
  components: {Loading},
  props: {
    active: Boolean
  }
}
</script>
