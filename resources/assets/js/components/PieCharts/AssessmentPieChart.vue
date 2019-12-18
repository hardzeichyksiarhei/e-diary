<template>
  <pie-chart :chart-data="datacollection" :options="options"></pie-chart>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import PieChart from "~/charts/PieChart.js";

export default {
    name: 'assessment-pie-chart',
    components: {
        PieChart
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
               
            },
            options: {
							legend: {
								labels: {
									fontFamily: "'Source Sans Pro', sans-serif"
								}
							},
							tooltips: {
								cornerRadius: 3
							},
							responsive: true,
							maintainAspectRatio: false
            }
        }
    },
    mounted() {
        this.fetchCommonAssessment();
    },
    methods: {
        async fetchCommonAssessment() {
            try {
                const { data } = await axios.get(
                `/api/functional-state/chart/common/assessment/${this.userId}`
                );

                console.log(data)

                this.datacollection = {
                labels: this.labels,
                datasets: [
                    {
                        ...this.datasetDefault,
                        label: 'Оценка физического состояния (ФР, ФС, ФП)',
                        backgroundColor: [
													'rgb(255, 99, 132)', // red
													'rgb(255, 159, 64)', 	// orange
													'rgb(255, 205, 86)', 	// yellow
													'rgb(75, 192, 192)', 	// green
													'rgb(54, 162, 235)', 	// blue
													'rgb(153, 102, 255)', 	// purple
													'rgb(201, 203, 207)' 	// grey
												],
                        borderColor: '#fff',
                        pointBackgroundColor: '#0275D8',
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverBackgroundColor: "#0275D8",
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
