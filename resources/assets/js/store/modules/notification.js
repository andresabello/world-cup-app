import notification from './../../api/classes/pi-notify'

// initial state
const state = {
    notification: notification,
    element: document,
    message: '',
    type: 'success',
    primary: true,
    time: 3000
}

const getters = {
    notification: state => state.notification,
    element: state => state.element,
    message: state => state.message,
    type: state => state.type,
    primary: state => state.primary,
    time: state => state.time
}

// actions
const actions = {
     notify ({ commit }, message) {
         commit('setMessage', message)
         commit('trigger')
    },
    set ({ commit }, element) {
         switch (element.key) {
             case 'element' :
                 commit('setElement', element.value)
                 break
             case 'type' :
                 commit('setType', element.value)
                 break
             case 'time' :
                 commit('setTime', element.value)
                 break
             case 'primary' :
                 commit('togglePrimary')
                 break
         }
    }

}

// mutations
const mutations = {
    trigger (state) {
        state.notification.set(state.element, state.message, state.type, state.primary, state.time)
    },
    setElement (state, element) {
        state.element = element
    },
    setMessage (state, message) {
        state.message = message
    },
    seType(state, type) {
        state.type = type
    },
    seTime(state, time) {
        state.time = time
    },
    togglePrimary(state) {
        state.primary = !state.primary
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}