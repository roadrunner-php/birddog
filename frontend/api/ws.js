// Servers
const serversList = ({$ws}) => async () => $ws.rpc('get:servers')
  .then((response) => {
    return {
      servers: response.data.data.servers,
      default: response.data.default
    }
  })

const serverRegister = ({$ws}) => async (name, address) => $ws.rpc('post:server/register', {name, address})

// Roadrunner
const configGet = ({$ws}) => async (server) => $ws.rpc(`get:rr/config`, {server})
  .then((response) => response.data.config)
const versionGet = ({$ws}) => async (server) => $ws.rpc(`get:rr/version`, {server})
  .then((response) => response.data.version || '0.0.0')

// Plugins
const pluginsList = ({$ws}) => async (server) => $ws.rpc(`get:plugins`, {server})
  .then((response) => response.data.data)

const pluginReset = ({$ws}) => async (server, plugin) => $ws.rpc(`post:plugin/reset`, {server, plugin})
  .then((response) => response.data.status)

const pluginWorkers = ({$ws}) => async (server, plugin) => $ws.rpc(`get:plugin/workers`, {server, plugin})
  .then((response) => response.data.data || [])

// Jobs
const jobsPipelines = ({$ws}) => async (server) => $ws.rpc(`get:jobs/pipelines`, {server})
  .then((response) => response.data.data)

const jobsPipelinePause = ({$ws}) => async (server, pipeline) => $ws.rpc(`post:jobs/pipeline/pause`, {
  server,
  pipeline
})
  .then((response) => response.data.status)

const jobsPipelineResume = ({$ws}) => async (server, pipeline) => $ws.rpc(`post:jobs/pipeline/resume`, {
  server,
  pipeline
})
  .then((response) => response.data.status)

// Services
const servicesList = ({$ws}) => async (server) => $ws.rpc(`get:services`, {server})
  .then((response) => response.data.data.services)

const serviceStatus = ({$ws}) => async (server, service) => $ws.rpc(`get:service/status`, {server, service})
  .then((response) => response.data.data.statuses)

const servicesTerminate = ({$ws}) => async (server, service) => $ws.rpc(`post:service/terminate`, {server, service})
const servicesRestart = ({$ws}) => async (server, service) => $ws.rpc(`post:service/restart`, {server, service})

// Metrics
const metricsGet = ({$ws}) => async (server) => $ws.rpc(`get:metrics`, {server})
  .then((response) => response.data.data.metrics)

const metricsGetByKey = ({$ws}) => async (server, key, tags) => $ws.rpc(`get:metrics/${key}`, {server, tag: tags})
  .then((response) => response.data)

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
  metricsGetByKey
}
