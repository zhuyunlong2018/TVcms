const getters = {
  user: state => state.user.user,
  token: state => state.user.token,
  loginBox: state => state.loginBox.loginBox,
  registerLoginBtn: state => state.loginBox.registerLoginBtn,
  loginNotice: state => state.loginBox.loginNotice,
  logoutBox: state => state.loginBox.logoutBox
}
export default getters
