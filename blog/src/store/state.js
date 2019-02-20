const state = {
  
    logout_box: false,//注销弹框
    alert: {msg:'',show: false},//alert弹框内容
    alert_notice: {msg:'',show: false},//自动关闭alert弹框内容
    show_img: {src:'',box: false},//图片放大弹框内容
    showHeaderNav: true,//首页顶部导航栏展示与隐藏
    show_sidebar: false,//控制管理页侧边导航栏的显示与隐藏

    show_article: {},//获取展示页面的数据

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
    search: {
      box: false,
      bing: ''//bing图片地址
    },
    if_touch:false,//判断屏幕是否被触摸
  }
  
  export default state