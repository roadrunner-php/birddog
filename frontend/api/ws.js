// Servers
const serversList = ({$ws}) => async () => $ws.rpc('get:v1/servers')
  .then((response) => {
    return {
      servers: response.data.data,
      default: response.data.default
    }
  })

const serverRegister = ({$ws}) => async (name, address) => $ws.rpc('post:v1/server/register', {name, address})

// Roadrunner
const configGet = ({$ws}) => async (server) => $ws.rpc(`get:v1/server/config`, {server})
  .then((response) => response.data.data)
const versionGet = ({$ws}) => async (server) => $ws.rpc(`get:v1/server/version`, {server})
  .then((response) => response.data.version || '0.0.0')

// Plugins
const pluginsList = ({$ws}) => async (server) => $ws.rpc(`get:v1/plugins`, {server})
  .then((response) => response.data.data)

const pluginReset = ({$ws}) => async (server, plugin) => $ws.rpc(`post:v1/plugin/reset`, {server, plugin})
  .then((response) => response.data.status)

const pluginWorkers = ({$ws}) => async (server, plugin) => $ws.rpc(`get:v1/plugin/workers`, {server, plugin})
  .then((response) => response.data.data || [])

// Jobs
const jobsPipelines = ({$ws}) => async (server) => $ws.rpc(`get:v1/jobs/pipelines`, {server})
  .then((response) => response.data.data)

const jobsPipelinePause = ({$ws}) => async (server, pipeline) => $ws.rpc(`post:v1/jobs/pipeline/pause`, {
  server,
  pipeline
})
  .then((response) => response.data.status)

const jobsPipelineResume = ({$ws}) => async (server, pipeline) => $ws.rpc(`post:v1/jobs/pipeline/resume`, {
  server,
  pipeline
})
  .then((response) => response.data.status)

// Informer
const addWorker = ({$ws}) => async (server, plugin) => $ws.rpc(`post:v1/plugin/worker`, {server, plugin})
  .then((response) => response.data.status)

const removeWorker = ({$ws}) => async (server, plugin) => $ws.rpc(`delete:v1/plugin/worker`, {server, plugin})
  .then((response) => response.data.status)

// Services
const servicesList = ({$ws}) => async (server) => $ws.rpc(`get:v1/services`, {server})
  .then((response) => response.data.data)

const serviceStatus = ({$ws}) => async (server, service) => $ws.rpc(`get:v1/service/status`, {server, service})
  .then((response) => response.data.data)

const servicesTerminate = ({$ws}) => async (server, service) => $ws.rpc(`post:v1/service/terminate`, {server, service})
const servicesRestart = ({$ws}) => async (server, service) => $ws.rpc(`post:v1/service/restart`, {server, service})

// Metrics
const metricsGet = ({$ws}) => async (server) => $ws.rpc(`get:v1/metrics`, {server})
  .then((response) => {
    return {
      metrics: response.data.data,
      range: response.data.meta.metrics
    }
  })

const metricsGetByKey = ({$ws}) => async (server, key, tags) => $ws.rpc(`get:v1/metrics/${key}`, {server, tag: tags})
  .then((response) => response.data.data)

const metricsGetRangeByKey = ({$ws}) => async (server, key, tags) => $ws.rpc(`get:v1/metrics/${key}/range`, {server, tag: tags})
  .then((response) => response.data.data)

// Settings
const settingsGet = ({$ws}) => async () => $ws.rpc(`get:v1/settings`)
  .then((response) => response.data.settings)

const settingsStore = ({$ws}) => async (settings) => $ws.rpc(`post:v1/settings`, {settings})

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
  versionGet,
  metricsGet,
  metricsGetByKey,
  metricsGetRangeByKey,
  settingsGet,
  settingsStore,
  addWorker,
  removeWorker,
}
