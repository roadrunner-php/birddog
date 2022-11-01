<template>
  <div>
    <div v-if="hasServices" class="list-group">
      <h4 class="mb-4">Services</h4>

      <ServicesItem
        :name="name"
        :server="server"
        :key="name"
        v-for="name in sortedServices"/>
    </div>
    <UIWarningMessage v-else>
      There are no available services on <strong>{{ server }}</strong> server.
    </UIWarningMessage>
  </div>
</template>

<script>
import PeriodicallyTimer from '~/mixins/PeriodicallyTimer'

export default {
  mixins: [PeriodicallyTimer],
  props: {
    server: String,
    refreshTimeout: {
      type: Number,
      default: 2000
    }
  },
  data() {
    return {
      services: [],
    }
  },
  watch: {
    server() {
      this.fetchData()
    }
  },
  methods: {
    async fetchData() {
        this.services = await this.$api.services.list(this.server)
    }
  },
  computed: {
    hasServices() {
      return this.services.length > 0
    },
    sortedServices() {
      return this.services.sort(
        (a, b) => (a.name.substr(1) > b.name.substr(1)) ? -1 : ((b.name.substr(1) > a.name.substr(1) ? 1 : 0))
      )
    }
  },
}
</script>
