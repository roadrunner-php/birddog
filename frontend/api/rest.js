// Servers
const serversList = ({$axios}) => async () => $axios.$get('/servers')
  .then((response) => {
    return {
      servers: response.data.servers,
      default: response.default
    }
  })

const serverRegister = ({$axios}) => async (name, address) => $axios.$post('/server/register', {name, address})

// Config
const configGet = ({$axios}) => async (server) => $axios.$get(`/rr/config?server=${server}`)
  .then((response) => response)
const versionGet = ({$axios}) => async (server) => $axios.$get(`/rr/version?server=${server}`)
  .then((response) => response.version)

// Plugins
const pluginsList = ({$axios}) => async (server) => $axios.$get(`/plugins?server=${server}`)
  .then((response) => response.data.plugins)

const pluginReset = ({$axios}) => async (server, plugin) => $axios.$post(`/plugin/reset`, {server, plugin})
  .then((response) => response.status)

const pluginWorkers = ({$axios}) => async (server, plugin) => $axios.$get(`/plugin/workers?server=${server}&plugin=${plugin}`)
  .then((response) => response.data.workers || [])

// Jobs
const jobsPipelines = ({$axios}) => async (server) => $axios.$get(`/jobs/pipelines?server=${server}`)
  .then((response) => response.pipelines)

const jobsPipelinePause = ({$axios}) => async (server, pipeline) => $axios.$post(`/jobs/pipeline/pause`, {
  server,
  pipeline
})
  .then((response) => response.status)

const jobsPipelineResume = ({$axios}) => async (server, pipeline) => $axios.$post(`/jobs/pipeline/resume`, {
  server,
  pipeline
})
  .then((response) => response.status)

// Informer
const addWorker = ({$axios}) => async (server, plugin) => $axios.$post(`/informer/worker`, {server, plugin})
  .then((response) => response.status)

const removeWorker = ({$axios}) => async (server, plugin) => $axios.$delete(`/informer/worker`, {server, plugin})
  .then((response) => response.status)

// Services
const servicesList = ({$axios}) => async (server) => $axios.$get(`/services?server=${server}`)
  .then((response) => response.data.services)

const serviceStatus = ({$axios}) => async (server, service) => $axios.$get(`/service/status?server=${server}&service=${service}`)
  .then((response) => response.data.statuses)

const servicesTerminate = ({$axios}) => async (server, service) => $axios.$post(`/service/terminate`, {server, service})
const servicesRestart = ({$axios}) => async (server, service) => $axios.$post(`/service/restart`, {server, service})

// Metrics
const metricsGet = ({$axios}) => async (server) => $axios.$get(`/metrics?server=${server}`)
  .then((response) => response.data)

const metricsGeByKey = ({$axios}) => async (server, key) => $axios.$get(`/metrics/${key}?server=${server}`)
  .then((response) => response.data)

// Settings
const settingsGet = ({$axios}) => async () => $axios.$get('settings')
  .then((response) => response.settings)

const settingsStore = ({$axios}) => async (settings) => $axios.$post('settings', {settings})

export default {
  serversList,
  pluginsList,
  pluginWorkers,
  pluginReset,
  jobsPipelines,
  jobsPipelinePause,
  jobsPipelineResume,
  servicesList,
  servicesTerminate,
  servicesRestart,
  serviceStatus,
  serverRegister,
  configGet,
  metricsGet,
  metricsGeByKey,
  settingsGet,
  settingsStore,
  addWorker,
  removeWorker,
}
