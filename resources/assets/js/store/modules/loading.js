import axios from 'axios'
import * as types from '../mutation-types'

export const state = {
  loading: false
}

export const getters = {
  loading: state => state.loading
}

export const mutations = {
  [types.CHANGE_LOADING] (state) {
    state.loading = !state.loading
  }
}

export const actions = {
  changeLoading ({ commit }) {
    commit(types.CHANGE_LOADING)
  }
}
