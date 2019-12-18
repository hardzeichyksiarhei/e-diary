import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user'].role !== 'teacher') {
    next({ name: 'dashboard' })
  } else {
    next()
  }
}