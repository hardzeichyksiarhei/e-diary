import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user'].role == 'student') {
    next({ name: 'dashboard' })
  } else {
    next()
  }
}