import Vue from 'vue';
import App from './App.vue';
import router from './routes.js';
import store from './vuex/store.js';
import axios from 'axios';
import 'babel-polyfill';
import VueSimplemde from 'vue-simplemde';

Vue.use(VueSimplemde);
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
//超时时间
axios.defaults.timeout = 5000;
axios.defaults.withCredentials=false;
//http request 拦截器
axios.interceptors.request.use(
  config => {
    if (store.state.token) {  // 判断是否存在token，如果存在的话，则每个http header都加上token
      config.headers.common['X-token'] = store.state.token;
      //console.log(config.headers);
    } else {
      config.headers.common['X-token'] = '';
    }
    store.state.show_loading = true;
    return config;
  },
  err => {
    return Promise.reject(err);
  });
// http response 拦截器
axios.interceptors.response.use(
  response => {
    store.state.show_loading = false;
    return response;
  },
  error => {
    if (error.response) {
      switch (error.response.status) {
        case 401:
          // 返回 401 清除token信息并跳转到登录页面
          store.commit("change");
          router.replace({
            path: '/',
            query: {redirect: router.currentRoute.fullPath}
          })
      }
    }
    store.state.show_loading = false;
    return Promise.reject(error.response.data)   // 返回接口返回的错误信息
  });



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

