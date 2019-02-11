
import { toRoutes } from '@/utils'
import { getUserRouter } from '@/api/menu'
import { constantRouterMap } from '@/router'

const permission = {
  state: {
    routers: [],
    addRouters: []
  },
  mutations: {
    SET_ROUTERS: (state, routers) => {
      state.addRouters = routers
      state.routers = constantRouterMap.concat(routers)
    }
  },
  actions: {
    GetUserRouter({ commit, state }) {
      return new Promise((resolve, reject) => {
        getUserRouter(state.token).then(response => {
          const data = response.data.data
          const userRouter = toRoutes(data)
          commit('SET_ROUTERS', userRouter)
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    }
  }
}

export default permission
