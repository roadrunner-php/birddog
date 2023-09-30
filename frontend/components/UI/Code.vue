<template>
  <pre class="m-0"><code
    v-highlight
    class="p-4  bg-dark"
    :class="lang"
    v-text="code"
  /></pre>
</template>

<script>
export default {
  props: {
    lang: String,
    code: Object | String
  }
}
</script>
