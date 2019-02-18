import simplemde from 'simplemde'
const common = require('./common');


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
  //更新当前时间
  get_now_time:function(state) {
    state.now_time = common.getTime();
    //console.log(state.now_time);
  },

    //判断是否触屏
  IF_TOUCHED(state) {
    state.if_touch = true;
  },
 
  //显示注销盒子
  show_logout(state) {
    state.logout_box = !state.logout_box;
  },
  //关闭注销盒子
  close_logout(state) {
    state.logout_box = false;
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
  //显示/隐藏主页导航栏
  SHOW_NAV(state,params) {
    state.showHeaderNav = params;
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
  
 //设置about页面v-model绑定
  updateabout (state, about_markdown) {
      state.about_markdown = about_markdown;
    },
  //设置userEmail和登录页面的v-model绑定
  updateuserEmail (state, userEmail) {
    state.userEmail = userEmail
  },
  //设置userEmail和登录页面的v-model绑定
  updateuserName (state, userName) {
    state.userName = userName
  },
  //设置userPwd和登录页面的v-model绑定
  updateuserPwd (state, userPwd) {
    state.userPwd = userPwd
  },
  //设置title和文章编辑页的v-model绑定
  updatetitle (state, title) {
    state.title = title
  },
  //设置content和文章编辑页的v-model绑定
  updatecontent (state, content) {
    state.content = content
  },
  //设置tag和文章编辑页的v-model绑定
  select_tag (state, tag) {
    state.tag= tag
  },
  //设置commenter和文章评论的v-model绑定
  updatecommenter (state, commenter) {
    state.commenter= commenter
  },
  //设置commenterEmail和文章评论的v-model绑定
  updatecommenterEmail (state, commenterEmail) {
    state.commenterEmail= commenterEmail
  },
  //设置commentText和文章评论的v-model绑定
  updatecommentText (state, commentText) {
    state.commentText= commentText
  },

  //将删除的文章数据移除items列表
  DELARTICLE(state,index) {
    //console.log(index);
    state.items.splice(index,1);
  },
  //读取要编辑文章的内容
  GETONEARTICLE(state,data) {
    // console.log(data.data[0]);
    let result=data;
    let _content = result.a_content;
    state.title=result.a_title;
    state.content= _content;
    state.tag=result.a_tag;
    state.id=result.a_id;
    state.time=result.a_time;
    state.article_background=result.a_img;
    state.c_button=false;//切换按钮为更新状态
  },
  //点击更新编辑文章内容后，初始化页面数据
  UPDATEARTICLE(state) {
    state.title='';
    state.content='';
    state.article_background='';
    state.tag='生活随笔';
    state.c_button=true;//切换按钮为发送状态
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
 
    //清空文章评论列表
    CLEARCOMMENT(state) {
      state.comment = [];
    },
 
 
    //获取后台所有图片地址
  GET_ALL_IMGS:function(state,data) {
    state.all_images.src = data;
  },
  //发布或下架选中文章
  PUBLISH:function(state,data) {
    state.items[data.index].published = data.publish;
  },


    //获取所有的评论
    GET_ALL_COMMENT:function(state,data) {
      let articleId = [];
      for(let i=0;i<data.length;i++) {
          articleId[i] = data[i].c_article_id;
          data[i].c_content = data[i].c_content;
      }
      //console.log(articleId);
      for(let j=0;j<articleId.length;j++) {
        if(articleId.indexOf(articleId[j])!=j) {
          articleId.splice(j,1);
          j--;
        }
      }
      //console.log(articleId);
      articleId.sort(function(x,y) {
        return y-x;
      });
      //console.log(articleId);
      let comment = [];
      for(let k=0;k<articleId.length;k++) {
        let obj = {};
        obj.index = articleId[k];
        
        obj.content = [];
        for(let l=0;l<data.length;l++) {
          if(data[l].c_article_id == articleId[k]) {
            obj.content.push(data[l]);
            obj.title = data[l].a_title;
          }
        }
        comment.push(obj);

      }
      state.all_comment = comment;
      // console.log(comment);
    },
        //屏蔽或解封评论
    CLOSE_COMMENT:function(state,data) {
      //console.log(state.all_comment[data.index].content[data._index].published);
      state.all_comment[data.index].content[data._index].published = data.publish;
    },//获取所有用户列表
    SHOW_ALL_USER:function(state,data) {
      state.all_user = data;
    },//获取所有标签列表
    GET_TAGS:function(state,data) {
      state.options = data;
    },//添加标签
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
    TOGGLE_SEARCH:function(state,toggle) {
      state.search.box = toggle;
    },
    
  }
  
  export default mutations