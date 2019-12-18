import axios from 'axios'
import * as types from '../mutation-types'

export const state = {
  notifications: []
}

export const getters = {
  notifications: state => state.notifications.msg,
  totalNotifications: state => state.notifications.total
}

export const mutations = {
  [types.FETCH_NOTIFICATIONS] (state, notifications) {
    state.notifications = notifications
  }
}

export const actions = {
  async fetchNotifications ({ commit }) {
    const { data } = await axios.get('/api/messages/notifications')
    commit(types.FETCH_NOTIFICATIONS, data)
  }
}
