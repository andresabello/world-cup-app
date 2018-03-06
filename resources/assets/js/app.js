/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap')
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

router.beforeEach((to, from, next) => {
    // Look at all routes
    router.options.routes.forEach((route) => {
        // If this is the current route and it's secure
        if (to.matched[0].path === route.path && route.secure) {
            // Verify that the user isn't logged in
            axios.post('auth/loggedIn').catch((response) => {
                // Kill the session
                // router.app.$session.destroy();
                // Route back to the landing
                return next('/login');
            });
        }
    });
    // Proceed as normal
    next();
});


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
