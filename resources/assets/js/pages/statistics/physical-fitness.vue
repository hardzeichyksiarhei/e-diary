<template>
  <div class="physical-fitness-page">
    <div class="row">
      <div class="col-md-12">
        <div class="nav-tabs-custom-pills">
          <ul class="nav nav-pills">
            <li class="active">
              <a href="#tables" data-toggle="tab">ФП (таблица)</a>
            </li>
            <li>
              <a href="#charts" data-toggle="tab">ФП (графики)</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="tables">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h4 class="box-title">
                    <i class="fa fa-fw fa-table"></i>Показатели ФП (таблица)
                  </h4>
                  <div class="box-tools pull-right d-flex">
                    <a
                      class="btn btn-box-tool text-light-blue"
                      :href="`/api/export/excel/physical-fitness/calculation/${user.id}`"
                    >
                      <i class="material-icons">queue</i>
                    </a>
                  </div>
                </div>
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table table-no-hover table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Тесты</th>
                          <th>Исход. дан. (нач. 1 сем.)</th>
                          <th>1 семестр</th>
                          <th>2 семестр</th>
                          <th>3 семестр</th>
                          <th>4 семестр</th>
                          <th>5 семестр</th>
                          <th>6 семестр</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="pf in physicalFitness" :key="pf.id">
                          <td>{{ pf.label }}</td>
                          <td>{{ pf.semester_0 || '-' }}</td>
                          <td>{{ pf.semester_1 || '-' }}</td>
                          <td>{{ pf.semester_2 || '-' }}</td>
                          <td>{{ pf.semester_3 || '-' }}</td>
                          <td>{{ pf.semester_4 || '-' }}</td>
                          <td>{{ pf.semester_5 || '-' }}</td>
                          <td>{{ pf.semester_6 || '-' }}</td>
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
                      <h4 class="box-title">
                        <i class="fa fa-fw fa-bar-chart"></i>Показатели ФП (по кол-ву баллов)
                      </h4>
                    </div>
                    <div class="box-body">
                      <physical-fitness-bar-chart v-if="renderChart" :user="user" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <i class="fa fa-fw fa-area-chart"></i>Оценка ФП
                      </h4>
                    </div>
                    <div class="box-body">
                      <physical-fitness-assessment-bar-chart v-if="renderChart" :user-id="user.id" />
                      <ul class="legend">
                        <li class="legend-item">
                          <b>1 – 2:</b> Низкий
                        </li>
                        <li class="legend-item">
                          <b>3 – 4:</b> Ниже среднего
                        </li>
                        <li class="legend-item">
                          <b>5 – 6:</b> Средний
                        </li>
                        <li class="legend-item">
                          <b>7 – 8:</b> Выше среднего
                        </li>
                        <li class="legend-item">
                          <b>9 – 10:</b> Высокий
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <i class="fa fa-fw fa-area-chart"></i>Общая оценка ФР, ФС и ФП
                      </h4>
                    </div>
                    <div class="box-body">
                      <common-assessment-bar-chart v-if="renderChart" :user-id="user.id" />
                      <ul class="legend">
                        <li class="legend-item">
                          <b>1 – 2:</b> Низкий
                        </li>
                        <li class="legend-item">
                          <b>3 – 4:</b> Ниже среднего
                        </li>
                        <li class="legend-item">
                          <b>5 – 6:</b> Средний
                        </li>
                        <li class="legend-item">
                          <b>7 – 8:</b> Выше среднего
                        </li>
                        <li class="legend-item">
                          <b>9 – 10:</b> Высокий
                        </li>
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
import { domainURL } from "~/config";
import PhysicalFitnessAssessmentBarChart from "~/components/BarCharts/PhysicalFitnessAssessmentBarChart";
import PhysicalFitnessBarChart from "~/components/BarCharts/PhysicalFitnessBarChart";
import CommonAssessmentBarChart from "~/components/BarCharts/CommonAssessmentBarChart";

export default {
  middleware: ["auth", "student"],

  name: "physical-fitness",

  components: {
    PhysicalFitnessAssessmentBarChart,
    PhysicalFitnessBarChart,
    CommonAssessmentBarChart
  },

  data() {
    return {
      renderChart: false,
      physicalFitness: []
    };
  },

  created() {
    this.fetchPhysicalFitness();
  },

  mounted() {
    $('a[data-toggle="tab"]').on("shown.bs.tab", e => {
      this.renderChart = true;
    });
  },

  computed: {
    ...mapGetters({
      user: "auth/user"
    })
  },

  methods: {
    async fetchPhysicalFitness() {
      const { data } = await axios.get(
        "/api/physical-fitness/calculation/" + this.user.id
      );

      this.physicalFitness = data;
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
