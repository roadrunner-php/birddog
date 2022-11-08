
export default {
  ssr: false,
  target: 'static',

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
    {src: '~/plugins/cenrifugo.js'},
    {src: '~/plugins/api.js'},
    {src: '~/plugins/bootstrap.js'},
    {src: '~/plugins/chart.js', mode: 'client'}
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

  build: {}
}
