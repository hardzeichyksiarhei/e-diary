<template>
  <div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Добавить пользователя</h4>
        </div>
        <div class="modal-body">
          <form @keydown="form.onKeydown($event)" @change="form.onKeydown($event)">
            <div class="form-row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group" :class="{ 'has-error': form.errors.has('first_name') }">
                    <label for="first_name">Имя <b class="text-danger">*</b></label>
                    <input class="form-control" type="text" name="first_name" placeholder="Введите имя" v-model="form.first_name">
                    <has-error :form="form" field="first_name"></has-error>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group" :class="{ 'has-error': form.errors.has('last_name') }">
                    <label for="last_name">Фамилия <b class="text-danger">*</b></label>
                    <input class="form-control" type="text" name="last_name" placeholder="Введите фамилию" v-model="form.last_name">
                    <has-error :form="form" field="last_name"></has-error>
                  </div>
                </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
                  <label for="email">E-mail <b class="text-danger">*</b></label>
                  <input class="form-control" type="email" placeholder="Введите E-mail" name="email" v-model="form.email">
                  <has-error :form="form" field="email"></has-error>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group" :class="{ 'has-error': form.errors.has('role') }">
                  <label for="role">Права доступа <b class="text-danger">*</b></label>
                  <select class="form-control" name="role"
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
            </div>
            <div class="form-row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                  <label for="password">Пароль <b class="text-danger">*</b></label>
                  <input class="form-control" type="password" name="password" placeholder="Введите пароль" v-model="form.password">
                  <has-error :form="form" field="password"></has-error>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="password_confirmation">Подтвердите пароль <b class="text-danger">*</b></label>
                  <input class="form-control" type="password" v-model="form.password_confirmation">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <router-link :to="{ name: 'admin.bulk-add' }" class="btn btn-success" data-dismiss="modal">Массовое добавление</router-link>
          <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
          <button type="button" class="btn btn-primary" @click="addUser">Добавить</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  name: 'AddUserPopup',

  data: () => ({
    form: new Form({
      first_name: '',
      last_name: '',
      email: '',
      password: '',
      password_confirmation: '',
      role: null
    })
  }),

  methods: {
    async addUser () {
      try {
        // Register the user.
        const { data } = await this.form.post('/api/user')

        IziToast.success({
           title: 'Новый пользователь добавлен',
           message: `<strong>Имя:</strong> ${this.form.first_name} ${this.form.last_name}</br>
                     <strong>E-mail:</strong> ${this.form.email}</br>`
        });
      } catch (error) {
        IziToast.error({ message: error.response.data.message });
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.modal-footer {
  display: flex;
  justify-content: space-between;
  a {
    margin-right: auto;
  }
}
</style>


