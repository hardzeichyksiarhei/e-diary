<template>
  <div class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/" v-html="$options.filters.boldFirstWord(appName)"/>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        <form @submit.prevent="reset" @keydown="form.onKeydown($event)">
          <alert-success :form="form" :message="status"/>

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">E-mail</label>
            <div class="col-md-9">
              <input v-model="form.email" type="email" name="email" class="form-control"
                     :class="{ 'is-invalid': form.errors.has('email') }" readonly>
              <has-error :form="form" field="email"/>
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Пароль</label>
            <div class="col-md-9">
              <input v-model="form.password" type="password" name="password" class="form-control"
                     :class="{ 'is-invalid': form.errors.has('password') }">
              <has-error :form="form" field="password"/>
            </div>
          </div>

          <!-- Password Confirmation -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Подтвердите пароль</label>
            <div class="col-md-9">
              <input v-model="form.password_confirmation" type="password" name="password_confirmation" class="form-control"
                     :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
              <has-error :form="form" field="password_confirmation"/>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group row">
            <div class="col-md-12">
              <v-button class="btn-block" :loading="form.busy">Сброс пароля</v-button>
            </div>
          </div>
        </form>
        <div class="text-center mt-3">
          <router-link :to="{ name: 'register' }">Регистрация</router-link><br/>
          <router-link :to="{ name: 'login' }">Войти</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  middleware: 'guest',

  layout: 'basic',

  metaInfo () {
    return { title: 'Сброс пароля' }
  },

  data: () => ({
    appName: window.config.appName,
    status: '',
    form: new Form({
      token: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  filters: {
    boldFirstWord (value) {
      let words = value.split(' ');
      words[0] = `<b>${words[0]}</b>`;

      return words.join(' ');
    }
  },

  created () {
    this.form.email = this.$route.query.email
    this.form.token = this.$route.params.token
  },

  methods: {
    async reset () {
      const { data } = await this.form.post('/api/password/reset')

      this.status = data.status

      this.form.reset()
    }
  }
}
</script>
