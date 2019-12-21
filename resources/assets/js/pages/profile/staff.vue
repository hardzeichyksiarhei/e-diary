<template>
  <div class="student-wrapper">
    <div class="row">
      <div class="col-md-3 col-sm-4">

        <!-- Profile Image -->
        <image-staff-box :user="user"/>
        <about-me-staff-box :user="user"/>
        
      </div>
      <!-- /.col -->
      <div class="col-md-9 col-sm-8">
				<div class="nav-tabs-custom-pills">
					<ul class="nav nav-pills">
						<li class="active"><a href="#students" data-toggle="tab">Студенты</a></li>
					</ul>
					<div class="tab-content">
						<div class="active tab-pane" id="students">
							<div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Расширенный поиск</h3>
                </div>
                <div class="box-body">
                    <form @submit.prevent="fetchStudents">
                        <div class="form-row">
                          <div class="col-md-3 col-xs-12 mb-3">
                            <label for="name">Имя</label>
                            <input class="form-control" id="name" type="text" name="name" placeholder="Любое имя"
                                v-model="search.name"
                            >
                          </div>
                          <div class="col-md-3 col-xs-12 mb-3">
                            <label for="faculty">Факультет</label>
                            <select2 class="form-control select2" :options="listFaculties" v-model="search.faculty"></select2>
                          </div>
                          <div class="col-md-2 col-xs-12 mb-3">
                            <label for="birthday">Дата рождения</label>
                            <input type="text" class="form-control" id="birthday" name="birthday" placeholder="Любая дата"
                              v-model="search.birthday"
                            >
                          </div>
                          <div class="col-md-2 col-xs-12 mb-3">
                            <label for="course">Курс</label>
                            <select class="form-control" id="course" name="course"
                                    v-model="search.course"
                            >
                                <option v-for="course in listCourses" :value="course.value" :key="course.value">{{ course.text }}</option>
                            </select>
                          </div>
                          <div class="col-md-2 col-xs-12 mb-3">
                            <label for="group">Группа</label>
                            <input type="text" class="form-control" id="group" name="group" placeholder="Любая группа"
                              v-model="search.group"
                            >
                          </div>
                        </div>
                        <v-button class="btn-sm text-uppercase" type="primary"><i class="fa fa-search"></i>&nbsp;&nbsp;Поиск</v-button>
                        <button type="button" class="btn btn-success btn-sm text-uppercase" @click.prevent="clearSearch">
                          <i class="fa fa-refresh"></i>&nbsp;&nbsp;Сброс
                        </button>
                    </form>
                </div>
              </div>
              <div v-if="listStudents.data.length" class="box box-primary">
                  <div class="box-header with-border">
                    <i class="fa fa-table"></i>
                    <h3 class="box-title">Студенты</h3>
                  </div>
                  <div v-if="selectStudentsID.length > 1" class="students-selected-tools">
                    <span>{{ selectedCount }}</span>
                    <a href="javascript:void(0)" @click.prevent="deleteStudents(selectStudentsID)">Удалить выделенные</a>
                    <a href="javascript:void(0)" @click.prevent="unselectAll">Снять выделение</a>
                  </div>
                  <div class="box-body">
                      <div class="per-page-wrapper">
                        <a href="javascript:void(0)" 
                          :class="{ 'active' : pp == perPage || (perPage == listStudents.total && pp == -1) }"
                          v-for="pp in perPages" :key="pp" @click.prevent="changePerPage(pp)"
                        >{{ pp != -1 ? pp : 'Все' }}</a>
                      </div>
                      <table class="table table-bordered table-striped table-no-hover">
                          <thead>
                            <tr>
                              <th class="select-student"><checkbox v-model="selectAll"/></th>
                              <th id="name">Имя</th>
                              <th id="birthday">Дата рождения</th>
                              <th id="course">Курс</th>
                              <th id="group">Группа</th>
                              <th id="faculty">Факультет</th>
                              <th>Опции</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="student in listStudents.data" :key="student.id">
                              <td class="select-student">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" :id="`student-${student.id}`" class="custom-control-input" 
                                    :value="student.id"
                                    v-model="selectStudentsID">
                                  <label :for="`student-${student.id}`" class="custom-control-label"></label>
                                </div>
                              </td>
                              <td><a href="javascript:void(0)" @click.prevent="$router.push({
                                name: 'profile.student',
                                params: { id: student.id }
                              })">{{ student.name }}</a></td>
                              <td>{{ student.birthday }}</td>
                              <td>{{ student.course }}</td>
                              <td>{{ student.group }}</td>
                              <td>{{ student.faculty_name }}</td>
                              <td class="options">
                                <div class="btn-group">
                                  <button class="btn btn-sm btn-success w-50 user-profile-btn" 
                                      @click.prevent="$router.push({
                                        name: 'profile.student',
                                        params: { id: student.id }
                                      })"
                                  ><i class="fa fa-id-card fa-fw"></i></button>
                                  <button class="btn btn-sm btn-danger w-50 user-delete-btn" @click.prevent="deleteStudents(student.id)"><i class="fa fa-trash fa-fw"></i></button>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                      </table>
                      <pagination :data="listStudents" :limit="3" @pagination-change-page="fetchStudents" :show-disabled="true">
                        <span slot="prev-nav"><i class="fa fa-angle-left"></i></span>
	                      <span slot="next-nav"><i class="fa fa-angle-right"></i></span>
                      </pagination>
                  </div>
              </div>
              <div v-if="notFoundFlag" class="box box-primary box-not-found">
                <div class="box-body">
                  <img :src="notFoundImg" alt="Not Found">
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
import axios from 'axios'
import { domainURL } from '~/config'

