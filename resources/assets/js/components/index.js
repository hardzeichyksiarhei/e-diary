/* eslint-disable no-undef */
import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import Checkbox from './Checkbox'
import { HasError, AlertError, AlertSuccess } from 'vform'
import Select2 from './Select2'

// Components that are registered globaly.
[
  Card,
  Child,
  Button,
  Checkbox,
  HasError,
  AlertError,
  AlertSuccess,
  Select2
].forEach(Component => {
  Vue.component(Component.name, Component)
})

import VueBreadcrumbs from 'vue-breadcrumbs'
Vue.use(VueBreadcrumbs)

import VuePaginate from 'vue-paginate'
Vue.use(VuePaginate)

Vue.component('pagination', require('laravel-vue-pagination'));
