<template>
  <div class="teachers-page">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Массовое добавление</h3>
          </div>
          <div class="box-body">
            <form
              @submit.prevent="save"
              @keydown="form.onKeydown($event)"
              @change="form.onKeydown($event)"
            >
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="reg-data">
                      Данные для регистрации (E-mail Фамилия Имя Отчетсво)
                      <b class="text-danger">*</b>
                    </label>
                    <textarea
                      id="reg-data"
                      rows="10"
                      class="form-control"
                      name="reg-data"
                      placeholder="Введите email фамилию имя отчетсво (через пробел)"
                      v-model="reg_data"
                    ></textarea>
                  </div>
                  <div class="form-group" :class="{ 'has-error': form.errors.has('role') }">
                    <label for="role">
                      Права доступа
                      <b class="text-danger">*</b>
                    </label>
                    <select
                      id="role"
                      class="form-control"
                      name="role"
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
                  <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                    <label for="password">
                      Пароль
                      <b class="text-danger">*</b>
                    </label>
                    <input
                      id="password"
                      class="form-control"
                      type="password"
                      name="password"
                      placeholder="Введите пароль"
                      v-model="form.password"
                    />
                    <has-error :form="form" field="password"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="password_confirmation">
                      Подтвердите пароль
                      <b class="text-danger">*</b>
                    </label>
                    <input
                      id="password_confirmation"
                      class="form-control"
                      type="password"
                      v-model="form.password_confirmation"
                    />
                  </div>
                  <div class="form-group">
                    <v-button
                      class="btn-sm text-uppercase"
                      type="primary"
                      :loading="form.busy"
                      :disabled="!reg_data"
                    >Сохранить</v-button>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="callout callout-success" v-if="is_added_users">
                    <h4>Добавленные пользователи</h4>

                    <ul class="callout-list">
                      <li
                        class="callout-item"
                        v-for="(user, key) in usersValid"
                        :key="key"
                      >{{ user.name }}</li>
                    </ul>
                  </div>


                  <div class="callout callout-danger" v-if="usersNotValid.length">
                    <h4>Ошибки</h4>

                    <ul class="callout-list">
                      <li
                        class="callout-item"
                        v-for="user in usersNotValid"
                        :key="user.position"
                      >
                        <p>Ошибки в <b>#{{ user.position }}</b> строке</p>
                        <template v-for="field in user.errors">
                          <p v-for="(error, key) in field" :key="key">- {{ error }}</p>
                        </template>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";
import axios from "axios";

export default {
  middleware: ["auth", "not-student"],

  name: "BulkAdd",

  metaInfo () {
    return { title: 'Массовое добавление' }
  },

  data: () => ({
    reg_data: "",
    form: new Form({
      users: [],
      password: "",
      password_confirmation: "",
      role: null
    }),
    usersValid: [],
    usersNotValid: [],
    credentialsErrors: {}
  }),

  computed: {
    is_added_users () {
      return !Object.keys(this.credentialsErrors).length && this.usersValid.length
    }
  },

  methods: {
    async save() {
      if (!this.reg_data) return;

      this.form.users = [];

      const regDataRow = this.reg_data.split("\n");

      const regData = [];
      let userData = [];

      regDataRow.forEach(el => {
        userData = el.split(" ");
        this.form.users.push({
          first_name: userData[2] || "",
          last_name: userData[1] || "",
          patronymic_name: userData[3] || "",
          email: userData[0],
        });
      });

      try {
        // Register the users.
        const { data } = await this.form.post("/api/user/bulk");
        if (data) {
          this.usersValid = data.usersValid;
          this.usersNotValid = data.usersNotValid;
          this.credentialsErrors = data.credentialsErrors || {};
          this.form.errors.errors = this.credentialsErrors;
        }
      } catch (errors) {
        console.log(errors);
        //IziToast.error({ message: errors.response.data.message });
      }
    }
  }
};
</script>

<style lang="scss">
  .callout p:last-child {
    margin-bottom: 10px;
  }
</style>