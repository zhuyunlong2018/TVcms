
const loginBox = {

  state: {
    loginBox: false, // 控制登录页面显示
    logoutBox: false, // 注销弹框
    registerLoginBtn: false,
    loginNotice: '未注册？点击进行注册'
  },
  mutations: {
    SHOW_LOGIN_BOX(state) {
      state.loginBox = true
      state.registerLoginBtn = false
      state.loginNotice = '未注册？点击进行注册'
    },
    SHOW_REGISTER_BOX(state) {
      state.loginBox = true
      state.registerLoginBtn = true
      state.loginNotice = '已有账号？点击登录'
    },
    CLOSE_LOGIN_BOX(state) {
      state.loginBox = false
    },
    CLOSE_LOGOUT_BOX(state) {
      state.logoutBox = false
    },
    SHOW_LOGOUT_BOX(state) {
      state.logoutBox = true
    }
  },
  actions: {}
}

export default loginBox
