
import Vue from 'vue'
import Vuex from 'vuex'
import Auth from './modules/auth'
import Auth from './modules/global'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        Auth
    }
})