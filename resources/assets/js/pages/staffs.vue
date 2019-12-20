<template>
    <div class="Staffs-page">
        <div class="row">
            <div class="col-lg-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Расширенный поиск</h3>
                </div>
                <div class="box-body">
                  <form @submit.prevent="fetchStaffs">
                    <div class="form-row">
                      <div class="col-md-4 col-xs-12 mb-3">
                        <label for="name">Имя</label>
                        <input class="form-control" id="name" type="text" name="name" placeholder="Любое имя"
                            v-model="search.name"
                        >
                      </div>
                      <div class="col-md-4 col-xs-12 mb-3">
                        <label for="email">E-mail</label>
                        <input class="form-control" id="email" type="text" name="email" placeholder="Любой E-mail"
                            v-model="search.email"
                        >
                      </div>
                      <div class="col-md-4 col-xs-12 mb-3">
                        <label for="course">Права доступа</label>
                        <select class="form-control" id="role" name="role"
                                v-model="search.role"
                        >
                            <option v-for="role in listRoles" :value="role.value" :key="role.value">{{ role.text }}</option>
                        </select>
                      </div>
                    </div>
                    <v-button class="btn-sm text-uppercase" type="primary"><i class="fa fa-search"></i>&nbsp;&nbsp;Поиск</v-button>
                    <button type="button" class="btn btn-success btn-sm text-uppercase" @click="clearSearch"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Сброс</button>
                  </form>
                </div>
              </div>
              <div v-if="listStaffs.data.length"  class="box box-primary">
                  <div class="box-header with-border">
                    <i class="fa fa-table"></i>
                    <h3 class="box-title">Преподаватели</h3>
                  </div>
                  <div v-if="selectStaffsID.length > 1" class="staffs-selected-tools">
                    <span>{{ selectedCount }}</span>
                    <a href="javascript:void(0)" @click.prevent="deleteStaffs(selectStaffsID)">Удалить выделенные</a>
                    <a href="javascript:void(0)" @click.prevent="unselectAll">Снять выделение</a>
                  </div>
                  <div class="box-body">
                    <div class="per-page-wrapper">
                      <a href="javascript:void(0)" 
                        :class="{ 'active' : pp == perPage || (perPage == listStaffs.total && pp == -1) }"
                        v-for="pp in perPages" :key="pp" @click.prevent="changePerPage(pp)"
                      >{{ pp != -1 ? pp : 'Все' }}</a>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped table-no-hover">
                        <thead>
                          <tr>
                            <th class="select-staff"><checkbox v-model="selectAll"/></th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Права доступа</th>
                            <th>Должность</th>
                            <th>Дата регистрации</th>
                            <th>Опции</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="staff in listStaffs.data" :key="staff.id">
                            <td class="select-staff">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" :id="`staff-${staff.id}`" class="custom-control-input" 
                                  :value="staff.id"
                                  v-model="selectStaffsID">
                                <label :for="`staff-${staff.id}`" class="custom-control-label"></label>
                              </div>
                            </td>
                            <td><a href="javascript:void(0)" @click.prevent="$router.push({
                              name: 'profile.staff',
                              params: { id: staff.id }
                            })">{{ staff.name }}</a></td>
                            <td>{{ staff.email }}</td>
                            <td>{{ staff.role == 'admin' ? 'Администратор' : 'Преподаватель' }}</td>
                            <td>{{ staff.profile.position || 'Не указано' }}</td>
                            <td>{{ staff.created_at }}</td>
                            <td class="options">
                              <div class="btn-group">
                                <button class="btn btn-sm btn-success w-50 user-profile-btn" 
                                    @click.prevent="$router.push({
                                      name: 'profile.staff',
                                      params: { id: staff.id }
                                    })"
                                ><i class="fa fa-id-card fa-fw"></i></button>
                                <button class="btn btn-sm btn-danger w-50 user-delete-btn" @click.prevent="deleteStaffs(staff.id)"><i class="fa fa-trash fa-fw"></i></button>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <pagination :data="listStaffs" :limit="3" @pagination-change-page="fetchStaffs" :show-disabled="true">
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
        </div>
    </div>
</template>

<script>
	import axios from 'axios'
	import { domainURL } from '~/config'

  export default {
    middleware: ['auth', 'admin'],

    name: "staffs",

    metaInfo() {
      return { title: 'Сотрудники' }
    },

    data () {
      return {
        notFoundFlag: false,
        notFoundImg: domainURL + '/images/not_found.png',
        perPages: [
          15, 30, 45, -1
        ],
        perPage: 15,
        listStaffs: {
          data: []
        },
        listRoles: [
          { text: 'Все', value: '' },
          { text: 'Администратор', value: 'admin' },
          { text: 'Преподаватель', value: 'teacher' }
        ],
        selectAll: false,
        allStaffsID: [],
        selectStaffsID: [],
        search: {
          name: '',
          email: '',
          role: ''
        }
      }
    },

    created () {
      this.fetchStaffs()
    },

    computed: {
      selectedCount () {
        if (this.selectStaffsID.length < 5) return `Выбрано ${this.selectStaffsID.length} студента`
        else return `Выбрано ${this.selectStaffsID.length} студентов`
      }
    },

    watch: {
      selectAll (value) {
        if (value) this.selectStaffsID = this.allStaffsID;
        if (!value && this.selectStaffsID.length === this.listStaffs.data.length) this.selectStaffsID = []
      },
      selectStaffsID (newValue, oldValue) {
        console.log(newValue);
        if (newValue.length > 0 && newValue.length < this.listStaffs.data.length ) this.selectAll = false
        if (newValue.length && newValue.length === this.listStaffs.data.length) this.selectAll = true
      }
    },
    
    methods: {
      async fetchStaffs (page = 1) {
        const { data } = await axios.get('/api/user/staff/paginate?page=' + page, { 
          params: { 
            search: this.search,
            per_page: this.perPage
          } 
        });
        this.listStaffs = data;
        this.notFoundFlag = this.listStaffs.data.length == 0;
        this.allStaffsID = _.map(this.listStaffs.data, 'id');
        if (this.selectAll) this.selectStaffsID = this.allStaffsID;
        console.log(data);
      },
      clearSearch () {
        this.search = {
          name: '',
          email: '',
          role: ''
        };
        this.fetchStaffs();
      },
      changePerPage (pp) {
        this.perPage = (pp == -1) ? this.listStaffs.total : pp;
        this.fetchStaffs();
      },
      async deleteStaffs(ids) {
        if (Array.isArray(ids) && ids.length == 0) {
          IziToast.warning({ message: 'Ничего не выбрано' })
          return false;
        }
        
        await axios.delete('/api/user/', { params: { ids } })

        this.fetchStaffs();

        if (Array.isArray(ids) && ids.length > 0) {
          this.unselectAll();
        } else {
          let index = this.selectStaffsID.indexOf(ids);
          if (index > -1) {
            this.selectStaffsID.splice(index, 1);
          }
        }

        IziToast.info({ message: 'Сотрудник(-и) удален(-ы)' })
      },
      unselectAll () {
        this.selectAll = false
        this.selectStaffsID = []
      }
    }
  }
</script>

<style lang="scss" scoped>
  .table {
    tr {
      td, th {
        &.select-staff {
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
  .staffs-selected-tools {
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