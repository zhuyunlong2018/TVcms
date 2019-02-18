const state = {
  
    logout_box: false,//注销弹框
    alert: {msg:'',show: false},//alert弹框内容
    alert_notice: {msg:'',show: false},//自动关闭alert弹框内容
    show_img: {src:'',box: false},//图片放大弹框内容
    showHeaderNav: true,//首页顶部导航栏展示与隐藏
    show_sidebar: false,//控制管理页侧边导航栏的显示与隐藏
    c_button:true,//控制编辑页面按钮更新或发送的切换
    items: [],//后台所有文章列表数据
    show_article: {},//获取展示页面的数据
    title: '',//编辑页文章标题
    article_background: '',//编辑页文章封面
    content: '',//编辑页文章内容
    tag: '生活随笔',//编辑页文章标签
    options:[],//编辑页标签选项
    id: '',             //博客文章id
    time: '',           //博客文章的时间
   
    all_images:{src:[],box:false,write: true} ,   //从后台获取的所有图片地址
    configs: {
      status: false,
      initialValue: 'Hello BBK',
      spellChecker: false
    },
    webdata: {  //网页统计数据
      praise_num: 0,
      article_num: 0,
      user_num: 0,
      comment_num: 0,
      tags_num: 0,
      viewers_num: 0
    },
    all_neighbors: [],
    about_markdown: '', //about页面数据
    now_time:'',//当前时间
    how_long: '',//网站运行时长
    crumbs: { //主页面包屑标签
      tagName: '',
      tagID: '',
      title: ''
    },
    show_loading: false,
    timer: [],//时间轴所有文章列表
    search: {
      box: false,
      bing: ''//bing图片地址
    },
    if_touch:false,//判断屏幕是否被触摸
     URL: 'http://localhost:80/bianquan/servers/public/index.php/index'
  }
  
  export default state