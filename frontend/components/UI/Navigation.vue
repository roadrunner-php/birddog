<template>
  <nav class="navbar px-2 bg-light border">
    <div class="container-fluid">
      <div class="d-flex align-items-center">
        <NuxtLink to="/" class="navbar-brand d-flex align-items-center">
          <svg height="35px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 257 257" fill="#007bff"
               xml:space="preserve"><path d="M70 140c10 0 19-3 26-8 12-8 21-22 27-37a76 76 0 0 0 3-47c-6-20-27-33-55-33-10 0-22 2-32 6C21 27 8 40 2 56a57 57 0 0 0 10 51c15 20 37 33 58 33zm18-76a12 12 0 1 1 1 23 12 12 0 0 1-1-23zM235 87a12 12 0 0 0 11-12 12 12 0 1 0-23 1c0 6 5 11 12 11zM248 209c-57 0-72-32-76-45 16-6 27-26 27-39 0-18-17-32-37-32-21 0-38 14-38 32 0 13 11 33 27 39-4 13-19 45-76 45a9 9 0 1 0 0 18c45 0 69-18 81-33l6-9 5 9c22 27 56 33 81 33a9 9 0 1 0 0-18z"/>
            <path d="M169 224h-15a9 9 0 1 0 0 18h15a9 9 0 1 0 0-18z"/></svg>
          <strong class="ml-3 font-weight-bolder">Birddog</strong>
        </NuxtLink>
        <div class="navbar-nav me-auto mt-1 ml-4">
          <div class="nav-item" v-if="hasConfig">
            <NuxtLink to="/config" class="nav-link">
              Config
            </NuxtLink>
          </div>
        </div>
      </div>
      <ServersDropdown/>
    </div>
  </nav>
</template>

<script>
export default {
  computed: {
    hasConfig() {
      return this.$store.getters['config/hasConfig']
    }
  }
}
</script>
