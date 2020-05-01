<template>
  <div class="login-page">
    <div class="login-box">
      <div class="login-logo">
          <a href="/" v-html="$options.filters.boldFirstWord(appName)"/>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        <h4 class="text-center">Забыли пароль?</h4>
        <p class="login-box-msg text-center">
          Введите свой адрес электронной почты, и мы отправим вам инструкции о том, как сбросить пароль.
        </p>

        <form @submit.prevent="send" @keydown="form.onKeydown($event)">
          <div class="form-group">
            <input class="form-control" type="email" placeholder="Введите E-mail"
              v-model="form.email"
              :class="{ 'is-invalid': form.errors.has('email') }"
            >
            <has-error :form="form" field="email"/>
          </div>
          <div class="form-group">
            <v-button class="btn btn-primary btn-block" :loading="form.busy">Отправить ссылку на сброс пароля</v-button>
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
import Form from "vform";

export default {
  middleware: "guest",

  layout: "basic",

  metaInfo() {
    return { title: 'Сброс пароля' };
  },

  data: () => ({
    appName: window.config.appName,
    form: new Form({
      email: ""
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
    async send() {
      try {
        const { data } = await this.form.post("/api/password/email");
        IziToast.info({ message: data.status })
      } catch (error) { console.error(error) }
      this.form.reset();
    }
  }
};
</script>
