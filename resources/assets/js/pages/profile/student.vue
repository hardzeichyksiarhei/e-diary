<template>
  <div class="student-wrapper">
    <div class="row">
      <div class="col-md-3 col-sm-4">
        <!-- Profile Image -->
        <image-student-box :user="user" />

        <!-- About Me Box -->
        <about-me-student-box :user="user" />
      </div>
      <!-- /.col -->
      <div class="col-md-9 col-sm-8">
        <div class="nav-tabs-custom-pills">
          <ul class="nav nav-pills">
            <li class="active">
              <a href="#fs-tables" data-toggle="tab">ФР и ФС (таблица)</a>
            </li>
            <li>
              <a href="#fs-charts" data-toggle="tab">ФР и ФС (графики)</a>
            </li>
            <li>
              <a href="#pf-tables" data-toggle="tab">ФП (таблица)</a>
            </li>
            <li>
              <a href="#pf-charts" data-toggle="tab">ФП (графики)</a>
            </li>
            <li>
              <a href="#ca" data-toggle="tab">Общая оценка ФР, ФС и ФП</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="fs-tables">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h4 class="box-title">
                    <i class="fa fa-fw fa-table"></i>Показатели ФР и ФС
                  </h4>
                  <div class="box-tools pull-right d-flex"></div>
                </div>
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table table-no-hover table-bordered table-striped">
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
                        <template v-if="functionalState">
                          <tr v-for="fs in functionalState" :key="fs.id">
                            <td>{{ fs.label }}</td>
                            <td>{{ fs.semester_0 | isEmpty }}</td>
                            <td>{{ fs.semester_1 | isEmpty }}</td>
                            <td>{{ fs.semester_2 | isEmpty }}</td>
                            <td>{{ fs.semester_3 | isEmpty }}</td>
                            <td>{{ fs.semester_4 | isEmpty }}</td>
                            <td>{{ fs.semester_5 | isEmpty }}</td>
                            <td>{{ fs.semester_6 | isEmpty }}</td>
                          </tr>
                          <tr v-if="functionalState">
                            <td><b>Управление</b></td>
                            <td v-for="sem in 7">
                              <button class="btn btn-sm btn-danger w-100" @click.prevent="emptyFS(sem - 1)" :disabled="!functionalState.updated_at[`semester_${sem - 1}`]">Очистить</button>
                            </td>
                          </tr>
                        </template>
                        <tr v-else>
                          <td colspan="8" align="center">Данных нет</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="fs-charts">
              <div class="row">
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <i class="fa fa-fw fa-bar-chart"/>Показатели ФР и ФС (по кол-ву баллов)
                      </h4>
                    </div>
                    <div class="box-body">
                      <functional-state-bar-chart v-if="renderFSChart" :user-id="$route.params.id" />
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <i class="fa fa-fw fa-area-chart"/>Оценка ФР и ФС
                      </h4>
                    </div>
                    <div class="box-body">
                      <functional-state-assessment-bar-chart
                        v-if="renderFSChart"
                        :user-id="$route.params.id"
                      />
                    </div>
                  </div>
                </div>
                <!-- <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <i class="fa fa-fw fa-area-chart"></i>Общая оценка ФР, ФС и ФП
                      </h4>
                    </div>
                    <div class="box-body">
                      <common-assessment-bar-chart
                        v-if="renderFSChart"
                        :user-id="$route.params.id"
                      />
                    </div>
                  </div>
                </div>-->
              </div>
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="pf-tables">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h4 class="box-title">
                    <i class="fa fa-fw fa-table"></i>Показатели ФР и ФС
                  </h4>
                  <div class="box-tools pull-right d-flex"></div>
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
                        <template v-if="physicalFitness">
                          <tr v-for="pf in physicalFitness" :key="pf.id">
                            <td>{{ pf.label }}</td>
                            <td>{{ pf.semester_0 | isEmpty }}</td>
                            <td>{{ pf.semester_1 | isEmpty }}</td>
                            <td>{{ pf.semester_2 | isEmpty }}</td>
                            <td>{{ pf.semester_3 | isEmpty }}</td>
                            <td>{{ pf.semester_4 | isEmpty }}</td>
                            <td>{{ pf.semester_5 | isEmpty }}</td>
                            <td>{{ pf.semester_6 | isEmpty }}</td>
                          </tr>
                        </template>
                        <tr v-else>
                          <td colspan="8" align="center">Данных нет</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="pf-charts">
              <div class="row">
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <i class="fa fa-fw fa-bar-chart"/>Показатели ФП (по кол-ву баллов)
                      </h4>
                    </div>
                    <div class="box-body">
                      <physical-fitness-bar-chart v-if="renderPFChart" :user="user" />
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <i class="fa fa-fw fa-area-chart"/>Оценка ФП
                      </h4>
                    </div>
                    <div class="box-body">
                      <physical-fitness-assessment-bar-chart
                        v-if="renderPFChart"
                        :user-id="$route.params.id"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="ca">
              <div class="row">
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <i class="fa fa-fw fa-table"/>Общая оценка ФР, ФС и ФП
                      </h4>
                      <div class="box-tools pull-right d-flex"></div>
                    </div>
                    <div class="box-body">
                      <div class="table-responsive">
                        <table class="table table-no-hover table-bordered table-striped">
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
                            <template v-if="commonAssessment">
                              <tr v-for="ca in commonAssessment" :key="ca.id">
                                <td>{{ ca.label }}</td>
                                <td>{{ ca.semester_0 | isEmpty }}</td>
                                <td>{{ ca.semester_1 | isEmpty }}</td>
                                <td>{{ ca.semester_2 | isEmpty }}</td>
                                <td>{{ ca.semester_3 | isEmpty }}</td>
                                <td>{{ ca.semester_4 | isEmpty }}</td>
                                <td>{{ ca.semester_5 | isEmpty }}</td>
                                <td>{{ ca.semester_6 | isEmpty }}</td>
                              </tr>
                            </template>
                            <tr v-else>
                              <td colspan="8" align="center">Данных нет</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <i class="fa fa-fw fa-area-chart"/>Общая оценка ФР, ФС и ФП
                      </h4>
                    </div>
                    <div class="box-body">
                      <common-assessment-bar-chart
                        v-if="renderCAChart"
                        :user-id="$route.params.id"
                      />
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
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
</template>

