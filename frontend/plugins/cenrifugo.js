import {WsClient} from '~/modules/Websocket/Client'
import {Centrifuge} from 'centrifuge'

const WS_URL = process.env.WS_URL

const subscribe = (client) => client.connect()
  .then(ctx => {
    client.channel('public')
  })

export default async (ctx, inject) => {
  const centrifuge = new Centrifuge(`${WS_URL}`)

  const client = new WsClient(centrifuge, ctx.$logger)
  await subscribe(client)

  inject('ws', client)
  ctx.$ws = client
}

