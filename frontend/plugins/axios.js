export default function ({$axios, $logger, redirect}) {
  $axios.setBaseURL(process.env.API_URL)

  $axios.onRequest(config => {
    $logger.debug(`Making request: ${config.url}`, config)
  })

  $axios.onResponse(response => {
    $logger.debug(`Response:`, response)
  })

  $axios.onError(error => {
    $logger.error('Request error', error)
  })
}
