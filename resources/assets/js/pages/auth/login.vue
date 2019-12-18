<template>
    <div class="login-page">
        <div class="login-box">
            <div class="login-logo">
                <router-link :to="{ name: 'welcome' }" v-html="$options.filters.boldFirstWord(appName)"></router-link>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Войдите, чтобы начать сеанс</p>

                <form @submit.prevent="login" @keydown="form.onKeydown($event)">
                    <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
                        <label for="email">E-mail</label>
                        <input class="form-control" id="email" type="email" aria-describedby="emailHelp" placeholder="Введите E-mail" name="email"
                            v-model="form.email"
                        >
                        <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                        <label for="password">Пароль</label>
                        <input class="form-control" id="password" type="password" placeholder="Пароль" name="password"
                            v-model="form.password"
                        >
                        <has-error :form="form" field="password"></has-error>
                    </div>
                    <div class="form-group">
                        <checkbox v-model="remember" name="remember">
                            Запомнить меня
                        </checkbox>
                    </div>
                    <!-- <a class="btn btn-primary btn-block" href="index.html">Login</a> -->
                    <div class="form group">
                        <v-button class="btn-block" :loading="form.busy">Войти</v-button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <router-link :to="{ name: 'register' }">Регистрация</router-link><br/>
                    <router-link :to="{ name: 'password.request' }">Забыли пароль?</router-link>
                </div>

            </div>
            <!-- /.login-box-body -->
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
          return { title: 'Вход' }
      },

      data: () => ({
        appName: window.config.appName,
        form: new Form({
          email: process.env.NODE_ENV === 'development' ? 'hardzeichyksiarhei@gmail.com' : '',
          password: process.env.NODE_ENV === 'development' ? '123456' : '',
        }),
        remember: false
      }),

      filters: {
        boldFirstWord (value) {
          let words = value.split(' ');
          words[0] = `<b>${words[0]}</b>`;
          
          return words.join(' '); 
        }
      },

      methods: {
        async login() {
          // Submit the form.
          const {data} = await this.form.post('/api/login')

          // Save the token.
          this.$store.dispatch('auth/saveToken', {
              token: data.token,
              remember: this.remember
          })

          // Fetch the user.
          await this.$store.dispatch('auth/fetchUser')

          // Redirect home.
          this.$router.push('dashboard')
        }
      }
    }
</script>
