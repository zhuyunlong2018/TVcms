import simplemde from 'simplemde'

const mutations = {

  // 获取网站统计数据
  GET_WEB_DATA(state, data) {
    state.webdata = data
  },

  // 点赞
  ADD_PRAISE(state, id) {
    if (id) {
      state.show_article.a_praise++
    }
    state.webdata.praise++
  },

  // 判断是否触屏
  IF_TOUCHED(state) {
    state.if_touch = true
  },

  // 显示自动关闭提示alert
  SHOW_MESSAGE(state, data) {
    state.alert_notice.show = true
    state.alert_notice.msg = data
    setTimeout(() => {
      state.alert_notice.show = false
      state.alert_notice.msg = ''
    }, 2000)
  },

  // 显示alert弹框
  SHOW_ALERT(state, data) {
    state.alert.msg = data
    state.alert.show = true
  },
  // 隐藏alert弹框
  CLOSE_ALERT(state) {
    state.alert.show = false
  },
  // 显示/隐藏主页导航栏
  SHOW_NAV(state, params) {
    state.showHeaderNav = params
  },

  CLEAR_CRUMBS: function(state) {
    state.crumbs.tagName = ''
    state.crumbs.tagID = ''
    state.crumbs.title = ''
  }, // 添加面包屑导航文章标题和标签
  CHANGE_CRUMBS: function(state, obj) {
    console.log(obj)
    state.crumbs.tagName = obj.tagName
    state.crumbs.tagID = obj.tagID
    state.crumbs.title = obj.title
    console.log(state.crumbs)
  },
  TOGGLE_SEARCH: function(state, toggle) {
    state.search.box = toggle
  },
  // 显示/隐藏管理页侧边导航栏
  TOOGLE_SIDEBAR(state) {
    state.show_sidebar = !state.show_sidebar
  },
  GET_HOW_LONG: function(state) {
    let timestamp = Date.parse(new Date())
    timestamp = timestamp / 1000
    const stringTime = '2018/01/23 09:00:00'
    let timestamp2 = Date.parse(new Date(stringTime))
    timestamp2 = timestamp2 / 1000
    let how_long = timestamp - timestamp2
    how_long = Math.floor(how_long / 86400)
    state.how_long = how_long
  },
  // 显示图片放大弹框
  TAKE_IMG_SRC(state, params) {
    state.show_img.src = params
    state.show_img.box = true
  },
  // 隐藏图片放大弹框
  CLOSE_SHOW_IMG(state) {
    state.show_img.src = ''
    state.show_img.box = false
  },
  GET_BING: function(state, data) {
    state.search.bing = data
  },
  // 隐藏图片管理窗口
  close_all_imgs(state) {
    state.all_images.box = false
  },

  // 获取about数据
  GET_ABOUT: function(state, data) {
    state.about_markdown = data.about_content
    // console.log(state.about_markdown);
    state.about_html = simplemde.prototype.markdown(data.about_content)
  }, // 获取about数据
  UPDATE_ABOUT: function(state) {
    // console.log(state.about_markdown);
    state.about_html = simplemde.prototype.markdown(state.about_markdown)
  }

}

export default mutations