<script>
import axios from "axios";
import { domainURL } from "~/config";

import ImageStudentBox from "../../components/profile/ImageStudentBox";
import AboutMeStudentBox from "../../components/profile/AboutMeStudentBox";

import FunctionalStateAssessmentBarChart from "~/components/BarCharts/FunctionalStateAssessmentBarChart";
import FunctionalStateBarChart from "~/components/BarCharts/FunctionalStateBarChart";
import CommonAssessmentBarChart from "~/components/BarCharts/CommonAssessmentBarChart";

import PhysicalFitnessAssessmentBarChart from "~/components/BarCharts/PhysicalFitnessAssessmentBarChart";
import PhysicalFitnessBarChart from "~/components/BarCharts/PhysicalFitnessBarChart";

export default {
  middleware: ["auth", "not-student"],

  name: "student",

  components: {
    ImageStudentBox,
    AboutMeStudentBox,

    FunctionalStateAssessmentBarChart,
    FunctionalStateBarChart,
    CommonAssessmentBarChart,

    PhysicalFitnessAssessmentBarChart,
    PhysicalFitnessBarChart
  },

  data() {
    return {
      renderFSChart: false,
      renderPFChart: false,
      renderCAChart: false,
      user: {
        name: "",
        role: "",
        photo_url: "",
        profile: {
          age: "",
          teacher: {
            name: ""
          },
          health_group: {
            name: ""
          },
          faculty: {
            name: ""
          }
        }
      },
      functionalState: null,
      physicalFitness: null,
      commonAssessment: null
    };
  },

  mounted() {
    $('a[href="#fs-charts"]').on("shown.bs.tab", e => {
      this.renderFSChart = true;
    });

    $('a[href="#pf-charts"]').on("shown.bs.tab", e => {
      this.renderPFChart = true;
    });

    $('a[href="#ca"]').on("shown.bs.tab", e => {
      this.renderCAChart = true;
    });
  },

  created() {
    this.getUserByID();
    this.fetchFunctionalState();
    this.fetchPhysicalFitness();
    this.fetchCommonAssessment();
  },

  filters: {
    isEmpty(value) {
      return (value === null || value === '') ? '-' : value;
    }
  },

  methods: {
    async getUserByID() {
      let id = this.$route.params.id;
      const { data } = await axios.get(`/api/user/${id}`);

      this.user = data;
    },
    async fetchFunctionalState() {
      const { data } = await axios.get(
        "/api/functional-state/calculation/" + this.$route.params.id
      );

      console.log(data)

      this.functionalState = data;
    },
    async fetchPhysicalFitness() {
      const { data } = await axios.get(
        "/api/physical-fitness/calculation/" + this.$route.params.id
      );

      this.physicalFitness = data;
    },
    async fetchCommonAssessment() {
      const { data } = await axios.get(
        "/api/common/assessment/calculation/" + this.$route.params.id
      );

      this.commonAssessment = data;
    },

    async emptyFS(sem) {
      const is_empty = confirm('Вы уверены?');
      if (!is_empty) return;

      let user_id = this.$route.params.id;

      try {
        const { data, status } = await axios.delete(
          `/api/functional-state/calculation/${user_id}/${sem}`
        );

        if (status !== 200) return;

        for (let fsKey in this.functionalState) {
          if (!this.functionalState.hasOwnProperty(fsKey)) continue;
          this.functionalState[fsKey]['semester_' + sem] = null;
        }

        IziToast.success({ message: 'Очищено' })
      } catch (error) { console.error(error); }
    }
  }
};
</script>
