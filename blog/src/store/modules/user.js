import { login } from '@/api/login'
import { getToken, setToken, removeToken } from '@/utils/auth'
import { getStorage, setStorage, removeStorage } from '@/utils/storage'

const user = {
  state: {
    user: getStorage('user') ? (getStorage('user')) : { user_name: '登录' }, // 登录与后台用户名标识
    token: getToken()
  },
  mutations: {
    SET_TOKEN: (state, token) => {
      state.token = token
    },
    SET_USER: (state, user) => {
      state.user = user
    }
  },
  actions: {
    // 登录
    login({ commit }, userInfo) {
      return new Promise((resolve, reject) => {
        login(userInfo).then(response => {
          const data = response.data.data
          setToken(data.token)
          setStorage('user', data.user)
          commit('SET_TOKEN', data.token)
          commit('SET_USER', data.user)
          commit('SHOW_MESSAGE', '登录成功')
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
    // 登出
    logOut({ commit }) {
      return new Promise(resolve => {
        commit('SET_TOKEN', '')
        commit('SET_USER', { user_name: '登录' })
        removeStorage('user')
        removeToken()
        resolve()
      })
    }
  }

}

export default user
