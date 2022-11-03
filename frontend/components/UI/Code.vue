<template>
  <pre>
    <code v-highlight class="rounded p-4" :class="lang"><slot/></code>
  </pre>
</template>

<script>
export default {
  props: {
    lang: String
  }
}
</script>
