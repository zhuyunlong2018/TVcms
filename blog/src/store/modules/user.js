import { login} from '@/api/login'
import { getToken, setToken, removeToken } from '@/utils/auth'

const user = {
state: {
    name: '',
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
    login({ commit }, useremail,password) {
        console.log(useremail)
        console.log(password)
        return new Promise((resolve, reject) => {
            login(useremail, password).then(response => {
            
            
            setToken(response.token)
            commit('SET_TOKEN', response.token)
            commit('SET_NAME', response.name)
           
            resolve()
            }).catch(error => {
                console.log(error)
            reject(error)
            })
        })
    },

}

}

export default user