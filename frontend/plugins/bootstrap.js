Object.defineProperty(String.prototype, 'capitalize', {
  value: function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
  },
  enumerable: false
});


export default function ({store}, inject) {
  store.dispatch('settings/fetchSettings')
  store.dispatch('servers/fetchServers')
}
