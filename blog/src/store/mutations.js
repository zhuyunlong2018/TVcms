import simplemde from 'simplemde'


const mutations = {

  //获取网站统计数据
  GET_WEB_DATA(state,data) {
    state.webdata = data
  },

  //点赞
  ADD_PRAISE(state,id) {
    if(id) {
      state.show_article.a_praise++;
    }
    state.webdata.praise++;
  },

  //判断是否触屏
  IF_TOUCHED(state) {
    state.if_touch = true;
  },

  //显示自动关闭提示alert
  SHOW_MESSAGE(state,data) {
    state.alert_notice.show = true;
    state.alert_notice.msg = data;
    setTimeout(() => {
      state.alert_notice.show = false;
      state.alert_notice.msg = '';
    }, 2000);
  },
 
  //显示alert弹框
  SHOW_ALERT(state,data) {
    state.alert.msg = data;
    state.alert.show = true;
  },
  //隐藏alert弹框
  CLOSE_ALERT(state) {
    state.alert.show = false;
  },
  //显示/隐藏主页导航栏
  SHOW_NAV(state,params) {
    state.showHeaderNav = params;
  },

  CLEAR_CRUMBS:function(state) {
    state.crumbs.tagName = '';
    state.crumbs.tagID = '';
    state.crumbs.title = '';
  },//添加面包屑导航文章标题和标签
  CHANGE_CRUMBS:function(state, obj) {
    console.log(obj)
      state.crumbs.tagName = obj.tagName;
      state.crumbs.tagID = obj.tagID;
    state.crumbs.title = obj.title;
    console.log(state.crumbs);
  },
  TOGGLE_SEARCH:function(state,toggle) {
    state.search.box = toggle;
  },











  get_how_long:function(state) {
    let timestamp = Date.parse(new Date());
    timestamp = timestamp/1000;
    let stringTime = '2018/01/23 09:00:00';
    let timestamp2 = Date.parse(new Date(stringTime));
    timestamp2 = timestamp2/1000;
    let how_long = timestamp - timestamp2;
    how_long = Math.floor(how_long/86400);
    state.how_long = how_long;
  },
 
  

  //显示图片放大弹框
  take_img_src(state,params) {
    state.show_img.src = params;
    state.show_img.box = true;
  },
  //隐藏图片放大弹框
  close_show_img(state) {
    state.show_img.src = '';
    state.show_img.box = false;
  },//显示图片管理窗口
  show_all_imgs(state,change) {
    state.all_images.box = true;
    state.all_images.write = change;
  },
  //隐藏图片管理窗口
  close_all_imgs(state) {
    state.all_images.box = false;
  },
  
    //显示/隐藏管理页侧边导航栏
  toggle_sidebar(state) {
      state.show_sidebar = !state.show_sidebar;
    },
  //切换评论组件在文章类评论和主页浏览板块功能
  changeCommentPage(state,p_id) {
    state.commentArticleId = p_id;
  },//将图片添加到正文里
  add_img_article:function(state,url) {
    
    state.content = state.content + '![](http://localhost:8080' + url.replace('../..','') + ')';
    //console.log(url);
  },//将图片设置为文章封面
  set_background:function(state,url) {
    state.article_background = url;
  },

 
    //获取后台所有图片地址
  GET_ALL_IMGS:function(state,data) {
    state.all_images.src = data;
  },

  //添加标签
  ADD_TAGS:function(state,tag) {
    let obj = {};
    obj.tag = tag;
    state.options.push(obj);
  },//删除标签
  DEL_TAGS:function(state,index) {
    state.options.splice(index,1);
  },//获取所有友情链接
  GET_NEIGHBORS:function(state,data) {
    state.all_neighbors = data;
  },//增加友情链接
  ADD_NEIGHBORS:function(state,data) {
    state.all_neighbors.push(data);
  },//删除友情链接
  DEL_NEIGHBORS:function(state,index) {
    state.all_neighbors.splice(index,1);
  },//获取about数据
  GET_ABOUT:function(state,data) {
    state.about_markdown = data.about_content;
    //console.log(state.about_markdown);
    state.about_html = simplemde.prototype.markdown(data.about_content);
  },//获取about数据
  UPDATE_ABOUT:function(state) {
    //console.log(state.about_markdown);
    state.about_html = simplemde.prototype.markdown(state.about_markdown);
  },
    //删除指定图片
  DEL_IMG:function(state,index) {
    //console.log(state.all_images.src[index]);
    state.all_images.src.splice(index,1);
  },//获取所有发布的文章
  
  GET_BING:function(state,data) {
    state.search.bing = data;
  },
    
    
  }
  
  export default mutations