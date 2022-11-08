<template>
  <main class="container-fluid py-4 d-flex flex-column flex-shrink-0">
    <UIHeader class="mb-4"/>
    <Nuxt class="flex-fill d-flex flex-column flex-shrink-0"/>
    <UIFooter/>
  </main>
</template>

<script>
export default {}
</script>

<style type="text/css">
body {
  background-color: whitesmoke;
}

body, #__nuxt, #__layout, #__layout > main {
  min-height: 100vh;
}
</style>
