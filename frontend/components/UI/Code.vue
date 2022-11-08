<template>
  <pre>
    <code
      v-highlight
      class="rounded p-4"
      :class="lang"
      v-text="code"
    />
  </pre>
</template>

<script>
export default {
  props: {
    lang: String,
    code: Object
  }
}
</script>
