import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import App from '~/components/App'

import VueYandexMetrika from 'vue-yandex-metrika'

import '~/plugins'
import '~/components'

Vue.config.productionTip = false;

Vue.use(VueYandexMetrika, {
  id: 62287963,
  router: router,
  env: process.env.NODE_ENV
});

new Vue({
  store,
  router,
  ...App
});
