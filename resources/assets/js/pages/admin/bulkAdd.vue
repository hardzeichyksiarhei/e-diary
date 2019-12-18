<template>
  <div class="teachers-page">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
              <h3 class="box-title">Массовое добавление</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <form @submit.prevent="save" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)">
                  <div class="form-row">
                    <div class="col-md-12">
                      <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                        <label for="reg-data">Данные для регистрации (E-mail Имя Фамилия)<b class="text-danger">*</b></label>
                        <textarea id="reg-data" rows="10" class="form-control" name="reg-data" placeholder="Введите email имя фамилию (через пробел)" v-model="form.reg_data"></textarea>
                        <has-error :form="form" field="password"></has-error>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" :class="{ 'has-error': form.errors.has('role') }">
                        <label for="role">Права доступа <b class="text-danger">*</b></label>
                        <select id="role" class="form-control" name="role"
                          :class="{ 'is-invalid': form.errors.has('role') }"
                          v-model="form.role"
                        >
                          <option value="null">Выбрать...</option>
                          <option value="admin">Администратор</option>
                          <option value="teacher">Преподаватель</option>
                          <option value="student">Студент</option>
                        </select>
                        <has-error :form="form" field="role"></has-error>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                        <label for="password">Пароль <b class="text-danger">*</b></label>
                        <input id="password" class="form-control" type="password" name="password" placeholder="Введите пароль" v-model="form.password">
                        <has-error :form="form" field="password"></has-error>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="password_confirmation">Подтвердите пароль <b class="text-danger">*</b></label>
                        <input id="password_confirmation" class="form-control" type="password" v-model="form.password_confirmation">
                      </div>
                    </div>
                  </div>
                  <v-button class="btn-sm text-uppercase" type="primary" :loading="form.busy">Сохранить</v-button>
                </form>
              </div>
              <div class="col-md-6">
                <div class="callout callout-success" v-if="users.length">
                  <h4>Добавленные пользователи</h4>

                  <ul class="callout-list">
                    <li class="callout-item" v-for="(user, key) in users" :key="key">
                      {{ user.name }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'

export default {
  middleware: ['auth', 'not-student'],

  name: 'BulkAdd',

  data: () => ({
    form: new Form({
      reg_data: '',
      password: '',
      password_confirmation: '',
      role: null
    }),
    users: []
  }),

  methods: {
    async save () {
      const regDataRow = this.form.reg_data.split('\n')

      const regData = []
      let userData = []

      regDataRow.forEach((el) => {
        userData = el.split(' ')
        regData.push({
          'email': userData[0],
          'first_name': userData[1],
          'last_name': userData[2],
          'password': this.form.password,
          'password_confirmation': this.form.password_confirmation,
          'role': this.form.role
        })
      })

      try {
        // Register the users.
        const { data } = await axios.post('/api/users', regData)
        this.users = data
      } catch (errors) {
        IziToast.error({ message: errors.response.data.message })
      }
    }
  }
}

</script>
