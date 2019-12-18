<template>
  <line-chart :chart-data="datacollection" :options="options"></line-chart>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import LineChart from "~/charts/LineChart.js";

export default {
    name: 'assessment-line-chart',
    components: {
        LineChart
    },
    props: [ 'userId' ],
    data () {
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
    computed: {
        ...mapGetters({
            user: "auth/user"
        })
    },
    mounted() {
        this.fetchAssessment();
    },
    methods: {
        async fetchAssessment() {
            try {
                const { data } = await axios.get(
                `/api/functional-state/chart/assessment/${this.userId}`
                );

                console.log(data)

                this.datacollection = {
                labels: this.labels,
                datasets: [
                    {
                        ...this.datasetDefault,
                        label: 'Оценка ФР и ФС',
                        backgroundColor: 'rgba(54, 162, 235, 0.3)',
                        borderColor: '#36A2EB',
                        pointBackgroundColor: '#36A2EB',
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverBackgroundColor: "#36A2EB",
                        data: data
                    }
                ]
                };
            } catch (error) {
                console.error(error)
            }
        }
    }
}
</script>

<style lang="less" scoped></style>
