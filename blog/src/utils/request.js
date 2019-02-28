import axios from 'axios'
import store from '../store'
import { getToken } from '@/utils/auth'
import router from '../routes';


// 创建axios实例
const service = axios.create({
  //baseURL: process.env.BASE_API, // api 的 base_url
  baseURL: "http://zhuzu.top/tvcms/public/index.php", // api 的 base_url
  timeout: 5000 // 请求超时时间
})

// request拦截器
service.interceptors.request.use(
  config => {
    if (store.getters.token) {
      config.headers['X-Api-Token'] = getToken() // 让每个请求携带自定义token 请根据实际情况自行修改
    }
    store.state.show_loading = true
    return config
  },
  error => {
    // Do something with request error
    console.log(error) // for debug
    Promise.reject(error)
  }
)

// response 拦截器
service.interceptors.response.use(
  response => {
    store.state.show_loading = false
    return response
  },
  error => {
    // console.log('err' + error) // for debug
    if(typeof error.response.data.msg == 'undefined') {
      store.commit('SHOW_ALERT','未知错误')
    } else {
      store.commit('SHOW_ALERT',error.response.data.msg)
    }
    if(error.response.data.error_code === 10001) {
      store.dispatch('logOut')
      router.push('/')
    }
    store.state.show_loading = false
    return Promise.reject(error)
  }
)

export default service
