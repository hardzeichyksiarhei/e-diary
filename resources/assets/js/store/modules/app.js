import * as types from '../mutation-types'

export const state = {
    leftMenu: {
        instance: null,
        is_open: false
    },
    rightSenu: {
        instance: null,
        is_open: false
    }
}

export const getters = {
    leftMenuInstance: state => state.leftMenu.instance
}

export const mutations = {
    LEFT_MENU_OPEN(state) {
        state.leftMenu.is_open = true
    },
    LEFT_MENU_CLOSE(state) {
        state.leftMenu.is_open = false
    },
    SET_LEFT_MENU_INSTANCE(state, payload) {
        state.leftMenu.instance = payload
    },
    CLEAR_LEFT_MENU(state) {
        state.leftMenu = {
            instance: null,
            is_open: false
        }
    }
}

export const actions = {}
