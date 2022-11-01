export default {
  ssr: false,

  env: {
    BASE_URL: process.env.BASE_URL || 'http://127.0.0.1:8070',
  },

  head: {
    title: 'RoadRunner monitor',
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
    { src: '~/plugins/logger.js' },
    { src: '~/plugins/axios.js' },
    { src: '~/plugins/api.js' },
  ],

  components: true,

  buildModules: [
    '@nuxtjs/moment'
  ],

  modules: [
    '@nuxtjs/axios',
    'bootstrap-vue/nuxt',
  ],

  axios: {
    baseURL: process.env.BASE_URL
    // proxy: true
  },

  build: {}
}
