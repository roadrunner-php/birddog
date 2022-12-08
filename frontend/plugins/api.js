import apiMethods from '~/api/ws'

export default function (ctx, inject) {
  const api = new class Api {
    get servers() {
      return {
        list: apiMethods.serversList(ctx),
        register: apiMethods.serverRegister(ctx)
      }
    }

    get rr() {
      return {
        config: apiMethods.configGet(ctx),
        version: apiMethods.versionGet(ctx),
      }
    }

    get plugins() {
      return {
        list: apiMethods.pluginsList(ctx),
        workers: apiMethods.pluginWorkers(ctx),
        reset: apiMethods.pluginReset(ctx)
      }
    }

    get services() {
      return {
        list: apiMethods.servicesList(ctx),
        status: apiMethods.serviceStatus(ctx),
        restart: apiMethods.servicesRestart(ctx)
      }
    }

    get jobs() {
      return {
        pipelines: apiMethods.jobsPipelines(ctx),
        pause: apiMethods.jobsPipelinePause(ctx),
        resume: apiMethods.jobsPipelineResume(ctx)
      }
    }

    get metrics() {
      return {
        get: apiMethods.metricsGet(ctx),
        getByKey: apiMethods.metricsGetByKey(ctx),
        getRangeByKey: apiMethods.metricsGetRangeByKey(ctx)
      }
    }

    get settings() {
      return {
        get: apiMethods.settingsGet(ctx),
        store: apiMethods.settingsStore(ctx),
      }
    }
  }

  inject('api', api)
  ctx.$api = api
}
