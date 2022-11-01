import apiMethods from '~/api/rest'

export default function (ctx, inject) {
  const api = new class Api {
    get servers() {
      return {
        list: apiMethods.serversList(ctx)
      }
    }

    get plugins() {
      return {
        list: apiMethods.pluginsList(ctx),
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
  }

  inject('api', api)
  ctx.$api = api
}
