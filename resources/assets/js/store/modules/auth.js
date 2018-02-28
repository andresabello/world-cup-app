import auth from './../../api/classes/pi-auth'
import {env} from './../../env'

// initial state
const state = {
    loggedIn: false,
    registerAction: `${env.url}/${env.api}/register`,
    loginAction: `${env.url}/${env.api}/login`,
    registerForm: {
        name: {
            'message': 'Name',
            'type': 'text'
        },
        email: {
            'message': 'Email',
            'type': 'email'
        },
        password: {
            'message': 'Password',
            'type': 'password'
        },
        password_confirmation: {
            'message': 'Confirm Password',
            'type': 'password'
        },
        submit: {
            'message': 'Register',
            'type': 'submit'
        }
    },
    loginForm: {
        email: {
            'message': 'Email',
            'type': 'email'
        },
        password: {
            'message': 'Password',
            'type': 'password'
        },
        submit: {
            'message': 'Login',
            'type': 'submit'
        }
    }
}

// getters
const getters = {
    loggedIn: state => state.loggedIn,
    registerForm: state => state.registerForm,
    loginForm: state => state.loginForm,
    registerAction: state => state.registerAction,
    loginAction: state => state.loginAction,
}

// actions
const actions = {
    setLoggedIn ({ commit }) {
        auth.loggedIn(loggedIn => {
            commit('setLoggedIn', loggedIn)
        })
    }
}

// mutations
const mutations = {
    setLoggedIn (state, loggedIn) {
        state.loggedIn = loggedIn
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}