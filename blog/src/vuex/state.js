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
    show_production: {//页面展示的项目数据
      name: '',
      content: [],
      imgs: []
    },
     URL: 'http://localhost:80/bianquan/servers/public/index.php/index'
  }
  
  export default state