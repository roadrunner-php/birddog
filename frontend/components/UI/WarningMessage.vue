<template>
  <div class="alert alert-warning border d-flex align-items-center mb-0" role="alert">
    <div class="me-3">
      <b-icon icon="exclamation-triangle-fill" variant="danger" font-scale="1.5" />
    </div>
    <div>
      <slot/>
    </div>
  </div>
</template>

<script>
export default {
  name: "WarningMessage"
}
</script>

<style scoped>

</style>
