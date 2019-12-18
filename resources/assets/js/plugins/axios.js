/* eslint-disable no-undef,space-in-parens */
import axios from 'axios'
import store from '~/store'
import router from '~/router'

// Request interceptor
axios.interceptors.request.use(request => {
  const token = store.getters['auth/token']
  if (token) {
    request.headers.common['Authorization'] = `Bearer ${token}`
  }

  // request.headers['X-Socket-Id'] = Echo.socketId()

  return request
})

// Response interceptor
axios.interceptors.response.use(response => response, error => {
  const { status } = error.response

  if (status >= 500) {
    IziToast.error({
      title: 'Oops...',
      message: 'Что-то пошло не так! Пожалуйста, попробуйте еще раз.',
      overlay: true,
      position: 'center'
    })
  }

  if (status === 401 && store.getters['auth/check']) {
    IziToast.warning({
      id: '401',
      title: 'Сессия завершена!',
      message: 'Повторите попытку, чтобы продолжить.'
    })
    document.addEventListener('iziToast-close', async (data) => {
      if (data.settings.class === '401') {
        await store.dispatch('auth/logout')

        router.push({ name: 'login' })
      }
    })
  }

  return Promise.reject(error)
})