import ImageStaffBox from "~/components/profile/ImageStaffBox";
import AboutMeStaffBox from "~/components/profile/AboutMeStaffBox";

export default {
	middleware: ['auth', 'admin'],

	name: 'staff',

	components: {
    ImageStaffBox,
    AboutMeStaffBox
	},

	data () {
		return {
			user: {
				name: '',
				role: '',
				photo_url: '',
				profile: {}
      },
      notFoundFlag: false,
      notFoundImg: domainURL + '/images/not_found.png',
      listCourses: [
        { text: 'Все', value: '' },
        { text: 1, value: 1 },
        { text: 2, value: 2 },
        { text: 3, value: 3 }
      ],
			listFaculties: [{ text: 'Все', id: '' }],
      perPages: [
        15, 30, 45, -1
      ],
      perPage: 15,
      listStudents: {
        data: []
      },
      selectAll: false,
      allStudentsID: [],
      selectStudentsID: [],
      search: {
        name: '',
        faculty: '',
        teacher: '',
        birthday: '',
        course: '',
        group: ''
      }
		}
	},

	filters: {
		isEmpty (value) {
			return value || 'Нет данных'
		}
  },
  
  created () {
    this.getUserByID();
    this.fetchInitialData()
  },
  
  computed: {
    selectedCount () {
			if (this.selectStudentsID.length < 5) return `Выбрано ${this.selectStudentsID.length} студента`
			else return `Выбрано ${this.selectStudentsID.length} студентов`
		}
  },

  watch: {
		selectAll (value) {
			if (value) this.selectStudentsID = this.allStudentsID;
			if (!value && this.selectStudentsID.length === this.listStudents.data.length) this.selectStudentsID = []
		},
		selectStudentsID (newValue, oldValue) {
			if (newValue.length > 0 && newValue.length < this.listStudents.data.length ) this.selectAll = false
			if (newValue.length && newValue.length === this.listStudents.data.length) this.selectAll = true
		}
	},

  methods: {
    async getUserByID () {
			let id = this.$route.params.id
			const { data } = await axios.get(`/api/user/${id}`);

      this.user = data
      
      this.search.teacher = this.user.name;
      this.fetchStudents()
		},
    async fetchInitialData() {
      try {
				const listFaculties = await axios.get("/api/faculty");
        
        let newListFaculties = _.map(listFaculties.data, function (obj) {
          obj.text = obj.text || obj.name;
          obj.id = obj.name;
					return obj;
				});

				this.listFaculties.push(...newListFaculties)
      } catch (error) {
        console.error(error);
      }
    },
    async fetchStudents (page = 1) {
      const { data } = await axios.get('/api/user/student/paginate?page=' + page, { 
        params: { 
          search: this.search,
          per_page: this.perPage
        } 
      });
      this.listStudents = data;
      this.notFoundFlag = this.listStudents.data.length == 0;
      this.allStudentsID = _.map(this.listStudents.data, 'id');
      if (this.selectAll) this.selectStudentsID = this.allStudentsID;
    },
    async exportToExcel(semester = 0) {
      let ids = this.selectStudentsID;
      if (ids.length == 0) ids = this.allStudentsID;
      await axios.post('/api/export/excel/students', { ids, semester });
      window.location.href = `${domainURL}/exports/students.xlsx`;
    },
    async exportToPdf() {
      await axios.post('/api/export/pdf/students', { ids: this.selectStudentsID });
      window.open(`${domainURL}/exports/students.pdf`, '_blank');
    },
    async deleteStudents(ids) {
      if (Array.isArray(ids) && ids.length == 0) {
        IziToast.warning({ message: 'Ничего не выбрано' })
        return false;
      }
      
      await axios.delete('/api/user/', { params: { ids } })

      this.fetchStudents();

      if (Array.isArray(ids) && ids.length > 0) {
        this.unselectAll();
      } else {
        let index = this.selectStudentsID.indexOf(ids);
        if (index > -1) {
          this.selectStudentsID.splice(index, 1);
        }
      }

      IziToast.info({ message: 'Студент(-ы) удален(-ы)' })
    },
    changePerPage (pp) {
      this.perPage = (pp == -1) ? this.listStudents.total : pp;
      this.fetchStudents();
    },
    clearSearch () {
      this.search = {
        name: '',
        faculty: '',
        birthday: '',
        course: '',
        teacher: this.user.name,
        group: ''
      };
      this.fetchStudents();
    },
    unselectAll () {
			this.selectAll = false
			this.selectStudentsID = []
		}
  }
}
</script>

<style lang='scss' scoped>
.table {
    tr {
      td, th {
        &.select-student {
          max-width: 25px;
          text-align: center;
          .custom-checkbox {
            display: inline-block;
          }
        }
        &.options {
          .btn-group {
            width: 100%;
            display: flex;
          }
        }
      }
    }
  }
  .box-not-found {
    .box-body {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px 0;
      img {
        width: 240px;
        height: auto;
      }
    }
  }
  .per-page-wrapper {
    display: flex;
    padding-bottom: 10px;
    a {
      margin-right: 15px;
      color: #333;
      &.active {
        color: #3c8dbc;
      }
    }
  }
  .students-selected-tools {
    padding: 10px;
    background-color: #ffeba0;
    text-align: center;
    a {
      display: inline-block;
      font-weight: 600;
      color: #000;
      margin-left: 10px;
    }
  }
  .pagination {
    margin-bottom: 10px;
  }
</style>