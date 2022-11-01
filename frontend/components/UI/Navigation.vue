<template>
  <nav class="navbar px-2 bg-light border">
    <div class="container-fluid">
      <NuxtLink to="/" class="navbar-brand">
        <img src="/logo.png" height="30px" />
        <strong>RoadRunner</strong> monitor
      </NuxtLink>
      <ServersDropdown />
    </div>
  </nav>
</template>

<script>
export default {

}
</script>
