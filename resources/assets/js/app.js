import { env } from './env'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./api/pi-bootstrap.js')
import Vue from 'vue'
import Vuex from 'vuex'
import store from './store'
import VueRouter from 'vue-router'
import App from './components/App.vue'
import Login from './components/auth/Login.vue'
import Register from './components/auth/Register.vue'
import Settings from './components/pages/Settings.vue'
import Dashboard from './components/pages/Dashboard.vue'

Vue.use(Vuex)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/admin',
            name: 'home',
            component: Dashboard,
            secure: true
        },
        {
            path: '/settings',
            name: 'settings',
            component: Settings,
            secure: true
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
    ]
});

// router.beforeEach((to, from, next) => {
//         // Look at all routes
//         router.options.routes.forEach((route) => {
//             // If this is the current route and it's secure
//             if (to.matched[0].path === route.path && route.secure) {
//                 // Verify that the user isn't logged in
//                 let config = {
//                     headers: {
//                         'Authorization': "Bearer " + router.app.$store.state.token,
//                         'Accept': 'application/json'
//                     }
//                 }
//
//                 let url = `${env.url}/${env.api}/auth/check`
//                 let data = {
//                     getUser: typeof store.state.Auth.user !== 'undefined'
//                     && store.state.Auth.user.email === ''
//                 }
//
//                 window.axios.post(url, data, config)
//                     .then((response) => {
//                         console.log(response.data.user)
//                         if (response.data.message === '') {
//                             router.app.$store.dispatch('setToken', response.data.access_token)
//                             if (response.data.user.name !== ''){
//                                 router.app.$store.dispatch('setUser', response.data.user)
//                             }
//                             next()
//                         }
//                     })
//                     .catch( ({response}) => {
//                         console.log(response)
//                         next('login')
//                     })
//             }
//         })
//
//         next()
// });


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
new Vue({
    el: '#app',
    store,
    router: router,
    render: app => app(App)
});
