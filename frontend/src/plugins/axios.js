import Vue from 'vue'
import axios from 'axios'

axios.defaults.baseURL = 'http://localhost:8000/'
axios.defaults.withCredentials = true

Vue.use({
    install(Vue) {
        Vue.prototype.$http = axios
    }
})