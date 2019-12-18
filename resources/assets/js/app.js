import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import App from '~/components/App'

import '~/plugins'
import '~/components'

Vue.config.productionTip = false

new Vue({
  store,
  router,
  ...App
})
