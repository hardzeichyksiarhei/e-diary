<template>
  <div class="physical-fitness-page">
    <div class="row">
      <div class="col-md-12">
        <div class="nav-tabs-custom-pills">
          <ul class="nav nav-pills">
            <li class="active">
              <a href="#tables" data-toggle="tab">Общая оценка ФР, ФС и ФП (таблица)</a>
            </li>
            <li>
              <a href="#charts" data-toggle="tab">Общая оценка ФР, ФС и ФП (графики)</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="tables">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h4 class="box-title">
                    <i class="fa fa-fw fa-table"></i>Общая оценка ФР, ФС и ФП (таблица)
                  </h4>
                  <!-- <div class="box-tools pull-right d-flex">
                    <a
                      class="btn btn-box-tool text-light-blue"
                      :href="`/api/export/excel/physical-fitness/calculation/${user.id}`"
                    >
                      <i class="material-icons">queue</i>
                    </a>
                  </div> -->
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
                        <tr v-for="ca in commonAssessment" :key="ca.id">
                          <td>{{ ca.label }}</td>
                          <td>{{ ca.semester_0 || '-' }}</td>
                          <td>{{ ca.semester_1 || '-' }}</td>
                          <td>{{ ca.semester_2 || '-' }}</td>
                          <td>{{ ca.semester_3 || '-' }}</td>
                          <td>{{ ca.semester_4 || '-' }}</td>
                          <td>{{ ca.semester_5 || '-' }}</td>
                          <td>{{ ca.semester_6 || '-' }}</td>
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
import CommonAssessmentBarChart from "~/components/BarCharts/CommonAssessmentBarChart";

export default {
  middleware: ["auth", "student"],

  name: "physical-fitness",

  components: {
    CommonAssessmentBarChart
  },

  data() {
    return {
      renderChart: false,
      commonAssessment: []
    };
  },

  created() {
    this.fetchCommonAssessment();
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
    async fetchCommonAssessment() {
      const { data } = await axios.get(
        "/api/common/assessment/calculation/" + this.user.id
      );

      this.commonAssessment = data;
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