<template>
  <bar-chart :chart-data="datacollection" :options="options"></bar-chart>
</template>

<script>
import axios from 'axios'
import BarChart from '~/charts/BarChart.js'

export default {
  name: 'physical-fitness-bar-chart',
  components: {
    BarChart
  },
  props: ['user'],
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
        pointBorderWidth: 2,
        borderWidth: 2
      },
      options: {
        tooltips: {
          mode: 'index'
        },
        scales: {
          yAxes: [
            {
              ticks: {
                min: 0
              }
            }
          ]
        },
        responsive: true,
        maintainAspectRatio: false
      }
    }
  },
  mounted () {
    this.getMeasurementResultPoints()
  },
  methods: {
    async getMeasurementResultPoints () {
      try {
        const { data } = await axios.get(
          `/api/physical-fitness/calculation/chart/points/${this.user.id}`
				)
				
				console.log(data);

        let datasets = [
          {
            ...this.datasetDefault,
            label: 'Прыжок в длину с места, см',
            backgroundColor: 'rgba(236, 64, 122, 1)',
            borderColor: 'rgba(236, 64, 122, 1)',
            data: data['long_jump_point']
          },
          {
            ...this.datasetDefault,
            label: 'Наклон туловища вперед, см',
            backgroundColor: 'rgba(255, 167, 38, 1)',
            borderColor: 'rgba(255, 167, 38, 1)',
            data: data['torso_inclination_point']
          },
          {
            ...this.datasetDefault,
            label: 'Челночный бег 9 х 4 метров (сек)',
            backgroundColor: 'rgba(38, 166, 154, 1)',
            borderColor: 'rgba(38, 166, 154, 1)',
            data: data['run_shuttle_point']
          },
          {
            ...this.datasetDefault,
            label: 'Подтягивание на перекладине, кол-во раз',
            backgroundColor: 'rgba(171, 71, 188, 1)',
            borderColor: 'rgba(171, 71, 188, 1)',
            data: data['pull_up_point']
          },
          {
            ...this.datasetDefault,
            label: 'Поднимание туловища из положения лежа на спине за 60 с (раз)',
            backgroundColor: 'rgba(66, 165, 245, 1)',
            borderColor: 'rgba(66, 165, 245, 1)',
            data: data['press_point']
          },
          {
            ...this.datasetDefault,
            label: 'Сгибание и разгибание рук в упоре лежа, раз',
            backgroundColor: 'rgba(59, 212, 92, 1)',
            borderColor: 'rgba(59, 212, 92, 1)',
            data: data['push_up_point']
          },
          {
            ...this.datasetDefault,
            label: 'Бег 30 м (сек)',
            backgroundColor: 'rgba(199, 186, 42, 1)',
            borderColor: 'rgba(199, 186, 42, 1)',
            data: data['run_short_point']
          },
          {
            ...this.datasetDefault,
            label: 'Бег 1500/3000 метров (мин.сек)',
            backgroundColor: 'rgba(42, 165, 199, 1)',
            borderColor: 'rgba(42, 165, 199, 1)',
            data: data['run_long_point']
          },
          {
            ...this.datasetDefault,
            label: 'Плавание 50 метров',
            backgroundColor: 'rgba(199, 42, 120, 1)',
            borderColor: 'rgba(199, 42, 120, 1)',
            data: data['swimming_point']
          }
        ]

        if (this.user.profile.gender === 'woman') datasets.splice(3, 1);

        this.datacollection = {
          labels: this.labels,
          datasets
        }
      } catch (error) {
        console.error(error)
      }
    }
  }
}
</script>

<style lang="less" scoped></style>
