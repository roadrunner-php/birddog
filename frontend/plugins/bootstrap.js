export default function ({store}, inject) {
  store.dispatch('servers/fetchServers')
}
