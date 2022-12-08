<template>
<span>
  <b-dropdown
    v-if="hasTags"
    :variant="buttonVariant"
    size="sm"
  >
          <template #button-content>
            {{ metric.name }}
          </template>

          <b-dropdown-item
            v-for="tag in metric.tags"
            :variant="enabled(metric.name, tag) ? 'primary' : 'outline-primary'"
            :key="`${metric.name}-${tag.name}-${tag.value}`"
            @click="selectTag(metric.name, tag)"
          >
            {{ tag.name }}={{ tag.value }}
          </b-dropdown-item>
        </b-dropdown>
   <b-button
     @click="selectTag(metric.name)"
     :variant="buttonVariant"
     size="sm" v-else>
     {{ metric.name }}
   </b-button>
</span>
</template>

<script>
export default {
  props: {
    metric: Object,
  },
  data() {
    return {
      selected: []
    }
  },
  methods: {
    selectTag(name, tag) {
      this.$emit('toggle', name, tag)
      let metricId = name
      if (tag) {
        metricId = `${name}-{${tag.name}="${tag.value}"}`
      }

      if (this.selected.includes(metricId)) {
        this.selected = this.selected.filter(id => id !== metricId)
      } else {
        this.selected.push(metricId)
      }
    },
    enabled(name, tag) {
      let metricId = name
      if (tag) {
        metricId = `${name}-{${tag.name}="${tag.value}"}`
      }
      return this.selected.includes(metricId)
    }
  },
  computed: {
    buttonVariant() {
      if (this.selected.length > 0) {
        return 'primary'
      }

      return 'outline-primary'
    },
    hasTags() {
      return this.metric.tags.length > 0
    },

  }
}
</script>
