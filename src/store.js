import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import router from './routes.js';
Vue.use(Vuex);
import simplemde from 'simplemde';



const state = {
  loginbox:false,//控制登录页面显示
  register_login_btn: false,//控制登录页和注册页切换
  change_notice: "未注册？点击进行注册",//控制登录页和注册页切换提示
  userName: null,//登录用户名
  userEmail:null,//登录邮箱
  userPwd:null,//登录密码
  login_user:(window.localStorage.getItem("bianquan_user"))?'欢迎您!'+ window.localStorage.getItem("bianquan_user") : '登录',//登录与后台用户名标识
  //token,本地若有token值，则注入store，若无则为null
  token:(window.localStorage.getItem("bianquan_token"))?window.localStorage.getItem("bianquan_token"):null,
  //用户身份
  status:(window.localStorage.getItem("bianquan_status"))?window.localStorage.getItem("bianquan_status"):null,
  logout_box: false,//注销弹框
  alert: {msg:'',show: false},//alert弹框内容
  alert_notice: {msg:'',show: false},//自动关闭alert弹框内容
  show_img: {src:'',box: false},//图片放大弹框内容
  show_header_nav: true,//首页顶部导航栏展示与隐藏
  show_sidebar: false,//控制管理页侧边导航栏的显示与隐藏
  c_button:true,//控制编辑页面按钮更新或发送的切换
  items: [],//后台所有文章列表数据
  page_items: [],//某一页文章列表数据
  page_count: [],//首页页面数
  page_index: 0,//控制首页展示第几页面
  show_article: {},//获取展示页面的数据
  title: '',//编辑页文章标题
  article_background: '',//编辑页文章封面
  content: '',//编辑页文章内容
  tag: '生活随笔',//编辑页文章标签
  options:[],//编辑页标签选项
  id: '',             //博客文章id
  time: '',           //博客文章的时间
  commentArticleId: null,   //获取要添加评论所属文章的id
  type: 0,                //0为评论作者1为评论别人的评论
  oldComment: null,    //被评论的人
  chosedIndex: -1,        //被选中的评论的index
  comment: [],            //评论信息
  commentText:"",         //要发表评论的内容
  commenter:(window.localStorage.getItem("bianquan_user"))? window.localStorage.getItem("bianquan_user") : '',        //要发表评论作者
  commenterEmail:(window.localStorage.getItem("bianquan_email"))? window.localStorage.getItem("bianquan_email") : '',        //要发表评论的邮箱
  all_images:{src:[],box:false,write: true} ,   //从后台获取的所有图片地址
  configs: {
    status: false,
    initialValue: 'Hello BBK',
    spellChecker: false
  },
  webdata: {  //网页统计数据
    praise: 0,
    article: 0,
    user: 0,
    comment: 0,
    tags: 0,
    viewers: 0
  },
  all_comment : [],
  all_user: [],
  all_neighbors: [],
  about_markdown: '', //about页面数据
  about_html: '',
  now_time:'',//当前时间
  how_long: '',//网站运行时长
  crumbs: { //主页面包屑标签
    first: '',
    second: ''
  },
  show_loading: false,
  timer: [],//时间轴所有文章列表
  search: {
    box: false,
    bing: ''//bing图片地址
  },
  if_touch:false,//判断屏幕是否被触摸
  lab_imgs: [],//实验室项目图片
  production: [],//所有项目列表
  show_production: {//页面暂时的项目数据
    name: '',
    content: [],
    imgs: []
  },
   //URL: 'http://www.ynxnw.top/bianquan.php'
   URL: 'http://localhost:80/blogtest.php'
};

 //格式化时间
const getTime = function() {
      let now = new Date();
      let year = now.getFullYear();
      let month = now.getMonth()+1;
      let day = now.getDate();
      let hour = now.getHours();
      let minute = now.getMinutes();
      let second = now.getSeconds();
      month = month.length < 2 ?  "0" + month : month;
      day = day.length < 2 ?  "0" + day : day;
      return year+"-"+month+"-"+day+" "+hour+":"+minute+":"+second;
}

