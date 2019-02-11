const getters = {

  loginUser: state => state.user.name,
  token: state => state.user.token,
  loginBox: state => state.loginBox.loginBox,
  registerLoginBtn: state => state.loginBox.registerLoginBtn,
  loginNotice: state => state.loginBox.loginNotice
}
export default getters
