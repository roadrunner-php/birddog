<template>
<span>
  <b-dropdown
    v-if="hasTags"
    variant="outline-primary"
    size="sm"
  >
          <template #button-content>
            {{ metric.name }}
          </template>

          <b-dropdown-item
            v-for="tag in metric.tags"
            :variant="enabled(metric.name, tag) ? 'primary' : 'outline-primary'"
            :key="`${metric.name}-${tag.name}-${tag.value}`"
            @click="$emit('toggle', metric.name, tag)"
          >
            {{ tag.name }}={{ tag.value }}
          </b-dropdown-item>
        </b-dropdown>
   <b-button
     @click="$emit('toggle', metric.name)"
     :variant="enabled(metric.name) ? 'primary' : 'outline-primary'"
     size="sm" v-else>
     {{ metric.name }}
   </b-button>
</span>
</template>

<script>
export default {
  props: {
    metric: Object,
    selectedIds: Array
  },
  methods: {
    enabled(name, tag) {
      let metricId = name
      if (tag) {
        metricId = `${name}-{${tag.name}="${tag.value}"}`
      }
      return this.selectedIds.includes(metricId)
    }
  },
  computed: {
    hasTags() {
      return this.metric.tags.length > 0
    },

  }
}
</script>
