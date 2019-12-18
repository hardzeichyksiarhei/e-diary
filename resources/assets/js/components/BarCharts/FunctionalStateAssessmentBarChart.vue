<!--suppress JSFileReferences -->
<template>
  <bar-chart :chart-data="datacollection" :options="options"></bar-chart>
</template>

<script>
import axios from 'axios'
import BarChart from '~/charts/BarChart.js'

export default {
  name: 'functional-state-assessment-bar-chart',
  components: {
    BarChart
  },
  props: ['userId'],
  data () {
    return {
      datacollection: null,
      labels: [
        'Исходные данные',
        '1 семестр',
        '2 семестр',
        '3 семестр',
        '4 семестр',
        '5 семестр',
        '6 семестр'
      ],
      datasetDefault: {
        lineTension: 0.3,
        pointRadius: 5,
        pointHoverRadius: 5,
        pointHitRadius: 20,
        pointBorderWidth: 2
      },
      options: {
        legend: {
          display: false
        },
        tooltips: {
          cornerRadius: 3
        },
        scales: {
          yAxes: [{
            ticks: {
              max: 10,
              min: 1,
              stepSize: 1
            }
          }]
        },
        responsive: true,
        maintainAspectRatio: false
      }
    }
  },
  mounted () {
    this.fetchAssessment()
  },
  methods: {
    async fetchAssessment () {
      try {
        const { data } = await axios.get(
          `/api/functional-state/chart/assessment/${this.userId}`
        )

        this.datacollection = {
          labels: this.labels,
          datasets: [
            {
              ...this.datasetDefault,
              label: 'Оценка ФР и ФС',
              backgroundColor: 'rgba(236, 64, 122, 1)',
              borderColor: '#36A2EB',
              pointBackgroundColor: '#36A2EB',
              pointBorderColor: 'rgba(255,255,255,0.8)',
              pointHoverBackgroundColor: '#36A2EB',
              data: data['assessment']
            }
          ]
        }
      } catch (error) {
        console.error(error)
      }
    }
  }
}
</script>

<style lang="less" scoped></style>