const _axios= params => {
  return axios({
          method: "post",
          url: state.URL,
          data: params
        })
}
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
    state.now_time = getTime();
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
    let result=data.data;
    let _content = unescape(result.content);
    state.title=result.title;
    state.content= _content;
    state.tag=result.tag;
    state.id=result.id;
    state.time=result.time;
    state.article_background=result.img;
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
    //console.log(state.page_count);
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
      let _content = simplemde.prototype.markdown(unescape(pageDate[i].content));
      state.page_items[i].content = _content;
    }
  },
  //获取所点击的文章展示数据
  SHOWARTICLE(state,index) {
    state.show_article = state.page_items[index];
    // console.log(state.show_article);
    //将获取的文章内容存入localstorage中
    //window.localStorage.setItem("show_article", JSON.stringify(state.show_article));
    router.push({name:'article',params:{id:state.show_article.id}});
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
    let _content = simplemde.prototype.markdown(unescape(data.content));
    state.show_article.content = _content;
   // console.log(state.show_article.content);
  },
  //将获取的某一篇文章的评论填充到相应的store中
  GETCOMMENT(state,result) {
    state.comment = [];
    for(let i=0;i<result.length;i++) {
      if (result[i].type == 0) {
        let content = simplemde.prototype.markdown(unescape(result[i].content));
        state.comment.push({
          id:result[i].id,
          name: result[i].user,
          time: result[i].time,
          content: content,
          reply: []
        });
      }
    }
    for(let i=0;i<result.length;i++) {
      if (result[i].type == 1) {
        let content = unescape(result[i].content);
        state.comment[result[i].index].reply.push({
          id:result[i].id,
          responder: result[i].user,
          reviewers: result[i].oldComment,
          time: result[i].time,
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
        time: getTime(),
        content: state.commentText,
        reply: []
      });
    }else if(state.type == 1){
      state.comment[state.chosedIndex].reply.push({
        responder: state.commenter,
        reviewers:state.comment[state.chosedIndex].name,
        time: getTime(),
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
      state.show_article.praise++;
    }
    state.webdata.praise++;
    
  },
    //获取网站统计数据
    GET_WEBDATA:function(state,data) {
      state.webdata.article = data.article;
      state.webdata.comment = data.comment;
      state.webdata.praise = data.praise;
      state.webdata.tags = data.tags;
      state.webdata.user = data.user;
      state.webdata.viewers = data.viewers;
    },
    //获取所有的评论
    GET_ALL_COMMENT:function(state,data) {
      //console.log(data[0].articleId);
      let articleId = [];
      for(let i=0;i<data.length;i++) {
          articleId[i] = data[i].articleId;
          data[i].content = unescape(data[i].content);
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
          if(data[l].articleId == articleId[k]) {
            obj.content.push(data[l]);
          }
        }
        comment.push(obj);

      }
      state.all_comment = comment;
      //console.log(comment);
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
      state.about_markdown = unescape(data);
      //console.log(state.about_markdown);
      state.about_html = simplemde.prototype.markdown(unescape(data));
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
        let year = data[i].time.substr(0,4);
        let month = data[i].time.substr(0,7);
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
      //console.log(data);
      state.production = data;
      for(let i=0;i<data.length;i++) {
       let img = data[i].img.split(',');
       let content = data[i].content.split(',');
       state.production[i].img = img;
       state.production[i].content = content;
      }
      state.show_production.name = state.production[0].name;
      state.show_production.content = state.production[0].content;
      state.show_production.imgs = state.production[0].img;
      //console.log(state.production);
    },
    change_production:function(state,index) {
      state.show_production.name = state.production[index].name;
      state.show_production.content = state.production[index].content;
      state.show_production.imgs = state.production[index].img;
    }
};

const actions = {
  
   //验证用户是否登录
   check_login({state,commit}) {
     //console.log(state.token);
     let params = {
       'act':'check_login'
     }
     _axios(params).then(function (res) {
       //console.log('成功了');
       //console.log(res.data);
       if (res.data.check_success) {
        router.push('/admin');
       } else {
         commit('change');
         commit('logout');
         commit('show_login_box');
       }
     })
       .catch(function (err) {
         console.log(err);
         console.log('失败了');
       });
 
   },
  
  
  
  //用户提交登录
  login({commit,state}) {
   // console.log(state.token);
    // console.log(state.userPwd);
    // console.log(state.userEmail);
    let params = {
      'act':'login',
      'email':state.userEmail,
      'pwd':state.userPwd
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      //console.log(res.data);
      if (res.data.result == 'success') {
        //本地存储token
        //console.log('success');
        axios.defaults.headers.common['X-token'] = res.data.jwt;
        localStorage.setItem('bianquan_token',res.data.jwt);
        localStorage.setItem('bianquan_user',res.data.name);
        localStorage.setItem('bianquan_email',res.data.email);
        localStorage.setItem('bianquan_status',res.data.userstatus);
        //同步token到store中
        commit('token',res.data);
        commit('change');
        let data = '登录成功！'
        commit('show_alert_notice',data);
      } else{
        if(res.data.message) {
          commit('show_alert',res.data.message);
        } else {
          commit('show_alert','登录失败');
        }
        
      }
      if(res.data.check_success) {
        commit('change');
      }
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });

  },
//用户提交注册
  register({commit,state}) {
    // console.log(state.userPwd);
    let params = {
          'act':'register',
          'email':state.userEmail,
          'name':state.userName,
          'pwd':state.userPwd,
          'time':getTime()
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      //console.log(res.data);
      if(res.data.message) {
        commit('show_alert',res.data.message);
      } else {
        commit('show_alert','注册失败');
      }
      
      if (res.data.result == "success") {
        commit('show_login_box');
      }
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });

  },

  //获取所有文章列表
  getList:function({commit,state}) {
    //console.log(commit);
    //console.log(params);
    let list=[];
    let params = {
      'act':'get'
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      //console.log(res.data);
      if(res.data.result == 'success') {
        let result = res.data.data;
        for(let i=0;i<result.length;i++) {
          list.push({
            id: result[i].id,
            title: result[i].title,
            author: result[i].author,
          // content: result[i].content,
            time: result[i].time,
            tag: result[i].tag,
            published: result[i].published
          })
        }
        commit('GETLIST',list);
      }
      if(res.data.login == 'false') {
        router.push('/');
        commit('change');
        commit('show_alert','登录超时，请重新登录');
        commit('logout');
      }

     // console.log(result);
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });
  },
  //添加文章
  addArticle:function({commit,state}){
    if(!(state.title && state.content &&state.article_background)) {
      commit('show_alert','请确保信息完整');
      return;
    }
    let content = escape(state.content);
    let params = {
      'act':'add',
      'name':state.commenter,
      'title':state.title,
      'content':content,
      'tag':state.tag,
      'time':getTime(),
      'article_background':state.article_background
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      //console.log(res);
      if(res.data.result == 'success') {
        router.push('/admin/editor');
        commit('UPDATEARTICLE');
      }
      if(res.data.login == 'false') {
        router.push('/');
        commit('change');
        commit('show_alert','登录超时，请重新登录');
        commit('logout');
      }

    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });
  },
  //删除选中文章
  delArticle:function({commit,state},obj){
    //console.log(obj);
    let params = {
      'act':'del',
      'id':obj.id
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      if(res.data.result == 'success') {
        commit('DELARTICLE',obj.index);
      }
      if(res.data.error == 'Permission denied') {
         commit('show_alert','权限不足');
      }
      if(res.data.login == 'false') {
        router.push('/');
        commit('change');
        commit('show_alert','登录超时，请重新登录');
        commit('logout');
      }
      
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });
  },
  //获取需要展示文章内容
  getShowArticle:function({commit,state},id) {
    let params = {
      'act':'getOne',
      'id':id
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      //console.log(res.data.data[0]);
      if(res.data.result == 'success') {
        commit('GETSHOWARTICLE',res.data.data);
      }

    })
    .catch(function (err) {
      console.log(err);
      console.log('失败了');
    });
  },
  //获取选中需编辑文章内容
  getOneArticle:function({commit,state},id){
    let params = {
      'act':'getOne',
      'id':id
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      if(res.data.result == 'success') {
        commit('GETONEARTICLE',res.data);
        router.push('/admin/write');
      }
      if(res.data.publish == 'false') {
        commit('show_alert','文章为关闭状态，无法编辑');
      }
      if(res.data.login == 'false') {
        router.push('/');
        commit('change');
        commit('show_alert','登录超时，请重新登录');
        commit('logout');
      }

    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });
  },
  //更新选中的文章内容
  updateArticle:function({commit,state}){
   // console.log(state.id);
   if(!(state.title && state.content &&state.article_background)) {
      commit('show_alert','请确保信息完整');
      return;
    }
    let content = escape(state.content);
    let params = {
      'act':'update',
      'title':state.title,
      'content':content,
      'tag':state.tag,
      'id':state.id,
      'article_background':state.article_background
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      if(res.data.result == 'success') {
        router.push('/admin/editor');
        commit('UPDATEARTICLE');
      }
      if(res.data.error == 'Permission denied') {
        commit('show_alert','权限不足');
     }
      if(res.data.login == 'false') {
        router.push('/');
        commit('change');
        commit('show_alert','登录超时，请重新登录');
        commit('logout');
      }
      
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });
  },
  //获取首页文章页数
  getPageCount:function({commit,state}) {
    let params = {
      'act':'getPageCount',
      'tag': state.crumbs.first
    }
    _axios(params).then(function (res) {
      //console.log('获取页面数成功了');
      //console.log(res);
      if(res.data.result == 'success') {
        let count = res.data.count;
      commit('GETPAGECOUNT',count);
      }
      
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });
  },
  //获取某一页文章列表数据
  getPage:function({commit,state}) {
    let params = {
      'act':'getPage',
      'page': state.page_index,
      'tag': state.crumbs.first
    }
    _axios(params).then(function (res) {
      //console.log('获取页面列表成功');
      //console.log(res.data.data);
      if(res.data.result == 'success') {
        let pageDate = res.data.data;
        commit('GETPAGE',pageDate);
      }
      
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });
  },
  //获取某一篇文章的评论内容
  getComment: function({commit,state},id) {
    let params = {
      'act':'getComment',
      'id':id
    }
    _axios(params).then(function (res) {
      //console.log('获取评论成功了');
      
      if(res.data.result == "success") {
        commit('GETCOMMENT',res.data.data);
      }
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });
  },
  //对某一篇文章增加评论
  addComment: function({commit,state}) {
    //console.log(this.commentText);
    let commentText = escape(state.commentText);
    let a_id = state.commentArticleId;
    let params = {
      'act':'addComment',
      'commenter':state.commenter,
      'commenterEmail':state.commenterEmail,
      'commentText':commentText,
      'time':getTime(),
      'oldComment':state.oldComment,
      'id':a_id,
      'type':state.type,
      'index':state.chosedIndex
    }

    _axios(params).then(function (res) {
      //console.log('评论添加成功了');
      //console.log(res);
      if(res.data.result == 'success') {
        commit("ADDCOMMENT");
      }
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });

  },
    //获取所有图片地址
  get_all_imgs:function({commit,state}) {
    let params = {
      'act':'get_all_imgs'
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      //console.log(res.data);
      if(res.data.result == 'success') {
        commit('GET_ALL_IMGS',res.data.data);
      }
      if(res.data.login == 'false') {
        router.push('/');
        commit('change');
        commit('show_alert','登录超时，请重新登录');
        commit('logout');
      }
      
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });

  },
    //发布或下架选中文章
  publish: function({commit,state},data) {
    let index = data.index;
    let params = {
      'act':'publish',
      'id':data.id,
      'publish':data.publish
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      //console.log(res.data);
      if(res.data.result == 'success') {
        let data = {};
        data.publish = res.data.publish;
        data.index = index;
        commit('PUBLISH',data);
      }
      if(res.data.login == 'false') {
        router.push('/');
        commit('change');
        commit('show_alert','登录超时，请重新登录');
        commit('logout');
      }
      
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });
  },
      //点赞
      add_praise: function({commit,state},id) {
        let params = {
          'act':'add_praise',
          'id':id
        }
        _axios(params).then(function (res) {
          //console.log('成功了');
          //console.log(res.data);
          commit("ADD_PRAISE",id);
        })
          .catch(function (err) {
            console.log(err);
            console.log('失败了');
          });

        },
         //获取网站基本统计数据
      get_webdata: function({commit,state}) {
        let params = {
          'act':'get_webdata'
        }
        _axios(params).then(function (res) {
          //console.log('成功了');
          //console.log(res.data);
          if(res.data.result == 'success') {
            commit("GET_WEBDATA",res.data.data);
          }
          
        })
          .catch(function (err) {
            console.log(err);
            console.log('失败了');
          });

        },//获取所有评论内容
        get_all_comment: function({commit,state}) {
          let params = {
            'act':'get_all_comment'
          }
          _axios(params).then(function (res) {
            //console.log('成功了');
            //console.log(res.data);
            if(res.data.result == 'success') {
             commit("GET_ALL_COMMENT",res.data.data);
            }
            if(res.data.error == 'Permission denied') {
              commit('show_alert','权限不足');
           }
           if(res.data.login == 'false') {
            router.push('/');
            commit('change');
            commit('show_alert','登录超时，请重新登录');
            commit('logout');
          }
          })
            .catch(function (err) {
              console.log(err);
              console.log('失败了');
            });
  
          },
          //屏蔽或解封评论
          comment_publish: function({commit,state},data) {
            let params = {
              'act':'close_comment',
              'id':data.id,
              'publish':data.publish
            }
            _axios(params).then(function (res) {
              //console.log('成功了');
              //console.log(res.data);

              if(res.data.result == 'success') {
                let _data = {};
                _data.id = res.data.id;
                _data.index = data.index;
                _data._index = data._index;
                _data.publish = res.data.publish;
               commit("CLOSE_COMMENT",_data);
              }
              if(res.data.login == 'false') {
                router.push('/');
                commit('change');
                commit('show_alert','登录超时，请重新登录');
                commit('logout');
              }
              
            })
              .catch(function (err) {
                console.log(err);
                console.log('失败了');
              });
    
            },
          //显示所有用户列表
          show_all_user: function({commit,state}) {
            let params = {
              'act':'show_all_user'
            }
            _axios(params).then(function (res) {
              //console.log('成功了');
              //console.log(res.data.data);

              if(res.data.result == 'success') {
               commit("SHOW_ALL_USER",res.data.data);
              }
              if(res.data.error == 'Permission denied') {
                commit('show_alert','权限不足');
             }
             if(res.data.login == 'false') {
              router.push('/');
              commit('change');
              commit('show_alert','登录超时，请重新登录');
              commit('logout');
            }
              
            })
              .catch(function (err) {
                console.log(err);
                console.log('失败了');
              });
    
            },
          //获取所有标签
          get_tags: function({commit,state}) {
            let params = {
              'act':'get_tags'
            }
            _axios(params).then(function (res) {
              //console.log('成功了');
              //console.log(res.data.data);

              if(res.data.result == 'success') {
               commit("GET_TAGS",res.data.data);
              }
              
            })
              .catch(function (err) {
                console.log(err);
                console.log('失败了');
              });
    
            },
           //新增标签
          add_tags: function({commit,state},tag) {
            let params = {
              'act':'add_tags',
              'name':tag
            }
            _axios(params).then(function (res) {
              //console.log('成功了');
              //console.log(res.data.result);
              if(res.data.result == 'success') {
               commit("ADD_TAGS",tag);
              }
              if(res.data.error == 'Permission denied') {
                commit('show_alert','权限不足');
             }
              
            })
              .catch(function (err) {
                console.log(err);
                console.log('失败了');
              });
    
            },
       //移除标签
          del_tags: function({commit,state},obj) {
            let params = {
              'act':'del_tags',
              'name':obj.tag
            }
            _axios(params).then(function (res) {
              //console.log('成功了');
              //console.log(res.data.result);
              if(res.data.result == 'success') {
               commit("DEL_TAGS",obj.index);
              }
              if(res.data.error == 'Permission denied') {
                commit('show_alert','权限不足');
             }
              
            })
              .catch(function (err) {
                console.log(err);
                console.log('失败了');
              });
    
            },
         //新增友情链接
          add_neighbors: function({commit,state},obj) {
            let time = getTime();
            let params = {
              'act':'add_neighbors',
              'name':obj.name,
              'url':obj.url,
              'imgs':obj.icon,
              'time':time,
              'publish':obj.publish,
            }
            obj.time = time;
            _axios(params).then(function (res) {
              //console.log('成功了');
              //console.log(res.data.result);
              if(res.data.result == 'success') {
               commit("ADD_NEIGHBORS",obj);
              }
              if(res.data.error == 'Permission denied') {
                commit('show_alert','权限不足');
             }
              
            })
              .catch(function (err) {
                console.log(err);
                console.log('失败了');
              });
    
            },
          //获取所有友情链接
          get_neighbors: function({commit,state}) {
            let params = {
              'act':'get_neighbors'
            }
            _axios(params).then(function (res) {
              //console.log('成功了');
             // console.log(res.data.data);
              if(res.data.result == 'success') {
               commit("GET_NEIGHBORS",res.data.data);
              }
              
            })
              .catch(function (err) {
                console.log(err);
                console.log('失败了');
              });
    
            },
            
           //删除友情链接
            del_neighbors:function({commit,state},index) {
            let params = {
              'act':'del_neighbors',
              'name':state.all_neighbors[index].name
            }
            _axios(params).then(function (res) {
              //console.log('成功了');
              console.log(res.data.result);
              if(res.data.result == 'success') {
               commit("DEL_NEIGHBORS",index);
              }
              if(res.data.error == 'Permission denied') {
                commit('show_alert','权限不足');
             }
            })
              .catch(function (err) {
                console.log(err);
                console.log('失败了');
              });
    
            },
            
         //更新about页数据
         update_about:function({commit,state}) {
           let about = escape(state.about_markdown);
          let params = {
            'act':'update_about',
            'content':about
          }
          _axios(params).then(function (res) {
            //console.log('成功了');
            //console.log(res.data.result);
            if(res.data.result == 'success') {
             commit("show_alert_notice",'内容更新成功');
             commit('UPDATE_ABOUT');
            } else {
              commit('show_alert','更新失败');
            }
            if(res.data.error == 'Permission denied') {
              commit('show_alert','权限不足');
           }
          })
            .catch(function (err) {
              console.log(err);
              console.log('失败了');
            });
          },
         //获取about页数据
         get_about:function({commit,state}) {
         let params = {
           'act':'get_about'
         }
         _axios(params).then(function (res) {
           //console.log('成功了');
           //console.log(res.data.data);
           if(res.data.result == 'success') {
            commit("GET_ABOUT",res.data.data);
           }
         })
           .catch(function (err) {
             console.log(err);
             console.log('失败了');
           });
         },
        //删除图片
        del_img:function({commit,state},index) {
          let params = {
            'act':'del_img',
            'url':state.all_images.src[index],
          }
          //console.log(state.all_images.src[index]);
          _axios(params).then(function (res) {
            //console.log('成功了');
            //console.log(res.data.data);
            if(res.data.result == 'success') {
             commit("DEL_IMG",index);
            }
            if(res.data.error == 'Permission denied') {
              commit('show_alert','权限不足');
           }
          })
            .catch(function (err) {
              console.log(err);
              console.log('失败了');
            });
          },
         //获取所有上架文章的列表
         get_all_article:function({commit,state}) {
          let params = {
            'act':'get_all_article'
          }
          _axios(params).then(function (res) {
            //console.log('成功了');
            //console.log(res.data.data);
            if(res.data.result == 'success') {
             commit("GET_ALL_ARTICLE",res.data.data);
            }
          })
            .catch(function (err) {
              console.log(err);
              console.log('失败了');
            });
          },
        //获取bing图片
         get_bing:function({commit,state}) {
          let params = {
            'act':'get_bing'
          }
          _axios(params).then(function (res) {
            //console.log('成功了');
            //console.log(res.data);
            commit("GET_BING",res.data.bing);
            
          })
            .catch(function (err) {
              console.log(err);
              console.log('失败了');
            });
          },
         //获取作品内容
         get_production:function({commit,state}) {
          let params = {
            'act':'get_production'
          }
          _axios(params).then(function (res) {
            //console.log('成功了');
            if(res.data.result == 'success') {
              commit("GET_PRODUCTION",res.data.data);
            }
          })
            .catch(function (err) {
              console.log(err);
              console.log('失败了');
            });
          },
}



export default new Vuex.Store({
  state,
  actions,
  mutations
})
