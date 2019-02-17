import { loginByUsername, logout } from '@/api/login'

import { getToken, setToken, removeToken } from '@/utils/auth'
import { getStorage, setStorage, removeStorage } from '@/utils/storage'
const user = {
  state: {
    user: getStorage('user'),
    token: getToken(),
    name: ''
  },

  mutations: {
    SET_USER: (state, user) => {
      state.user = user
    },
    SET_TOKEN: (state, token) => {
      state.token = token
    },
    SET_NAME: (state, name) => {
      state.name = name
    }
  },

  actions: {
    // 用户名登录
    LoginByUsername({ commit }, userInfo) {
      const username = userInfo.username.trim()
      return new Promise((resolve, reject) => {
        loginByUsername(username, userInfo.password).then(response => {
          const data = response.data.data
          setToken(data.token)
          setStorage('user', data.user)
          commit('SET_USER', data.user)
          commit('SET_TOKEN', data.token)
          commit('SET_NAME', data.name)
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },
    // 登出
    LogOut({ commit, state }) {
      return new Promise((resolve, reject) => {
        logout(state.token).then(() => {
          commit('SET_TOKEN', '')
          commit('SET_USER', '')
          removeToken()
          removeStorage('user')
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },

    // 前端 登出
    FedLogOut({ commit }) {
      return new Promise(resolve => {
        commit('SET_TOKEN', '')
        removeToken()
        removeStorage('user')
        resolve()
      })
    }

  }
}

export default user
