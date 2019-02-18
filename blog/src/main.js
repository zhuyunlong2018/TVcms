import Vue from 'vue';
import App from './App.vue';
import router from './routes.js';
import store from './store';
import axios from 'axios';
import 'babel-polyfill';
import VueSimplemde from 'vue-simplemde';

Vue.use(VueSimplemde);

Vue.prototype.$http = axios;



import './assets/styles/main.css';
import './assets/styles/normalize.css';

Vue.config.debug = true;


new Vue({
  el: '#app',
	router,
	store,
	render: h => h(App)
});


Vue.directive('highlight',function (el) {
  let blocks = el.querySelectorAll('pre code');
  blocks.forEach((block)=>{
    hljs.highlightBlock(block)
  })
})

