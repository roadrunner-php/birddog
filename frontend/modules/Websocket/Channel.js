export default class Channel {
  /**
   * The name of the channel.
   */
  name

  /**
   * The event callbacks applied to the socket.
   */
  events = {}

  /**
   * User supplied callbacks for events on this channel.
   */
  listeners = {}

  /**
   * Create a new class instance.
   */
  constructor(ws, name) {
    this.ws = ws
    this.name = name

    this._subscribe()
  }

  /**
   * Listen for an event on the channel instance.
   */
  listen(event, callback) {
    this._on(event, callback)

    return this
  }

  /**
   * Bind the channel's socket to an event and store the callback.
   */
  _on(event, callback) {
    if (!callback) {
      throw new Error('Callback should be specified.');
    }

    if (this.listeners[event] === undefined) {
      this.listeners[event] = []
    }

    if (!this.events[event]) {
      this.events[event] = (context) => {
        this.ws.logger.debug(`publication on ${context.channel}`, context)

        const payload = context.data || {event: 'null'}

        if (payload.event === event && this.listeners[event].length > 0) {
          this.listeners[event].forEach(cb => cb(payload.data))
        }
      }

      this.subscription.on('publication', this.events[event])
    }

    this.listeners[event].push(callback)

    return this
  }

  stopListening(event) {
    if (!this.events[event]) {
      return
    }

    this.subscription.removeListener('publication', this.events[event])
    this.events[event] = null
    this.listeners[event] = []
  }

  unsubscribe() {
    this.subscription.removeAllListeners()
    this.ws.centrifuge.removeSubscription(this.subscription)
    this.listeners = {}
    this.events = {}
  }

  _subscribe() {
    let sub = this.ws.centrifuge.getSubscription(this.name)
    if (!sub) {
      sub = this.ws.centrifuge.newSubscription(this.name)

      sub.on('subscribing', (context) => {
        this.ws.logger.debug(`subscribing to ${this.name}`, context)
      })

      sub.on('subscribed', (context) => {
        this.ws.logger.debug(`subscribed to ${this.name}`, context)
      })

      sub.on('unsubscribed', (context) => {
        this.ws.logger.debug(`unsubscribed from ${this.name}`, context)
      })

      sub.subscribe()
    }
    this.subscription = sub
  }
}
