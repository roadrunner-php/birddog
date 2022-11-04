export default {
  ssr: false,

  env: {
    API_URL: process.env.API_URL || 'http://127.0.0.1:8080',
  },

  head: {
    title: 'Birddog',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      {charset: 'utf-8'},
      {name: 'viewport', content: 'width=device-width, initial-scale=1'},
      {hid: 'description', name: 'description', content: ''},
      {name: 'format-detection', content: 'telephone=no'}
    ],
    link: [
      {rel: 'icon', type: 'image/x-icon', href: '/favicon.ico'}
    ]
  },

  css: [],

  plugins: [
    {src: '~/plugins/logger.js'},
    {src: '~/plugins/axios.js'},
    {src: '~/plugins/api.js'},
    {src: '~/plugins/bootstrap.js'},
  ],

  components: true,

  buildModules: [
    '@nuxtjs/moment',
    ['nuxt-highlightjs', {
      style: 'obsidian'
    }],
    '@nuxtjs/toast',
  ],

  modules: [
    '@nuxtjs/axios',
    'bootstrap-vue/nuxt',
  ],

  toast: {
    position: 'top-center',
    duration: 3000,
    closeOnSwipe: true,
    theme: "bubble"
  },

  bootstrapVue: {
    icons: true,
    components: ['BDropdown', 'BDropdownItem']
  },

  axios: {
    baseURL: process.env.API_URL
    // proxy: true
  },

  build: {}
}
