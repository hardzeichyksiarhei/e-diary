<!--suppress JSFileReferences -->
<template>
  <bar-chart :chart-data="datacollection" :options="options"></bar-chart>
</template>

<script>
import axios from "axios";
import BarChart from "~/charts/BarChart.js";

export default {
  name: "functional-state-bar-chart",
  components: {
    BarChart
  },
  props: ["userId"],
  data() {
    return {
      datacollection: null,
      labels: [
        "Исходные данные",
        "1 семестр",
        "2 семестр",
        "3 семестр",
        "4 семестр",
        "5 семестр",
        "6 семестр"
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
          mode: "index"
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
    };
  },
  mounted() {
    this.getMeasurementResultPoints();
  },
  methods: {
    async getMeasurementResultPoints() {
      try {
        const { data } = await axios.get(
          `/api/functional-state/calculation/chart/points/${this.userId}`
        );

        this.datacollection = {
          labels: this.labels,
          datasets: [
            {
              ...this.datasetDefault,
              label: "Росто-массовый показатель",
              backgroundColor: "rgba(236, 64, 122, 1)",
              borderColor: "rgba(236, 64, 122, 1)",
              data: data["mass_index_point"]
            },
            {
              ...this.datasetDefault,
              label: "Ортостатическая проба",
              backgroundColor: "rgba(255, 167, 38, 1)",
              borderColor: "rgba(255, 167, 38, 1)",
              data: data["orthostatic_test_point"]
            },
            {
              ...this.datasetDefault,
              label: "Проба на дозированную нагрузку",
              backgroundColor: "rgba(38, 166, 154, 1)",
              borderColor: "rgba(38, 166, 154, 1)",
              data: data["dosed_load_point"]
            },
            {
              ...this.datasetDefault,
              label: "Проба Штанге",
              backgroundColor: "rgba(171, 71, 188, 1)",
              borderColor: "rgba(171, 71, 188, 1)",
              data: data["sample_shtange_point"]
            },
            {
              ...this.datasetDefault,
              label: "Проба Генчи",
              backgroundColor: "rgba(66, 165, 245, 1)",
              borderColor: "rgba(66, 165, 245, 1)",
              data: data["sample_genchi_point"]
            }
          ]
        };
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>

<style lang="less" scoped></style>
