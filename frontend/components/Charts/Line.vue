<template>
  <div>
    <LineChart
      :chart-options="chartOptions"
      :chart-data="chartData"
      chart-id="line-chart"
      :height="height"
    />
  </div>
</template>

<script>
import {Line as LineChart} from "vue-chartjs/legacy";

export default {
  components: {LineChart},
  props: {
    units: {
      type: String,
      default: null
    },
    metrics: Object,
    height: {
      type: String,
      default: '50vh'
    },
  },
  computed: {
    chartData() {
      let datasets = []
      this.metrics.forEach(metric => {
        let dataset = {
          label: metric.metric.name,
          data: [],
          borderWidth: 1,
          borderColor: [
            'rgba(75, 192, 192, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
        }

        metric.range.values.forEach(([timestamp, value]) => {
          dataset.data.push({
            x: this.$moment.unix(timestamp).format('HH:mm:ss'),
            y: value
          });
        });

        datasets.push(dataset)
      })

      return {
        datasets: datasets
      }
    },
    chartOptions() {
      return {
        responsive: true,
        animation: false,
        elements: {
          point: {
            radius: 0
          }
        }
      }
    }
  },
}
</script>
