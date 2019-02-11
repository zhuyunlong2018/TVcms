import Vue from 'vue'
import Vuex from 'vuex'
import state from './state'
import mutations from './mutations'
import actions from './actions'
import user from './modules/user'
import loginBox from './modules/loginBox'
import getters from './getters'

Vue.use(Vuex)

export default new Vuex.Store({
  modules:{
    user,
    loginBox
  },
  state,
  actions,
  mutations,
  getters
})
