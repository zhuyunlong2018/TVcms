import { login} from '@/api/login'
import { getToken, setToken, removeToken } from '@/utils/auth'
import { getStorage, setStorage, removeStorage } from '@/utils/storage'


const user = {
    state: {
        name: getStorage('name')?('欢迎您!'+ getStorage('name')) : '登录',//登录与后台用户名标识
        token: getToken(),
    },
    mutations: {
        SET_TOKEN: (state, token) => {
            state.token = token
        },
        SET_NAME: (state, name) => {
            state.name = name
        },
    },
    actions: {
        // 登录
        login({ commit },userInfo) {
            return new Promise((resolve, reject) => {
                login(userInfo.email, userInfo.password).then(response => {
                    const data = response.data
                    setToken(data.token)
                    setStorage('name',data.name)
                    commit('SET_TOKEN', data.token)
                    commit('SET_NAME', data.name)
                    commit('SHOW_MESSAGE','登录成功');
                    resolve(response)
                }).catch(error => {
                    // commit('SHOW_ALERT',error.response.data.msg);
                    reject(error)
                })
            })
        },
        // 前端 登出
        FedLogOut({ commit }) {
            return new Promise(resolve => {
                commit('SET_TOKEN', '')
                commit('SET_NAME','登录')
                removeStorage('name')
                removeToken()
                resolve()
            })
        }

    }

}

export default user