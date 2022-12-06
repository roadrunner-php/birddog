class ApiSettings {
  constructor(api, logger) {
    this.api = api
    this.logger = logger
  }

  async getSettings() {
    try {
      const settings = await this.api.settings.get()
      this.logger.debug('Load', settings)
      return settings;
    } catch(e) {
      this.logger.error('Load', e)
    }

    return {};
  }

  async store(settings) {
    this.logger.debug('Store', settings)
    await this.api.settings.store(settings)
  }
}

export default function (ctx, inject) {
  const settings = new ApiSettings(
    ctx.$api,
    ctx.$logger.withPrefix('Settings')
  );

  inject('settings', settings);
  ctx.$settings = settings
}
