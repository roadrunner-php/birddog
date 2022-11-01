export class Logger {
  constructor(mode) {
    this.mode = mode
  }

  debug(...content) {
    this.__log('success', ...content)
  }

  error(...content) {
    this.__log('error', ...content)
  }

  info(...content) {
    this.__log('info', ...content)
  }

  __log(type, ...content) {
    if (this.mode !== 'development') {
      return
    }

    switch (type) {
      case 'success':
        console.info(...content)
        break
      case 'info':
        console.info(...content)
        break
      case 'error':
        console.error(...content)
        break
    }
  }
}

const logger = (context, inject) => {
  const logger = new Logger(process.env.NODE_ENV)

  inject('logger', logger)
  context.$logger = logger
};

export default logger
