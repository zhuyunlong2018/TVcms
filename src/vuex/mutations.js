import simplemde from 'simplemde'
import router from '../routes.js'
const common = require('./common');


const mutations = {
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
  //改变登录页面显示状态
  change(state){
      state.loginbox=!state.loginbox;
  },
  //注册框切换为登录框
  show_login_box(state) {
    state.change_notice = "未注册？点击进行注册";
    state.register_login_btn = false;
  },
    //判断是否触屏
  if_touched(state) {
    state.if_touch = true;
  },
  //登录框切换为注册框
  show_register_box(state) {
      state.change_notice = "已有账号？点击登录";
      state.register_login_btn = true;
    },
  //登录成功，同步token到store中
  token(state,data) {
    state.token = data.jwt;
    state.userPwd = '';
    state.commenter = data.name;
    state.status = data.userstatus;
    state.commenterEmail = data.email;
    state.login_user = '欢迎您！'+ data.name;
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
    show_alert_notice(state,data) {
      state.alert_notice.show = true;
      state.alert_notice.msg = data;
      setTimeout(() => {
        state.alert_notice.show = false;
        state.alert_notice.msg = '';
      }, 1000);
    },
  //注销登录
  logout(state) {
    state.token = null;
    state.login_user = '登录';
    state.userName = '';
    state.userEmail = '';
    state.status = '';
    state.commenter = '';
    state.commenterEmail = '';
    localStorage.removeItem("bianquan_user");
    localStorage.removeItem("bianquan_token");
    localStorage.removeItem("bianquan_email");
    localStorage.removeItem("bianquan_status");
  },
  //显示alert弹框
  show_alert(state,data) {
    state.alert.msg = data;
    state.alert.show = true;
  },
    //隐藏alert弹框
  close_alert(state) {
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
  show_nav(state,params) {
    state.show_header_nav = params;
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
  },//将图片加入项目中
  add_lab_imgs:function(state,url) {
    state.lab_imgs.push(url);
  },//移除项目中的图片
  remove_lab_img:function(state,index) {
    state.lab_imgs.splice(index,1);
  },
  //清空项目中的图片
  clear_lab_img:function(state,data) {
    state.lab_imgs = data;
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
  //页面刷新后，vuex数据丢失，判断localstorage中是否存储，若有存储则将数据注入store中
  refresh (state) {
    //console.log(state.show_article);
    // if(window.localStorage.getItem("show_article")) {
    //   state.show_article = JSON.parse(window.localStorage.getItem("show_article")) ;
    //  // console.log(state.show_article);
    // }
    if(window.localStorage.getItem("page_index")) {
      state.page_index = window.localStorage.getItem("page_index") ;
      // console.log(state.show_article);
    }
  },
  //将获取的所有文章列表数据填充到items里
  GETLIST(state,res) {
    state.items = res;
//    console.log(res);
//   console.log(state.items.length);
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
  //获取页面的数量，并生成递增数组
  GETPAGECOUNT(state,count) {
    state.page_count = [];
    for(let i=0;i<count;i++){
      state.page_count.push(i+1);
    }
    // console.log(count);
  },
  //点击文章列表第n页，将n注入到store中的page_index中
  changePage(state,index) {
    state.page_index = index;
    //console.log(state.page_index);
    window.localStorage.setItem("page_index", state.page_index);
  },
  //获取第n页文章列表数据
  GETPAGE(state,pageDate) {
    state.page_items = pageDate;
    for(let i=0;i<pageDate.length;i++) {
      let _content = simplemde.prototype.markdown(pageDate[i].a_content);
      state.page_items[i].a_content = _content;
    }
  },
  //获取所点击的文章展示数据
  SHOWARTICLE(state,index) {
    state.show_article = state.page_items[index];
    // console.log(state.show_article);
    //将获取的文章内容存入localstorage中
    //window.localStorage.setItem("show_article", JSON.stringify(state.show_article));
    router.push({name:'article',params:{id:state.show_article.a_id}});
  },//清除面包屑导航
  CLEAR_CRUMBS:function(state) {
    state.crumbs.first = '';
    state.crumbs.second = '';
  },//添加面包屑导航文章标题和标签
  CHANGE_CRUMBS:function(state,obj) {
    if(obj.tag) {
      state.crumbs.first = obj.tag;
    }
    state.crumbs.second = obj.title;
    //console.log(state.crumbs);
  },
  GETSHOWARTICLE(state,data) {
    state.show_article = data;
   // console.log(data.content);
   //转码
    let _content = simplemde.prototype.markdown(data.a_content);
    state.show_article.a_content = _content;
   // console.log(state.show_article.content);
  },
    //清空文章评论列表
    CLEARCOMMENT(state) {
      state.comment = [];
    },
  //将获取的某一篇文章的评论填充到相应的store中
  GETCOMMENT(state,result) {
    for(let i=0;i<result.length;i++) {
      if(result[i].c_published == 0 && result[i].c_content=='0') {
        result[i].c_content = '该评论已被屏蔽';
      }
      if (result[i].c_type == 0) {
        let content = simplemde.prototype.markdown(result[i].c_content?result[i].c_content:'');
        state.comment.push({
          id:result[i].c_id,
          name: result[i].c_user,
          time: result[i].c_time,
          content: content,
          reply: []
        });
      }
    }
    for(let i=0;i<result.length;i++) {
      if (result[i].c_type == 1) {
        let content = result[i].c_content;
        state.comment[result[i].c_index].reply.push({
          id:result[i].c_id,
          responder: result[i].c_user,
          reviewers: result[i].c_oldComment,
          time: result[i].c_time,
          content: content,
        });
      }
    }
  },
  //添加某一条评论，将评论数据注入到store中，在页面中展示新增评论
  ADDCOMMENT(state) {
    if(state.type == 0) {
      state.comment.push({
        name: state.commenter,
        time: common.getTime(),
        content: state.commentText,
        reply: []
      });
    }else if(state.type == 1){
      state.comment[state.chosedIndex].reply.push({
        responder: state.commenter,
        reviewers:state.comment[state.chosedIndex].name,
        time: common.getTime(),
        content: state.commentText
      });
      state.type = 0;
      state.chosedIndex = -1;

    }
    state.show_article.comment++;
    state.webdata.comment++;
    state.commentText = "";
    state.type = 0;
    state.oldComment = null;
    state.chosedIndex = -1;
  },
  //改变要回复的对象，将要回复的人名和序号注入store中
  changeCommenter: function(state,obj) {
    state.oldComment = obj.name;
    state.chosedIndex = obj.index;
    // console.log(obj.name);
    // console.log(obj.index);
    state.type = 1;
  },
  //取消在楼层内回复
  canelComment: function() {
    state.type = 0;
    state.chosedIndex = -1;
    state.oldComment = null;
  },
    //获取后台所有图片地址
  GET_ALL_IMGS:function(state,data) {
    state.all_images.src = data;
  },
  //发布或下架选中文章
  PUBLISH:function(state,data) {
    state.items[data.index].published = data.publish;
  },
    //点赞
  ADD_PRAISE:function(state,id) {
    if(id) {
      state.show_article.a_praise++;
    }
    state.webdata.praise++;
    
  },
    //获取网站统计数据
    GET_WEBDATA:function(state,data) {
      state.webdata.article = data.total_article;
      state.webdata.comment = data.total_comment;
      state.webdata.praise = data.total_praise;
      state.webdata.tags = data.total_tags;
      state.webdata.user = data.total_user;
      state.webdata.viewers = data.total_viewers;
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
    GET_ALL_ARTICLE:function(state,data) {
      let timer = [];//用于存储整个时间轴数组[{year:2018,month:[{month:2018-1,list:[]}]}]
      
      for(let i=0;i<data.length;i++) {
        let year = data[i].a_time.substr(0,4);
        let month = data[i].a_time.substr(0,7);
        let obj = {};//用于存储年份的对象{year:2018,month:[]}
        obj.year = year;
        obj.month = [];
        let _obj = {};//用于存储月份的对象{month:2018-01,list:[]}
        _obj.month = month;
        _obj.list = [];
        _obj.list.push(data[i]);
        obj.month.push(_obj);
        if(timer.length>0) {//判断时间轴数组是否为空
          let check = false;
          for(let j=0;j<timer.length;j++) {
            if(year == timer[j].year){//判断本次循环年份是否存在于时间轴数组里
              check = true;
              let _month = timer[j].month;
              if(_month.length>0) { //判断年月份数组是否为空
                let _check = false;
                for(let k=0;k<_month.length;k++) {
                  if(month == _month[k].month) {//判断本次循环月份是否存在于数组中
                    _check = true;
                    _month[k].list.push(data[i]);//将本记录插入月份数组列表中
                  }
                }
                if(!_check) {//本次数据不属于当前数组存在的月份
                  _month.push(_obj);
                }
              } else {
                _month.push(_obj);
              }
            }
          } 
          if(!check) {//本次数据不属于当前数组存在的年份
            timer.push(obj);
          }
        }else {
           timer.push(obj);
          }
      }
      state.timer = timer
      //console.log(timer);
    },
    GET_BING:function(state,data) {
      state.search.bing = data;
    },
    TOGGLE_SEARCH:function(state,toggle) {
      state.search.box = toggle;
    },
    GET_PRODUCTION:function(state,data) {
      state.production = data;
      let search_first = true;
      let published_index;
      for(let i=0;i<data.length;i++) {
       let img = data[i].pr_img.split(',');
       let content = data[i].pr_content.split(',');
       state.production[i].pr_img = img;
       state.production[i].pr_content = content;
       if(data[i].pr_published == 1 && search_first) {
         published_index = i;
         search_first = false;
       }
      }
      state.show_production.name = state.production[published_index].pr_name;
      state.show_production.src = state.production[published_index].pr_src;
      state.show_production.content = state.production[published_index].pr_content;
      state.show_production.imgs = state.production[published_index].pr_img;
    },
    change_production:function(state,index) {
      state.show_production.name = state.production[index].pr_name;
      state.show_production.content = state.production[index].pr_content;
      state.show_production.imgs = state.production[index].pr_img;
      state.show_production.src = state.production[index].pr_src;
    }
  }
  
  export default mutations