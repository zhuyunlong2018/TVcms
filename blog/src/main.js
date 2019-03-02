import Vue from 'vue'
import App from './App.vue'
import router from './routes.js'
import store from './store'
import 'babel-polyfill'
import VueSimplemde from 'vue-simplemde'
import './assets/styles/main.css'
import './assets/styles/normalize.css'
Vue.use(VueSimplemde)
Vue.config.debug = true
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
