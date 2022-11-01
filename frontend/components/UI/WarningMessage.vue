<template>
  <div class="alert alert-warning d-flex align-items-center mb-0" role="alert">
    <div class="mr-3">
      <UIIconsWarning style="width: 20px; height: 20px" />
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
