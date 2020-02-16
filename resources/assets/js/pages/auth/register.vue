<template>
    <div class="register-page">
        <div class="register-box">
            <div class="register-logo">
              <router-link :to="{ name: 'welcome' }" v-html="$options.filters.boldFirstWord(appName)"></router-link>
            </div>
            <div class="register-box-body">
              <p class="login-box-msg">
                <strong>Зарегистрироваться в качестве студента.</strong>
                Регистрация в качестве преподавателя производится администратором.
              </p>
              <form @submit.prevent="register" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)">
                <div class="form-row">
                  <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group" :class="{ 'has-error': form.errors.has('first_name') }">
                      <label for="first_name">Имя <b class="text-danger">*</b></label>
                      <input class="form-control" id="first_name" type="text" name="first_name" placeholder="Введите имя" v-model="form.first_name">
                      <has-error :form="form" field="first_name"></has-error>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group" :class="{ 'has-error': form.errors.has('last_name') }">
                      <label for="last_name">Фамилия <b class="text-danger">*</b></label>
                      <input class="form-control" id="last_name" type="text" name="last_name" placeholder="Введите фамилию" v-model="form.last_name">
                      <has-error :form="form" field="last_name"></has-error>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6">
                    <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
                      <label for="email">E-mail <b class="text-danger">*</b></label>
                      <input class="form-control" id="email" type="email" placeholder="Введите E-mail" name="email" v-model="form.email">
                      <has-error :form="form" field="email"></has-error>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" :class="{ 'has-error': form.errors.has('patronymic_name') }">
                      <label for="patronymic_name">Отчество</label>
                      <input class="form-control" id="patronymic_name" type="patronymic_name" placeholder="Введите отчество" name="patronymic_name" v-model="form.patronymic_name">
                      <has-error :form="form" field="patronymic_name"></has-error>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                      <label for="password">Пароль <b class="text-danger">*</b></label>
                      <input class="form-control" id="password" type="password" name="password" placeholder="Введите пароль" v-model="form.password">
                      <has-error :form="form" field="password"></has-error>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <label for="password_confirmation">Подтвердите пароль <b class="text-danger">*</b></label>
                      <input class="form-control" id="password_confirmation" type="password" v-model="form.password_confirmation">
                    </div>
                  </div>
                </div>
                <p><b class="text-danger">*</b> – поля обязательные для заполнения.</p>
                <div class="form-group">
                  <v-button class="btn btn-primary btn-block" :loading="form.busy">Регистрация</v-button>
                </div>
              </form>
              <div class="text-center mt-3">
                <router-link :to="{ name: 'login' }">Войти</router-link><br/>
                <router-link :to="{ name: 'password.request' }">Забыли пароль?</router-link>
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

      components: {},

      metaInfo() {
          return { title: 'Регистрация' }
      },

      data: () => ({
          appName: window.config.appName,
          form: new Form({
              first_name: '',
              last_name: '',
              patronymic_name: '',
              email: '',
              password: '',
              password_confirmation: '',
              role: 'student'
          })
      }),

      filters: {
          boldFirstWord (value) {
              let words = value.split(' ');
              words[0] = `<b>${words[0]}</b>`;
              
              return words.join(' '); 
          }
      },

      methods: {
          async register() {
              try {
                // Register the user.
                const { data } = await this.form.post('/api/register')

                console.log(data)

                // Log in the user.
                const {data: {token}} = await this.form.post('/api/login')

                // Save the token.
                this.$store.dispatch('auth/saveToken', {token})

                // Update the user.
                await this.$store.dispatch('auth/updateUser', data )

                // Redirect home.
                this.$router.push('dashboard')
              } catch (error) {
                IziToast.error({ message: error.response.data.message });
              }
          }
      }
  }
</script>
