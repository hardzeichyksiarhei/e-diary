<template>
  <div class="functional-state-page">
		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom-pills">
					<ul class="nav nav-pills">
						<li class="active"><a href="#tables" data-toggle="tab">ФР и ФС (таблица)</a></li>
						<li><a href="#charts" data-toggle="tab">ФР и ФС (графики)</a></li>
					</ul>
					<div class="tab-content">
						<div class="active tab-pane" id="tables">
							<div class="box box-primary">
								<div class="box-header with-border">
									<h4 class="box-title"><i class="fa fa-fw fa-table"></i>Показатели ФР и ФС</h4>
									<div class="box-tools pull-right d-flex">
                    <a class="btn btn-box-tool text-light-blue" :href="`/api/export/excel/function-state/calculation/${user.id}`">
                      <i class="material-icons">queue</i>
                    </a>
                  </div>
								</div>
								<div class="box-body">
									<div class="table-responsive">
										<table class="table table-no-hover table-bordered table-striped datatable" style="width:100%">
											<thead>
												<tr>
													<th>Показатели ФР и ФС</th>
													<th>Нач. 1 семестра</th>
													<th>1 семестр</th>
													<th>2 семестр</th>
													<th>3 семестр</th>
													<th>4 семестр</th>
													<th>5 семестр</th>
													<th>6 семестр</th>
												</tr>
											</thead>
                      <tbody>
                        <tr v-for="fs in functionalState" :key="fs.id">
                          <td>{{ fs.label }}</td>
                          <td>{{ fs.semester_0 }}</td>
                          <td>{{ fs.semester_1 }}</td>
                          <td>{{ fs.semester_2 }}</td>
                          <td>{{ fs.semester_3 }}</td>
                          <td>{{ fs.semester_4 }}</td>
                          <td>{{ fs.semester_5 }}</td>
                          <td>{{ fs.semester_6 }}</td>
                        </tr>
                      </tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!-- /.tab-pane -->

						<div class="tab-pane" id="charts">
							<div class="row">
								<div class="col-md-12">
									<div class="box box-primary">
										<div class="box-header with-border">
											<h4 class="box-title"><i class="fa fa-fw fa-bar-chart"></i>Показатели ФР и ФС (по кол-ву баллов)</h4>
										</div>
										<div class="box-body">
											<functional-state-bar-chart v-if="renderChart" :user-id="user.id"/>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="box box-primary">
										<div class="box-header with-border">
											<h4 class="box-title"><i class="fa fa-fw fa-area-chart"></i>Оценка ФР и ФС</h4>
										</div>
										<div class="box-body">
											<functional-state-assessment-bar-chart v-if="renderChart" :user-id="user.id"/>
                      <ul class="legend">
                        <li class="legend-item"><b>1 – 2:</b> Низкий</li>
                        <li class="legend-item"><b>3 – 4:</b> Ниже среднего</li>
                        <li class="legend-item"><b>5 – 6:</b> Средний</li>
                        <li class="legend-item"><b>7 – 8:</b> Выше среднего</li>
                        <li class="legend-item"><b>9 – 10:</b> Высокий</li>
                      </ul>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="box box-primary">
										<div class="box-header with-border">
											<h4 class="box-title"><i class="fa fa-fw fa-area-chart"></i>Общая оценка ФР, ФС и ФП</h4>
										</div>
										<div class="box-body">
											<common-assessment-bar-chart v-if="renderChart" :user-id="user.id"/>
                      <ul class="legend">
                        <li class="legend-item"><b>1 – 2:</b> Низкий</li>
                        <li class="legend-item"><b>3 – 4:</b> Ниже среднего</li>
                        <li class="legend-item"><b>5 – 6:</b> Средний</li>
                        <li class="legend-item"><b>7 – 8:</b> Выше среднего</li>
                        <li class="legend-item"><b>9 – 10:</b> Высокий</li>
                      </ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- /.nav-tabs-custom -->
			</div>
		</div>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import { domainURL } from '~/config'
import FunctionalStateAssessmentBarChart from "~/components/BarCharts/FunctionalStateAssessmentBarChart"
import FunctionalStateBarChart from "~/components/BarCharts/FunctionalStateBarChart"
import CommonAssessmentBarChart from "~/components/BarCharts/CommonAssessmentBarChart"

export default {
  middleware: ["auth", "student"],

  name: "functional-state",

  components: {
    FunctionalStateAssessmentBarChart,
		FunctionalStateBarChart,
		CommonAssessmentBarChart
	},

	data () {
		return {
      renderChart: false,
      functionalState: []
		}
	},

  mounted() {

		$('a[data-toggle="tab"]').on('shown.bs.tab', (e) => {
			this.renderChart = true
		})

  },

  created () {
    this.fetchFunctionalState();
  },

  computed: mapGetters({
		user: "auth/user"
	}),

  methods: {
    async fetchFunctionalState () {
      const { data } = await axios.get('/api/functional-state/calculation/' + this.user.id)

      this.functionalState = data;

      console.log(data);
    }
  }
};
</script>

<style lang="scss">
  .legend {
    list-style-type: none;
    margin-top: 15px;
    &-item {
      margin-top: 5px;
      margin-left: -4px;
      b {
        margin-right: 5px;
      }
    }
  }
</style>
