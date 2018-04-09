# bianquan-blog
vue.js+php博客系统 [Demo](http://www.ynxnw.top)


## Build Setup
前端：
``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build
```
后端：
1、先创建mysql数据库，将bianquan.sql中的语句复制到数据库中创建数据库和相应表
2、将vendor文件夹和bianquan.php放入PHP环境网站跟目录，如D:\wamp\www文件夹下



**项目简介**：
> 名称：边泉博客管理平台；
> 前端：Vue+Vuex+Vue-Router+axios；
> 后端：PHP+MySQL；
> 兼容性：ie9+，移动端，PC端；

**主要功能**：
> * 用户登录、注册；
* 用户评论、游客评论；
* 评论回复邮件提醒；
* 页面文章标签检索展示；
* 页面文章时间轴排序；
* 页面项目展示；
* 后台文章增加、编辑、删除、下架管理；
* 后台评论屏蔽、解封管理；
* 后台图片上传、删除功能；
* 后台标签新增、删除功能；
* 后台友情链接新增、删除功能；
* 后台实验室项目新增、下架功能；

**目前存在问题**： 
1.  页面响应式布局方面，还有一些元素在特殊窗口尺寸中显示不协调；
2.  虽然开放注册功能，但未加入验证码、邮箱验证功能，并且关闭普通会员文章操作权限，普通会员投稿默认为不发布，并且无法编辑状态，需管理员发布和编辑。
3.  评论被回复邮件通知还是半成品；
4.  搜索功能未完成；


**文件目录**
```
├──node_modules// 项目依赖的模块    
├── src// 源码目录 
│ ├──  assets// 资源目录 
│ ├── components// vue公共组件
│ │ ├── header.vue// 前台头部组件
│ │ ├── footer.vue// 前台底部组件
│ │ ├── aside.vue// 前台侧边栏组件
│ │ ├── login.vue// 前台登录、注册页面组件
│ │ ├── articleList.vue// 前台文章列表页面组件
│ │ ├── msgborder.vue// 前台留言板页面组件
│ │ ├── project.vue// 前台实验室页面组件
│ │ ├── timer.vue// 前台时间轴页面组件
│ │ ├── about.vue// 前台关于页面组件
│ │ ├── comment.vue// 前台评论区页面组件
│ │ ├── components.vue// 通用alert、提示框、前台搜索框组件
│ │ ├── all_images.vue// 后台所有图片弹框组件
│ │ ├── admin_aside.vue// 后台侧边导航栏组件
│ │ ├── admin_header.vue// 后台头部组件
│ │ ├── outline.vue// 后台网站概要页面组件
│ │ ├── user.vue// 后台个人中心页面组件
│ │ ├── write.vue// 后台发布文章页面组件
│ │ ├── editor.vue// 后台编辑文章页面组件
│ │ ├── editor_comment.vue// 后台评论管理页面组件
│ │ ├── menber_list.vue// 后台会员管理页面组件
│ │ ├── imgs_list.vue// 后台图片管理页面组件
│ │ ├── other_seting.vue// 后台其他设置页面组件
│ │ └── lab.vue// 后台实验室页面组件
│ ├──views// 前后台根组件
│ │ ├── admin.vue// 后台根组件
│ │ └── home.vue// 前台根组件
│ ├── App.vue// 页面入口文件（根组件）
│ ├── routes.js// 页面路由操作文件
│ ├── store.js// 页面数据仓库文件
│ └── main.js// 程序入口文件（入口js文件）
├── vendor// php包文件夹，含jwt和sendMail
├── bianquan.sql// 数据库语句
├── bianquan.php// 后台php主体
├── static// 静态文件，比如一些图片，json数据等
├── .babelrc// ES6语法编译配置
├── .editorconfig// 定义代码格式
├── .gitignore// git上传需要忽略的文件格式
├── index.html// 入口页面
├── package.json// 项目基本信息
├── README.md// 项目说明
```
组件结构图：
![](http://www.ynxnw.top/static/imgs/20180405/jiegoutu.jpg)
**主要页面展示**：
首页：![](http://www.ynxnw.top/static/imgs/20180409/HOME.jpg)
文章详情：![](http://www.ynxnw.top/static/imgs/20180409/article.jpg)
留言板：![](http://www.ynxnw.top/static/imgs/20180409/MESSAGE.jpg)
实验室：![](http://www.ynxnw.top/static/imgs/20180409/PROJECT.jpg)
时间轴：![](http://www.ynxnw.top/static/imgs/20180409/SEARCH.jpg)
搜索：![](http://www.ynxnw.top/static/imgs/20180409/TIMER.jpg)
网站概要：![](http://www.ynxnw.top/static/imgs/20180406/outline.png)
个人中心：![](http://www.ynxnw.top/static/imgs/20180406/user.jpg)
发布文章：![](http://www.ynxnw.top/static/imgs/20180406/write.png)
编辑文章列表：![](http://www.ynxnw.top/static/imgs/20180406/edit.png)
评论管理：![](http://www.ynxnw.top/static/imgs/20180406/comment.png)
会员管理：![](http://www.ynxnw.top/static/imgs/20180406/member.png)
图片管理：![](http://www.ynxnw.top/static/imgs/20180406/imgs.png)
其他设置：![](http://www.ynxnw.top/static/imgs/20180406/otherseting.png)
实验室管理：![](http://www.ynxnw.top/static/imgs/20180406/lab.png)


引用：
[vue-simplemde](https://github.com/gamegos/php-jwt)
[PHP-JWT](https://packagist.org/packages/firebase/php-jwt)
sendMail

参考文章：
[Vue.js实现文章评论和回复评论功能](https://blog.csdn.net/weixin_35987513/article/details/53748707)


测试账号：zhonghuatuzi@163.com
密码：zhonghuatuzi
