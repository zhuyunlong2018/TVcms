/*
SQLyog Professional v12.5.0 (64 bit)
MySQL - 5.7.18 : Database - tvcms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tvcms` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `tvcms`;

/*Table structure for table `tv_about` */

DROP TABLE IF EXISTS `tv_about`;

CREATE TABLE `tv_about` (
  `about_id` int(11) NOT NULL AUTO_INCREMENT,
  `about_content` text CHARACTER SET utf8 COMMENT 'about内容',
  `user_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`about_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_about` */

insert  into `tv_about`(`about_id`,`about_content`,`user_id`,`create_time`,`update_time`,`delete_time`) values 
(1,'### 关于本站：\n网站名称： 边泉小栈；\n		建站时间： 2018-01-23；\n		网站性质： 以个人生活随笔为主，记录学习技术为辅的博客管理展示页面；\n			\n记录点：\n			2018-01-23，经过几天准备，最终选用了景安的免费虚拟主机，网站程序采用typecho，主题默认；\n			购买二手域名：www.ynxnw.top ,花费￥20；\n			2018-04-01，将网站程序typecho删除，上传自己开发的边泉个人博客系统，技术栈[PHP+MySQL+VUE全家桶]；',1,NULL,NULL,NULL);

/*Table structure for table `tv_admin` */

DROP TABLE IF EXISTS `tv_admin`;

CREATE TABLE `tv_admin` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `admin_name` varchar(255) DEFAULT NULL COMMENT '管理员名称',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '关联用户名',
  `admin_status` int(1) DEFAULT '0' COMMENT '管理员状态',
  PRIMARY KEY (`admin_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_admin` */

insert  into `tv_admin`(`admin_id`,`admin_name`,`create_time`,`update_time`,`delete_time`,`user_id`,`admin_status`) values 
(1,'超级管理员',NULL,NULL,NULL,1,1),
(4,'测试管理员',NULL,NULL,NULL,2,0);

/*Table structure for table `tv_admin_role` */

DROP TABLE IF EXISTS `tv_admin_role`;

CREATE TABLE `tv_admin_role` (
  `admin_role_id` int(6) NOT NULL AUTO_INCREMENT COMMENT '管理员角色关联ID',
  `admin_id` int(6) DEFAULT NULL COMMENT '管理员id',
  `role_id` int(6) DEFAULT NULL COMMENT '角色ID',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`admin_role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_admin_role` */

insert  into `tv_admin_role`(`admin_role_id`,`admin_id`,`role_id`,`create_time`,`update_time`,`delete_time`) values 
(6,1,1,NULL,NULL,NULL),
(10,4,6,NULL,NULL,NULL);

/*Table structure for table `tv_api` */

DROP TABLE IF EXISTS `tv_api`;

CREATE TABLE `tv_api` (
  `api_id` int(6) NOT NULL AUTO_INCREMENT COMMENT 'api的ID',
  `api_name` varchar(255) DEFAULT NULL COMMENT 'api描述',
  `api_path` varchar(255) DEFAULT NULL COMMENT 'api路劲',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  `api_type` int(1) DEFAULT '0' COMMENT 'api类型，0未注册，1登录白名单，2token白名单，3权限api',
  `method` varchar(255) DEFAULT NULL COMMENT '请求类型',
  `params` varchar(512) DEFAULT NULL COMMENT '参数',
  PRIMARY KEY (`api_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_api` */

insert  into `tv_api`(`api_id`,`api_name`,`api_path`,`create_time`,`update_time`,`delete_time`,`api_type`,`method`,`params`) values 
(1,'会员管理1','/api/user1',NULL,NULL,NULL,1,NULL,NULL),
(2,'会员调整','/api/user2',NULL,NULL,NULL,1,NULL,NULL),
(5,'测试用接口数据','index/index/hello',NULL,NULL,NULL,2,NULL,NULL),
(9,'获取管理员列表','adminapi/admin/getlist',NULL,NULL,NULL,3,NULL,NULL),
(17,'退出登录接口','adminapi/admin/logout',NULL,NULL,NULL,1,NULL,NULL),
(18,'获取后台用户对应权限菜单路由','adminapi/menu/getrouter',NULL,NULL,NULL,2,NULL,NULL),
(19,'通过名称查找一个角色','adminapi/role/findbyname',NULL,NULL,NULL,3,NULL,NULL),
(20,'获取角色列表','adminapi/role/getlist',NULL,NULL,NULL,3,NULL,NULL),
(21,'获取系统存在的所有菜单','adminapi/menu/getmenu',NULL,NULL,NULL,3,NULL,NULL),
(22,'更新指定角色信息','adminapi/role/update',NULL,NULL,NULL,3,NULL,NULL),
(23,'根据条件获取一名用户信息','adminapi/user/getone',NULL,NULL,NULL,3,NULL,NULL),
(24,'更新管理员信息','adminapi/admin/update',NULL,NULL,NULL,3,NULL,NULL),
(25,'创建管理员','adminapi/admin/create',NULL,NULL,NULL,3,NULL,NULL),
(26,'删除管理员','adminapi/admin/delete',NULL,NULL,NULL,3,NULL,NULL),
(27,'获取系统菜单列表','adminapi/menu/getlist',NULL,NULL,NULL,3,NULL,NULL),
(28,'根据类型获取api列表','adminapi/api/getlist',NULL,NULL,NULL,3,NULL,NULL),
(29,'对指定api和菜单权限关联进行解绑','adminapi/menu/unlinkapi',NULL,NULL,NULL,3,NULL,NULL),
(30,'测试用接口描述','test/index/index',NULL,NULL,NULL,1,NULL,NULL),
(31,'根据id修改api的类型','adminapi/api/changetype',NULL,NULL,NULL,3,NULL,NULL),
(32,'后台登录接口','adminapi/admin/login',NULL,NULL,NULL,1,NULL,NULL),
(40,'将指定api权限关联到对应菜单','adminapi/menu/linkapi',NULL,NULL,NULL,3,NULL,NULL),
(41,'删除指定角色','adminapi/role/delete',NULL,NULL,NULL,3,NULL,NULL),
(42,'创建新角色','adminapi/role/create',NULL,NULL,NULL,3,NULL,NULL),
(43,'后台登录接口','admin/admin/login','2019-03-01 21:30:24','2019-03-01 21:30:24',NULL,1,'POST','[{\"name\":\"username\"},{\"name\":\"password\"}]'),
(44,'获取后台用户对应权限菜单路由','admin/menu/getrouter','2019-03-01 21:30:24','2019-03-01 21:30:24',NULL,2,'GET','[]'),
(45,'获取网站统计信息','admin/webdata/getdata','2019-03-01 21:30:25','2019-03-01 21:30:25',NULL,1,'GET','[]'),
(46,'获取系统菜单列表','admin/menu/getlist','2019-03-01 21:30:37','2019-03-01 21:30:37',NULL,3,'GET','[{\"name\":\"name\"},{\"name\":\"page\"},{\"name\":\"limit\"},{\"name\":\"order\"},{\"name\":\"sort\"}]'),
(47,'根据类型获取API列表','admin/api/getlist','2019-03-01 21:30:38','2019-03-01 21:30:38',NULL,2,'GET','[{\"name\":\"type\"}]'),
(48,NULL,'admin/menu/update','2019-03-02 15:17:06','2019-03-02 15:17:06',NULL,NULL,NULL,'[]'),
(49,'获取管理员列表','admin/admin/getlist','2019-03-02 16:21:46','2019-03-02 16:21:46',NULL,3,'GET','[{\"name\":\"name\"},{\"name\":\"page\"},{\"name\":\"limit\"},{\"name\":\"order\"},{\"name\":\"sort\"}]'),
(50,NULL,'admin/menu/create','2019-03-02 16:23:28','2019-03-02 16:23:28',NULL,NULL,NULL,'[{\"name\":\"father_id\"},{\"name\":\"title\"},{\"name\":\"path\"},{\"name\":\"name\"},{\"name\":\"component\"},{\"name\":\"sort\"},{\"name\":\"icon\"},{\"name\":\"api\"}]'),
(51,'获取用户列表','admin/user/getlist','2019-03-02 16:56:47','2019-03-02 16:56:47',NULL,3,'GET','[]'),
(52,'获取角色列表','admin/role/getlist','2019-03-02 16:56:59','2019-03-02 16:56:59',NULL,2,'GET','[{\"name\":\"name\"},{\"name\":\"page\"},{\"name\":\"limit\"},{\"name\":\"order\"},{\"name\":\"sort\"}]'),
(53,'获取系统存在的所有菜单','admin/menu/getmenu','2019-03-02 16:57:00','2019-03-02 16:57:00',NULL,2,'GET','[]'),
(54,NULL,'blog/article/gettitlelistbypage','2019-03-02 17:12:21','2019-03-02 17:12:21',NULL,NULL,NULL,'[{\"name\":\"title\"},{\"name\":\"author\"},{\"name\":\"tag\"},{\"name\":\"page\"},{\"name\":\"limit\"},{\"name\":\"sort\"},{\"name\":\"order\"}]'),
(55,NULL,'blog/neighbors/getall','2019-03-02 17:12:22','2019-03-02 17:12:22',NULL,NULL,NULL,'[]');

/*Table structure for table `tv_article` */

DROP TABLE IF EXISTS `tv_article`;

CREATE TABLE `tv_article` (
  `a_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章自增ID',
  `a_title` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '文章标题',
  `a_content` text CHARACTER SET utf8 NOT NULL COMMENT '内容',
  `create_time` timestamp NULL DEFAULT NULL COMMENT '时间',
  `a_img` text CHARACTER SET utf8 NOT NULL COMMENT '背景图',
  `published` int(6) NOT NULL DEFAULT '0' COMMENT '是否公开',
  `comment_num` int(6) NOT NULL DEFAULT '0' COMMENT '评论数',
  `praise_num` int(6) NOT NULL DEFAULT '0' COMMENT '点赞数',
  `viewer_num` int(6) DEFAULT '0' COMMENT '阅读量',
  `user_id` int(6) DEFAULT NULL COMMENT '用户id',
  `tag_id` int(6) DEFAULT NULL COMMENT '文章标签id',
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  `status` int(1) DEFAULT '0' COMMENT '审核状态',
  `outline` text CHARACTER SET utf8 COMMENT '概要',
  PRIMARY KEY (`a_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_article` */

insert  into `tv_article`(`a_id`,`a_title`,`a_content`,`create_time`,`a_img`,`published`,`comment_num`,`praise_num`,`viewer_num`,`user_id`,`tag_id`,`update_time`,`delete_time`,`status`,`outline`) values 
(1,'hello blog！hello 边泉！','\n**前言**\n		终于还是建了个博客站，简陋异常，暂时还用着typecho的默认主题，后面应该会随便弄个第三方主题吧，有时间之后，前端页面还是希望自己设计编写，然后就是再有时间话，打算自己弄个后台博客系统，接下来继续摸索PHP、js等，这个博客网站注定众生埋没在互联网的大浪之中，本身作为一个记录生活为主的个人性质博客，基本也只有作者本人是受众用户了。\n\n**边泉**\n		边泉，即边缘之泉，边为边缘、偏僻，泉为地点，又有偏僻小泉的意思，博主所在为沿海某个小城（泉州）里的落后村子，并且基本没有远门过，边泉之意，便也是如此了，默默无闻而又毫无星辉。\n		这个博客网站及会记录个人生活琐事及一些技术文章，当然首要目的是作为后续个人作品的一个载体。\n\n**关于**\n		关于博主，前途纠结中……\n		\n![](http://www.ynxnw.top/static/imgs/20180401/tuzki_2013_avatar_01.jpg)','2018-01-23 00:00:00','../../static/imgs/20180406/hellobianquan.jpg',1,2,26,0,1,1,NULL,NULL,1,NULL),
(2,'《我是江小白》观后感','昨天刚看完，比较好看的文艺青春国漫，3D渲染成2D的画面挺舒服的，有时间完善本篇观后感。\n没看过的可以到这里看看：[去观看](https://www.bilibili.com/bangumi/media/md6064/?spm_id_from=666.10.bangumi_detail.2)\n**画风**\n相比国产其他3D动漫，可以说这种画风让我感觉非常清新，同时没有国内大部分2D动漫那种贫穷的感觉。\n许多人在看国漫的时候，除了一个劲的吐槽画质贫穷，剧情垃圾之外，更多的是直接刷一个开口跪，尬聊，不过看这部动漫却感觉十分舒适，对话听起来很不错，至少我是这样认为的，并且对于一些观众说的抽帧看起来类似幻灯片，我却没有感觉到，也许因为我只是个普通的观众，而不是什么动漫大师之类的吧。\n**音乐**\n我是对于音律一窍不通的人，我甚至是不清楚这部动漫里有几首曲子，叫做什么名字，但好的乐曲是可以让人引起共鸣的，对于音乐细胞极具匮乏的我来说挺着歌曲，随着画面一步一步深入剧情中还是一种很好的消磨时间的方法，至少有了这种音乐的调味，观看中并不会察觉到很多人提出的缺点。\n\n**剧情**\n待补充\n**人物**\n待补充\n\n','2018-01-25 00:00:00','../../static/imgs/20180402/jiangxiaobai.jpg',1,0,7,0,1,2,'2019-02-21 16:35:46','2019-02-21 16:35:46',1,NULL),
(3,'开始上班，春假总结','		今天开始上班了，半个月的时间一晃而过，平庸而无聊，颓废又低落，要开始新的一年工作了，重新奋斗吧。\n		总体来说，年纪越大，这节日也过得越索然无味了。\n		在17年的新年过去后，我也终于提出了辞职的意向，最终离开了从毕业开始待了两年的岗位，如今18年开始了，回到工作岗位中却没有了之前的感觉，很早就说要辞职了。\n		有太多的事情未了，有许多的想法停滞，短短几日一晃而过也倍感时光匆匆，但有时候须臾刹那又感觉度日维艰，总之人生不如意十之八九，大家爱咋过不爱咋过都得继续过下去，我们就是这样一种喝惯了白开水的人，斯文惯了偶尔豪饮一下，然后腹诽着这白大水淡得略微苦涩。\n		写的就是咬文嚼字，展示一下乱七八糟的文笔。\n\n\n','2018-02-18 00:00:00','../../static/imgs/20180401/tuzki_2013_avatar_01.jpg',0,0,0,0,1,1,NULL,NULL,1,NULL),
(4,'axios发送图片给PHP接收的坑','> 最近在做一个博客页面，因为要实现图片批量上传前预览，上传后返回图片展示，图片采用base64转码发送，多张图片之间插入一个自定义键值，在PHP后台拆分；\n> \n> 目前遇到的问题是，发送给后台的只有图片本身的base64码，所以在循环存储图片时，使用time()来命名图片，但是当图片后缀名一样时，也就是图片的名称为年月日.后缀，如1521717711.jpg，但是如果图片上传速度过快，会导致在time()数值内完成两张及以上的图片上传，这样就导致多张图片名称一致，存储的前一张图片被后一张图片覆盖。\n```\n/*添加一张或多张图片*/\nfunction updata_imgs($imgs) {\n//按特定字符串分解传递的参数为数组，移除最后一个空子项\n    $img = explode(\'updata_imgs\',$imgs,-1);\n    //var_dump($img);\n    if($img){\n        $i = 0;//记录图片数量\n        foreach($img as $v){\n            //移除编码前面可能存在的逗号\n            $base64_img =ltrim(trim($v), \",\") ;\n            //var_dump($base64_img);\n            //匹配出图片的格式\n            if (preg_match(\'/^(data:\\s*image\\/(\\w+);base64,)/\', \n$base64_img, $result)) {\n            //var_dump($result[1]);\n            $type = $result[2];//取出图片后缀\n            //var_dump($type);\n            $new_file = \"./bianquan/static/imgs/\".date(\'Ymd\',time\n()).\"/\";\n                if(!file_exists($new_file)) {\n                //检查是否有该文件夹，如果没有就创建，并给予最高权限\n                mkdir($new_file, 0700);\n                }\n                $new_file = $new_file.time().\".{$type}\";\n                if (file_put_contents($new_file, base64_decode\n(str_replace($result[1], \'\', $base64_img)))){\n   //返回图片的地址\n   $images[$i] = \"../../\" . ltrim($new_file, \n\"./bianquan\");\n                    //$images[$i] = $new_file;\n                    $i++;\n                }else{\n                echo \'新文件保存失败\';\n                }\n            }\n        }\n        //var_dump($images);\n        echo json_encode($images,JSON_UNESCAPED_UNICODE);\n    }\n}\n```\n\n改善方法，在post图片base64编码数组的同时，post另外一个图片名称的数组，将图片循环命名为原名称。\n\n接着遇到了有些图片无法正常显示，发现文件名为中文时，PHP存储的文件名为乱码。\naxios发送的中文字符串为utf-8格式，在写入文件时，先将图片名称转为GB2312，写入图片中文名正确，返回文件路劲名称时使用原有格式。\n在本地服务内运行没问题，不过上传到虚拟主机上时，页面展示的图片从服务端获取时，图片请求地址为URLencode()后地址，如图片：结构图.jpg，获取图片的URL为%e7%bb%93%e6%9e%84%e5%9b%be.jbp;服务端返回却是未找到ç»„å›¾.jpg；\n即用中文命名的图片便出现404错误，发现服务端范围图片地址为乱码，暂时不清楚如何修改虚拟机读取中文字符为GB2312。\n','2018-03-23 00:00:00','../../static/imgs/20180406/luanma.jpg',1,1,0,0,1,4,NULL,NULL,1,NULL),
(5,'记录一些博客开发碰到的问题','有空补充……\n\n当前台用json格式数据发送给后台接收时，由于内容里有回车字符，后台从数据库中获取出来后发给前台时出现json格式错误，无法解析。\n\n','2018-03-07 00:00:00','../../static/imgs/20180407/issue.jpg',1,0,5,0,1,3,NULL,NULL,1,NULL),
(6,'关于登录验证相关问题','这几天做登录、注册标记状态功能，实在是弄得头晕脑胀的；\n方案一：采用传统的cookie-session，但是最终放弃了，因为vue和PHP开发环境不同，vue运行在node环境：localhost:8080，而PHP运行在warm的localhost:80，这样跨域请求让服务端发送的response的set-cookie无法写入浏览器，因此在第一次登陆过后，前端继续访问需要登陆权限的操作时，在服务端验证登陆这一块无法通过，查看了下，发现登陆成功后，服务端的$_SESSION 这个变量存储第一次访问可以，第二次就失败了。暂时先记录下来，期待后面解决；\n方案二：使用token，搜索了一下发现应该用jwt（Json Web Token）来比较好；\n具体实施过程就略过，PHP引入[php-jwt](https://github.com/firebase/php-jwt)，将需要的用户信息存入jwt的B部分，接下来设置axios请求头添加这个token，需要权限时验证这个token的有效期及权限即可。','2018-03-16 00:00:00','../../static/imgs/20180406/denglu.jpg',1,3,27,0,1,4,NULL,NULL,1,NULL),
(7,'关于vue的函数传参及字符串操作','\n原本封装一个公用函数，就是通过一个公用的方法和字符串拼接来操作data中的数据，这样可以省去重复编写同样代码，不过经过下面代码的验证，发现行不通，原本想了很久也不清楚，明明拼接字符串后赋值给变量，这个变量全等于vue的data中数据，但是改变了变量，data中的数据却根本没有变化。\n不过接着猜发现，新增的这个变量只是一个复制品，而不是指向data中相应数据的内存地址，因此两个虽然值全等，却互不影响。\n```\nexport default {\n    data() {\n      return {\n       data:true\n      };\n    },\n    methods: {\n       change_data:function(){\n        let data = \'data\';\n        this.slide(data);\n       },\n      slide:function(params) {\n        let _data = \'this.\'+params;\n        let data = eval(_data);\n        console.log(data === this.data)   //返回true\n          data = false;\n           console.log(data);         //返回false\n           console.log(this.data);   //返回true\n          console.log(data === this.data)   //返回false\n      }\n			```','2018-03-20 00:00:00','../../static/imgs/20180406/what.jpg',1,3,1,0,1,3,NULL,NULL,1,NULL),
(8,'4月1号，边泉博客系统终于上线测试了','**前言**：\n自从萌发了要做一个博客文章管理系统后，便在工作空闲时间不短的码代码，上网搜索一些疑问，可喜可贺，经过快两个月的努力，终于赶在了4月的第一天将这个系统上传到了虚拟主机中，当然还有很多的问题没完成，这个只能当成一个测试版本。\n\n**项目简介**：\n> 名称：边泉博客管理平台；\n> 前端：Vue+Vuex+Vue-Router+axios；\n> 后端：PHP+MySQL；\n> 兼容性：ie9+，移动端，PC端；\n\n**主要功能**：\n> * 用户登录、注册；\n* 用户评论、游客评论；\n* 评论回复邮件提醒；\n* 页面文章标签检索展示；\n* 页面文章时间轴排序；\n* 页面项目展示；\n* 后台文章增加、编辑、删除、下架管理；\n* 后台评论屏蔽、解封管理；\n* 后台图片上传、删除功能；\n* 后台标签新增、删除功能；\n* 后台友情链接新增、删除功能；\n* 后台实验室项目新增、下架功能；\n\n**目前存在问题**： \n1.  页面响应式布局方面，还有一些元素在特殊窗口尺寸中显示不协调；\n2.  虽然开放注册功能，但未加入验证码、邮箱验证功能，并且关闭普通会员文章操作权限，普通会员投稿默认为不发布，并且无法编辑状态，需管理员发布和编辑。\n3.  评论被回复邮件通知还是半成品；\n4.  搜索功能未完成；\n\n\n**文件目录**\n```\n├──node_modules// 项目依赖的模块    \n├── src// 源码目录 \n│ ├──  assets// 资源目录 \n│ ├── components// vue公共组件\n│ │ ├── header.vue// 前台头部组件\n│ │ ├── footer.vue// 前台底部组件\n│ │ ├── aside.vue// 前台侧边栏组件\n│ │ ├── login.vue// 前台登录、注册页面组件\n│ │ ├── articleList.vue// 前台文章列表页面组件\n│ │ ├── msgborder.vue// 前台留言板页面组件\n│ │ ├── project.vue// 前台实验室页面组件\n│ │ ├── timer.vue// 前台时间轴页面组件\n│ │ ├── about.vue// 前台关于页面组件\n│ │ ├── comment.vue// 前台评论区页面组件\n│ │ ├── components.vue// 通用alert、提示框、前台搜索框组件\n│ │ ├── all_images.vue// 后台所有图片弹框组件\n│ │ ├── admin_aside.vue// 后台侧边导航栏组件\n│ │ ├── admin_header.vue// 后台头部组件\n│ │ ├── outline.vue// 后台网站概要页面组件\n│ │ ├── user.vue// 后台个人中心页面组件\n│ │ ├── write.vue// 后台发布文章页面组件\n│ │ ├── editor.vue// 后台编辑文章页面组件\n│ │ ├── editor_comment.vue// 后台评论管理页面组件\n│ │ ├── menber_list.vue// 后台会员管理页面组件\n│ │ ├── imgs_list.vue// 后台图片管理页面组件\n│ │ ├── other_seting.vue// 后台其他设置页面组件\n│ │ └── lab.vue// 后台实验室页面组件\n│ ├──views// 前后台根组件\n│ │ ├── admin.vue// 后台根组件\n│ │ └── home.vue// 前台根组件\n│ ├── App.vue// 页面入口文件（根组件）\n│ ├── routes.js// 页面路由操作文件\n│ ├── store.js// 页面数据仓库文件\n│ └── main.js// 程序入口文件（入口js文件）\n├── vendor// php包文件夹，含jwt和sendMail\n├── bianquan.sql// 数据库语句\n├── bianquan.php// 后台php主体\n├── static// 静态文件，比如一些图片，json数据等\n├── .babelrc// ES6语法编译配置\n├── .editorconfig// 定义代码格式\n├── .gitignore// git上传需要忽略的文件格式\n├── index.html// 入口页面\n├── package.json// 项目基本信息\n├── README.md// 项目说明\n```\n**组件结构图：**\n![](http://www.ynxnw.top/static/imgs/20180405/jiegoutu.jpg)\n**主要页面展示**：\n首页：![](http://www.ynxnw.top/static/imgs/20180409/HOME.jpg)\n文章详情：![](http://www.ynxnw.top/static/imgs/20180409/article.jpg)\n留言板：![](http://www.ynxnw.top/static/imgs/20180409/MESSAGE.jpg)\n实验室：![](http://www.ynxnw.top/static/imgs/20180409/PROJECT.jpg)\n时间轴：![](http://www.ynxnw.top/static/imgs/20180409/SEARCH.jpg)\n搜索：![](http://www.ynxnw.top/static/imgs/20180409/TIMER.jpg)\n网站概要：![](http://www.ynxnw.top/static/imgs/20180406/outline.png)\n个人中心：![](http://www.ynxnw.top/static/imgs/20180406/user.jpg)\n发布文章：![](http://www.ynxnw.top/static/imgs/20180406/write.png)\n编辑文章列表：![](http://www.ynxnw.top/static/imgs/20180406/edit.png)\n评论管理：![](http://www.ynxnw.top/static/imgs/20180406/comment.png)\n会员管理：![](http://www.ynxnw.top/static/imgs/20180406/member.png)\n图片管理：![](http://www.ynxnw.top/static/imgs/20180406/imgs.png)\n其他设置：![](http://www.ynxnw.top/static/imgs/20180406/otherseting.png)\n实验室管理：![](http://www.ynxnw.top/static/imgs/20180406/lab.png)\n\n**引用：**\n[vue-simplemde](https://github.com/gamegos/php-jwt)\n[PHP-JWT](https://packagist.org/packages/firebase/php-jwt)\nsendMail\n\n\n**参考文章：**\n[Vue.js实现文章评论和回复评论功能](https://blog.csdn.net/weixin_35987513/article/details/53748707)\n\n**源码**\n[Github](https://github.com/920200256/bianquan-blog)\n\n**测试账号：**（也可自己注册）\n账号：zhonghuatuzi@163.com\n密码：zhonghuatuzi\n','2018-04-01 00:00:00','../../static/imgs/20180406/bianquan.jpg',1,1,6,0,1,3,NULL,NULL,1,NULL),
(9,'简便Markdown编辑器vue-simplemde使用问题','在做博客编辑页时使用了GitHub上的[vue-simplemde](http://https://github.com/F-loat/vue-simplemde)，其实还是遇到了一些问题的。\n**问题一**：输出HTML\nvue-simplemde提供了将内容转换为Markdown语法，输出HTML代码的方法，描述如下：\n```\n      // 一些有用的方法\n      this.$refs.markdownEditor.initialize() // init\n      this.simplemde.toTextArea()\n      this.simplemde.isPreviewActive() // returns boolean\n      this.simplemde.isSideBySideActive() // returns boolean\n      this.simplemde.isFullscreenActive() // returns boolean\n      this.simplemde.clearAutosavedValue() // no returned value\n      this.simplemde.markdown(this.content) // returns parsed html\n      this.simplemde.codemirror.refresh() // refresh codemirror\n```\n\n不过这个方法都挂在this.$refs.markdownEditor.simplemde下，也就是引入组件\n```<markdown-editor v-model=\"content\" ref=\"markdownEditor\"></markdown-editor>```\n后，当前页面才支持这些方法，其他地方并没有多余说明，这样的设计就让人觉得很奇怪，因为编写文章时应该是用Markdown语法书写没错，但总不能当场渲染文章内容为HTML代码然后存储到数据库中？所以在我认为中，应该是将Markdown语法的文章存入数据库中，然后在文章展示页面中取出格式为Markdown语法的文章，渲染为HTML代码导入到页面。\n通过这样的思路，我们要用到 this.simplemde.markdown(this.content)这个方法，就是在文章展示页中也插入一个markdown-editor编辑器，可以使隐藏掉，也可以是做成评论去，但这样就会暴露一个问题，在 vue页面初始化时执行this.simplemde.markdown(this.content)方法，将从后台获取的文章内容传入this.content，不过这一步后台返回数据时间肯定过慢，上面的Markdown()方法执行时，传入的this.content为空，此时会报错，解决的思路只能设定一个定时器或者computed方法判断this.content的值，成功后执行转换函数；\n不过这种方法有些邋遢，所以可以从源码入手，Markdown()方法不一定需要用this.$refs.markdownEditor.simplemde来获得，在Vuex中引入组件：\n```import simplemde from \'simplemde\';```\n即可在simplemde原型中找到simplemde.prototype.markdown()方法，因此最终可以通过axios请求成功后回调执行simplemde.prototype.markdown()的方法来获取文章HTML代码。\n\n**问题二：**编辑器未推出全屏状态下进行路由跳转，页面滚动将失效\nvue-simplemde的全屏编辑模式默认浏览器全屏都为编辑区域，不过因为我的博客布局，所以修改了全屏下为页面右侧全屏，这样就暴露出了一个bug，右侧全屏的情况下，在进行路由跳转时，如从/admin到/home下，主页的滚动条失效，无法滚动。\n原因应该是组件内部定义了如下代码来阻止全屏状态下window滚动：\n```\n//Prevent scrolling on body during fullscreen active\n	if(cm.getOption(\"fullScreen\")) {\n		saved_overflow = document.body.style.overflow;\n		document.body.style.overflow = \"hidden\";\n	} else {\n		document.body.style.overflow = saved_overflow;\n		}\n```\n当未退出全屏状态进行路由跳转，页面的document.body.style.overflow = \"hidden\";因此直接将上面的代码注释，加入下方代码，页面跳转后依旧可以滚动：\n	```document.body.style.overflow = \'scroll\';```','2018-04-11 00:00:00','../../static/imgs/20180406/denglu.jpg',1,1,23,0,1,3,NULL,NULL,1,NULL),
(10,'辗转——学而思——新航线','前言：标题翻译（我，辞职了！换行找工作……）。\n**辗转：**\n &emsp;&emsp; 昨日是工作最后一天，自今日起恢复无业游民身份。\n  &emsp;&emsp; 距离大学毕业已有三年了，在工厂也正好待了三年之久，时光如梭，恍恍惚惚间，如是幻影掠过，如今回首却又难忆多少画面。\n  &emsp;&emsp; 思来想去，便也打算写篇文章记录，奈何笔墨斜浅，行文潦草，句中泛着酸味，字里透露矫情，想来此中说辞难以启齿，留下些许篇章以点缀后来生活。\n &emsp;&emsp; 从读大学起，我便对自己的未来有了一个初步的雏形，虽然以前对于兴趣总是三心二意，这个也感兴趣，那个也感兴趣，这个也没学好，那个也学到一半放弃，但唯独这个专业我没有放弃。\n &emsp;&emsp; 材料成型与控制工程，听起来完全摸不着头脑？换个说法吧，那就是铸造、模具、焊接，一听起来这就是个苦逼的夕阳产业了，早十年前的话模具设计是非常火的，甚至路边会有模具设计、CAD制图培训等招牌，但现在没有人看好这个行业。\n &emsp;&emsp;  大学的四年时光并没有让我有了什么石破天惊的想法，忐忑的拿着一份毫无特色的简历成功进入了离学校不远的一家有着20多年历史的中大型台企，主营卫浴产品代工，员工近万人。\n &emsp;&emsp;  我在里面干起了产品工程师，俗称项目工程师、项目负责人，负责新品研发过程的一切琐事，包括一些结构图纸绘制和项目进度管控和追踪、客户交流等等。\n这样一干就是两年的时间，不得不说企业大些还是挺好的，基本上加班合理，薪资一般，晋升制度完善且周期短，定期培训、活动等等，工作上分工较细，逻辑清晰，事务确切落实到各负责人手中，而我的第二家公司就显得毫无章法了。\n &emsp;&emsp;  这是一家经营了近20年的家具工厂，有自己的品牌，但更多的是代工，规模只是接近千人，可以说各方面都不是很出色，他们也是沉淀了许久才刚要组建研发部门，筹备公司所有资料准备上市。\n &emsp;&emsp;  当然，我之所以选择了这家公司，还有一点是这是在老家，距离家里只有5公里路程，为此婉拒了另外一家在国内较为出名的卫浴集团，但这个选择并没有想象中的那么好。\n &emsp;&emsp;  我被以设计师的身份招入，所有人的围绕着公司上市后会是一种怎样场景的畅想中努力工作，公司上市的一个重要指标便是账目清晰、资料完整，我也是之后才知道这便是研发部成立的目的了，引入一套十分完善的企业管理系统，我的工作便成了主职研发部资料创建、整理的一员了，而设计绘图只是辅助职务。\n &emsp;&emsp;  这样的工作持续了大半年，那是一种十分枯燥的体验，企业管理系统除了数据外就是业务，一个企业在运行了近二十年后才打算将资料转移到这个系统中，其中的数据量是非常庞大的，这对于我自身意愿来说是非常不友好的，常年累计的产品库中资料缺失非常严重，生产需求和业务需求、技术需求、客户需求、供应需求、管理需求错综复杂，大半年的时光里，我的经历已经甚少放在了绘图上面，软件都有些生疏了。\n &emsp;&emsp;  也正是接近年末之后开始清闲下来，虽然早有另谋出路的想法，但我也这一年中不断的思索自己接下来的路到底要怎么走，泉州是一个非常尴尬的地方，或者说是这个福建省就是如此，制造业出身的我，原本刚毕业进入一家大型卫浴企业，若是第二家直接到南安水暖城去发展，或许现在成就不错，卫浴终究逃脱不了厦门和南安这两个地方，若是留在其他地方，便也如我现在一般，进入一些电子产品、家具产品的工厂，这其中的机遇与深坑还是不好衡量。\n &emsp;&emsp;  自17年11月中旬起，我接触到了另外一扇门，通往另外一条道路。\n昨日之办公桌：\n![](http://www.ynxnw.top/static/imgs/20180418/dest.jpg)\n**学而思**\n\n &emsp;&emsp;第一次关注IT类培训的还是在大四的时候，那时候对于IT只有一个概念，就是搞软件的，并且还有一些羡慕和不爽，因为我学的是机械类专业，这是一个被冠以夕阳产业的名号，不管是前途还是钱途都让人纠结。\n &emsp;&emsp;而IT行业却不一样，同样一所学校，IT专业毕业生的薪资和机械专业毕业生的薪资不是一个水准的，大家选专业前的分数差不多，这或许就是如我一般某些庸人会对于IT行业不舒服的原因吧。\n &emsp;&emsp;我在当时之所以关注过IT培训并非是我有意向去转行，只因为班里的某学霸在我们四处奔波找工作时，却不动如山的去培训安卓和ios，这对于我们这批半学渣来说是一件非常具有冲击性的事件，为什么呢？因为学霸专业成绩好啊，学霸被导师关照啊，和导师做过项目啊，就这样背弃了这个行业？\n &emsp;&emsp;询问一下，培训费2万多元，买了一台mac快1万，近乎3万元对于我这个还未踏入社会的学渣来说也是一个天价了，难以想象专业成绩这么好的学霸会以这样一种魄力转业。\n &emsp;&emsp;“我是不可能转业的！”这是我当时的想法，不说我没有那么多的钱来培训，更多的是我没有太过长远的目光，我当时认为，制造业是国家根本，不管夕阳还是朝阳，反正是不会有日落的时刻的，这话也没错，实业兴国，物质基础支撑社会框架，我也就这样踏入了工厂的大门。\n &emsp;&emsp;工厂的薪资很低，非重点本科毕业生批发价3k，但它的体量非常庞大，一家大型工厂员工近万，光研发技术部门就有四五人，整个办公系统超过千人，这种规模在闽南一带并不多，我觉得只要在里面好好的做项目积累经验即可。\n &emsp;&emsp;在工厂研发部门里的工作性质并没有太多差异性，项目以一定周期循环，立项、报价、评审、出图、跟踪模具进度，跟踪样品进度、记录问题，设计变更、试装、测试、客户确认、试产、量产等等一系列不断重复。\n\n &emsp;&emsp;工厂一年半过去后，大学的同学再度聚会，这时刻我再次听到了IT培训这个词，但依旧不甚了解，原本工厂里的同学，有一两个回到了学校考研，还有五六个同学辞职了去培训IT。\n &emsp;&emsp;也许工厂真的是一个熬人的地方，也难怪这么多人要逃离这里，即使我们一直被人告知，软件行业已经饱和了，软件行业在走下坡路了，但城外的人如果不进城，就算是城里人再如何说他们也不会听的。\n  &emsp;&emsp;一次放假结束后准备返回工作岗位，父亲忽然对我说：“你如果想去干你之前说的那个，也可以去报名学习吧。”，我莫名其妙的望着他，然后又想起了之前跟他说过的几个同学报名培训IT去了，也许我当时的语气有那么一丝羡慕的样子吧，但我终究不可能答应的，我有些倔的摇头，难道我会舍弃自己读了四年的专业？舍弃自己在制造业中积累了一两年的经验？我那时觉得这是不可能的。\n &emsp;&emsp;上面都是辗转前奏，后话自然是如今17年末到18年初了，谁也无法预料到事态会发展到何处，正是因为一年的ERP操作让我对于原本的绘图技术有了一丝懈怠，偶然间触碰到了前端开发，我之前甚至分不清前端、后端，不知道JavaScript是不是Java的全称，但我就是心中有一种冲劲，想要一次尝试的机会。\n  &emsp;&emsp;我在工作之余开始了自学前端生涯，谁也不知道我在干嘛，我没有告诉任何人我在学习什么，学了一个多月后，我微信了以前的同学，相互告诉了近况，他有些迟疑的问我，是否应该去培训，这个我也可以理解，毕竟身边的同学都是培训转行的，像我这样静悄悄的自个儿捣鼓，不报班，也不辞职，能有什么出息？\n&emsp;&emsp;现在辞职了，但我也没报班，只想去找工作，并非是我太过自信，觉得自己自学能力max，或者是看不起培训班。我是真佩服那些摒弃了自己大学专业转行的人，这意味着他今后不能靠专业证书说事，意味着他今后在学历上不占有任何优势。\n &emsp;&emsp;我自己在心里盘算了，所谓IT的火爆，就和当年的模具设计、结构设计一般，确实是在它们各自的黄金时期，但这仅仅是对于大城市来说，在泉州这里却并非如此，制造业中踏实从事技术岗位的，未来薪资也不会太低，而我如今的抉择，也仅仅是兴趣转变，而后有了学习新技术，而后有了新思路，也就想要走不同的道路了。\n **新航线**\n  &emsp;&emsp;新航线，新起点，也就意味着重回起点，重零开始。一个人有多少次重零开始？我不知道，三十而立，奔三路在脚下，重来机会不多就是了，随波逐流还是逆水行舟，难以言明那种更好，结果只能在这个过程之后才知。\n	胡乱写了一通，莫名其妙，待续……','2018-04-18 00:00:00','../../static/imgs/20180418/dest.jpg',1,5,55,0,1,1,NULL,NULL,1,NULL),
(11,'小记斐讯K3路由更换散热','**前言：**\n\n &emsp;&emsp;斐讯K3路由器入手已有大半年了，吃灰至今，主要也是家里路由已经够用了，不需要再多了，并且这东西还真是电老虎，超过10W的功率，估摸着有15W，这样光是一年家庭电费就要多上好几十，如果外面租房的话，那这路由器一年得吃上一百多元电费。\n \n![](http://www.ynxnw.top/static/imgs/20180421/K3.jpg)\n &emsp;&emsp;K3是一款十分好的产品，除了身为路由器中的性能怪兽外，就是因为它不需要购买成本，也正是因为如此，我在无需求的情况下入手了。但同样也有着一堆缺点，外观并不符合我个人的审美，在我眼里有点傻大粗的感觉，耗电大户，我的是三星的闪存，意味着不能刷梅林的系统，存在坏块，还有最最最重要的一点，就是它使用了十分劣质的导热垫，这也是有了本文的缘故。\n \n**过程：**\n\n &emsp;&emsp;拿出吃灰大半年的K3，看这教程刷了官改1.5版，使用还不错，只是万恶的宽带虽然升级带宽和光纤，但搭配的光猫没有管理员权限，在里面处理能设置无线外什么都不能弄，让自己路由器拨号的念头也不阻拦了，并且端口转发也没有，这也导致了我想讲K3打造成一台web服务器的愿望落空。\n\n &emsp;&emsp;刷机完后看了下，温度确实高，cpu温度达到70+度，无线芯片接近80度，但这都不是事，主要还是劣质硅脂垫渗油问题，我虽然第一次使用K3，在拆开后，电路板上依旧有一些油脂，这虽然不导电，但到底会吸附灰尘影响电路板。\n\n &emsp;&emsp;手残党的末日，居然把一根5G天线的接头弄断了，只能说大力出奇迹，K3的卡扣式设计让人拆机时很恼火。\n![](http://www.ynxnw.top/static/imgs/20180421/IMG_1976.JPG)\n拆机工具和原料：\n\n &emsp;&emsp;耗棒、镊子、小刀、螺丝刀、一瓶硅脂，当然由于上面手残弄断的天线接头，还需要电烙铁。\n![](http://www.ynxnw.top/static/imgs/20180421/32323.jpg)\n &emsp;&emsp;ipex线，看到一根一块钱还写着免邮费，觉得有些对不住卖家，就拍了3根，就用了1根来修复弄断接头的5G天线。\n\n &emsp;&emsp;20x20x1mm铜片10片，15x15x1mm铜片5片，30x30mm厚度分别为1mm、2mm、3mm的硅脂垫各六片（其实最后只用了6片3mm的和1片2mm的）\n![](http://www.ynxnw.top/static/imgs/20180421/IMG_1980.JPG)\n\n &emsp;&emsp;不得不说，K3的用料还是相当足，CPU和无线芯片都用上了一大块铝合金撒热片，就是不清楚为什么弄个那么差的散热垫，有一点就是cpu的散热居然夹在两块电路板中间，散热效果大打折扣，当然在路由器内部没有多少空气流通，确实是个大火炉。\n![](http://www.ynxnw.top/static/imgs/20180421/IMG_1975.JPG)\n &emsp;&emsp;过程没有多少记录，CPU和无线芯片采用铜片涂抹硅脂和屏蔽罩接触，其他芯片采用2mm硅脂和屏蔽罩接触。\n\n &emsp;&emsp;所有屏蔽罩采用铜片涂抹硅脂和铝合金散热片接触，无线面板背部采用3mm硅脂和铝合金散热接触。\n完工，重新装上。\n\n![](http://www.ynxnw.top/static/imgs/20180421/IMG_1983.JPG)\n\n &emsp;&emsp;中间有两片铝合金散热，若是添加风扇的话，散热效果应该不错。\n![](http://www.ynxnw.top/static/imgs/20180421/IMG_1984.JPG)\n &emsp;&emsp;装机，试运行，没问题。\n![](http://www.ynxnw.top/static/imgs/20180421/IMG_1982.JPG)\n\n**最后：**\n &emsp;&emsp;K3散热改造完毕，运行后CPU温度降低到60-65度，无线芯片降低到65-70度，虽然降温不是很大，不过解决了劣质硅脂垫漏油的问题，重新装入包装盒，继续吃灰，还是可喜可贺。\n ![](http://www.ynxnw.top/static/imgs/20180421/20180421130739.jpg)\n**还有后话：**\n\n &emsp;&emsp;K3的信号一直被人吹爆，不过我在实际使用中似乎也不见得有比K2P出众多少。\n不过对比起手头上的斐讯302m、newifi mini和极路由b50还是强上很多。\n &emsp;&emsp;来自对熊孩子的怨念，好好的给掰断了，信号大大减弱。\n![](http://www.ynxnw.top/static/imgs/20180421/IMG_1987.JPG)\n\n &emsp;&emsp;个人理想的路由器自然是K2P，信号好，处理器性能不错，只是少了USB让人惋惜，自己添加的话，还要钻孔，手头上也没这工具。\n','2018-04-21 00:00:00','../../static/imgs/20180421/K3.jpg',1,0,0,0,1,1,NULL,NULL,1,NULL),
(12,'斐讯h1移动硬盘开箱','前言：接触斐讯产品已经好多年了，这家名不见经传的路由小厂商一度以廉价实惠路由为产业，不过这家企业近两年画风一转，居然搞起了金融来，通过产品零元购的概念吸引客户投资理财，本人不是经济大牛，自然不知道他什么时候回跑路倒台，不过还是忍不住上车了。\n\n![](http://www.ynxnw.top/static/imgs/20180425/IMG_1990.JPG)\n &emsp;&emsp;斐讯H1便是最近推出的一款新理财产品，1t机械移动硬盘，市场价接近300元，主控为JMS576，相当于一个1t笔记本硬盘加上一个二十多块钱的硬盘盒，投资999元，可以说收益还是很丰盛的，前提是不跑路，不然999买个1t机械盘就搞笑了。\n\n &emsp;&emsp;外观中规中矩，拿到手后直接拆机，塑料盒子+亚克力面板，也不算太廉价，USB-typeC转接线，2.5寸7mm希捷1T硬盘，屏蔽纸、四个缓冲垫。\n![](http://www.ynxnw.top/static/imgs/20180425/IMG_1995.JPG)\n &emsp;&emsp;遗憾的是破旧的笔记本没有USB3接口（原因：穷！），无法测试下USB3的读写性能，直接和笔记本光驱位的500g希捷硬盘替换。\n &emsp;&emsp;左边为斐讯h1，右边为希捷9mm的500g硬盘\n![](http://www.ynxnw.top/static/imgs/20180425/IMG_1997.JPG)\n\n &emsp;&emsp;关于硬盘速度问题，我估摸着这台从大学陪伴我到现在的垃圾笔记本接口有问题，直接将硬盘放到光驱位，接口应该是SATA2，实在是降速太多，测试的500g数据读写都只有70多M，这个和几年前比起来还是差很多，虽然是5400转，但感觉也不应该这么低。\n\n![](http://www.ynxnw.top/static/imgs/20180425/20180425005323.png)\n\n &emsp;&emsp;接下来测试了新到的1T的读写情况，所实话十分的一般，读100多MB，写入接近90MB，其实这个写入数据应该不对。\n\n![](http://www.ynxnw.top/static/imgs/20180425/20180425194229.png)\n &emsp;&emsp;直接对1T硬盘拷贝一个4GB文件，持续写入速度在150MB左右，推断测试软件数据和实际应用有些不符。\n![](http://www.ynxnw.top/static/imgs/20180425/20180425205412.jpg)\n\n &emsp;&emsp;接下来直接将这个1T硬盘装入笔记本中，将笔记本的500g装入硬盘盒里，1T的移动硬盘直接变成500G的了。\n \n![](http://www.ynxnw.top/static/imgs/20180425/232323dsd.jpg)\n &emsp;&emsp;硬盘这东西，说实话也就是个数据仓库，既然是机械硬盘，也没指望数据多快，不过这破笔记本不知道还能坚持多久，上一张C盘测速，来自使用了5年的垃圾固态，当时三百出头买的国产120GB固态，闪存似乎是东芝的？但是跑分十分的垃圾，同型号当初其他人购买读取能达到400-500MB，写入速度也能达到200-300MB，也许真的是我笔记本垃圾，测试来也只能不到200MB的速度。\n\n &emsp;&emsp;如今用了五年了速度果然下降更多，好在4K性能和原来没差多少。\n![](http://www.ynxnw.top/static/imgs/20180425/20180424212848.png)\n','2018-04-25 00:00:00','../../static/imgs/20180425/IMG_1990.JPG',1,5,19,0,1,1,NULL,NULL,1,NULL),
(13,'s的阿萨德','阿萨德按时大神都是a![](http://www.ynxnw.top/static/imgs/20180406/mobile1.jpg)![](http://www.ynxnw.top/static/imgs/20180505/微信图片_20180427162133.jpg)','2018-05-05 00:00:00','../../static/imgs/20180505/微信图片_20180427162133.jpg',0,0,0,0,1,1,NULL,NULL,1,NULL),
(14,'心情沉闷，租房深夜被盗！','> 今日早上醒过来，发行自己的钱包跑到了笔记本上面，what！\n\n> 打开一看，里面一千多的现金只剩下一张5元了，存放百元大钞的格子空空如也，第一时间我意识到钱被偷走了，身份证、银行卡、公交卡还在，还不是绝路，接着回想了下，昨天的时候购买东西时钱包还是鼓鼓的，但我毅然决然的采用了手机支付……\n\n> 观察了周围环境，桌子就在窗户底下，三层拥挤民居，对面的小巷一米宽，窗户虽然有栅栏，但是这个天气，窗户玻璃是打开着，天杀的小偷居然爬上三楼从窗外伸手偷走了我的钱包，抽取了现金后将钱包丢回来，虽然他还有那么一点点良知没有将卡券丢弃，但我肯定是选择继续心里咒骂他了。\n\n> 损失个一千多现金，心中郁闷，这个对于我来说可以干其他事情却省下的，比如给购买笔记本加预算、比如买个大屏显示器，再比如不用耐心等待移动宽带不知什么时候会来安装线路，直接去购买贵点、速度快点的电信宽带。\n\n> 钱丢了，万幸新到的笔记本还躺在窗前的桌子上，对方应该能摸到才是，也可能是笔记本较大无法穿过铁栏杆，手机也还在，虽然是se，但也值点钱，买的时候三千多，最主要的是钱都在手机里，要是手机丢了要用钱，就得重新办手机卡、购买手机。\n\n> 心里想着要去上班了，收拾下突然发现，我的mini2呢？what？昨晚放在桌前充电着呢，现在只剩下充电器了，数据线还延伸到窗外……\n\n> 好吧，统计下，现金损失一千来块，mini2虽然老了，但又不是不能用，用来看视频肯定还要用个好久才能退役，现在直接没了，损失接近一千。\n\n> 虽然小偷没偷走我的新笔记本和旧笔记本以及手机，但是我不善于发现对方的美德，默默的拿起手机将mini2设置为丢失模式，虽然没什么乱用。','2018-05-17 00:00:00','../../static/imgs/20180401/tuzki_2013_avatar_01.jpg',1,3,29,0,1,1,NULL,NULL,1,NULL),
(15,'用CDN引入的bootstrap好像挂了,有空的话准备大修','一来就发现整个网站怎么破破烂烂的，原来CDN引入的bootstrap样式出现403错误了，无语，待用空修复，先记录下。\n\n2018-5-22：\n突然有自己恢复了……\n想了下，这个博客真的是太过简陋了，好多地方不尽人意，接下来有空的话，可能要大修一番。\n具体问题点：\n1. 完全没有SEO，现在连百度都无法搜索到。\n2. 文字书写排版比较难用，有些格式要手动书写，麻烦。\n3. 后台太过简单，验证较少，之前也发生了某个爱玩的吧友一下子将点赞数给暴击到天文数字。\n4. 文章搜索还未做。\n5. 有空的话，后台也许要换成tp框架重写。','2018-05-19 00:00:00','../../static/imgs/20180406/denglu.jpg',1,2,139,0,1,1,NULL,NULL,1,NULL),
(16,'已经七月了，好久好久没写博客……','**概要：**\n不知不觉七月了，转行开始上班到现在已经过了两个月了，时间真快，这一段时间真的没有什么事情值得些博客的，主要还是个人太过无聊，生活没有什么趣味……\n两个月的时间里，其实还是有些事情要吐槽的，就是都是细枝末节，没有太多的重点。\n\n**一、关于理财（撸羊毛）：**\n本来身为贫穷阶级的我来说，对于其实是没有理财的需要的（穷光蛋），但还是会有那么点贪小便宜（撸羊毛）的时候。\n最近发生的比较大的事情就是某些p2p倒闭了，有跑路的，有被抓了的，结果都是撸羊毛的哥们把自己的一身毛都陪光了。\n斐讯的0元购路由器就是在六月中下旬发生了翻车事件，不幸的是我也参与了其中之一，万幸的是不曾投资现金，被套牢的也仅仅是购买路由器的金额。\n去年开始便跟随潮流上了K2P的车，三个月799返现，免费得到一个千兆路由器，确实非常值得，前提是不翻车。\nK2P下车之后，陆续上了K3和H1的车，K3花了1699购买，分十一个月返现总计1999，目前还有600元未返现，H1花935购买，分四个月返现总计999，目前还有799未返现。目前H1的华夏万家还未出问题，不过K3的联币金融已经被查封了。\n![](http://www.ynxnw.top/static/imgs/20180701/20180701190206.jpg)\n斐讯也第一时间和联币金融撇清关系，将自己定位为实体制造业，和互联网金融企业毫无关联，但毕竟还是要过活的，斐讯也承若还未兑现的返现将有斐讯公司来兑现，不过这可苦了许多联币金融的投资者，之前的投资满多少赠送相应的激活资格就成了水中捞月了。\n\n‘我用着XXX万元的路由器感觉上网贼快’，这也是许多投资者的无奈，在此也只能提醒大家不要心存侥幸，用钱生钱的方法肯定是有风险的，而且还可能血本无归，联币金融等已年化率比余额宝、理财通等多一倍到两倍的优势吸引了大量投资者，但最终还是撑不下去的。\n![](http://www.ynxnw.top/static/imgs/20180701/20180701190353.jpg)\n**二、关于外包：**\n工作两个月，还是体会到了无论在哪个行业都有类似的许多无奈，真正接触了，才会发现每个行业都有类似的问题的。\n不管是从事制造业还是IT行业，作为技术支持职位，基本都是很苦逼，技术只是一些方法，操作这些方法的人沦为了公司的工具，公司如何使用工具就不好说了。\n这里还是要吐槽下小公司，整个公司就写代码的上六天班，无偿加班，强制加班，接收外包业务随意，没有明确合约不说，连基本的需求都没有定案，口头传授，概念模糊，毫无计划，动不动修改、增加需求。\n代码老旧而破败不堪，祖传不知多少代修修补补又是新项目不说，风格迥异，暴力书写，阅读起来能够精分。没有前端、没有测试，没有专门业务，没有维护，一个人从孕妇到奶妈再到保姆全部包揽了。\n','2018-07-01 00:00:00','../../static/imgs/20180701/20180701190206.jpg',1,2,1,0,1,1,NULL,NULL,1,NULL),
(17,'本站服务端程序由php原生转为thinkPHP5框架了','* 这个博客的由来是我在自学前端后自己动手的第一个项目，当时还没有php基础，只是大概看了下php语法，基本是用着js的思维和语法来写后端php的，也是之前侧重点在前端的VUE框架上。\n* 不过之前求职阴差阳错的进了一家创业公司，目前主要职务是写外包php业务，虽然前端也包揽了，让人难过的是这家公司使用传统的MVC框架编程，对于前端MVVM没有用武之地，毕竟团队内根本就没有前端人员。\n* 再说本站的原生php后台写的太过简陋，虽然也是因为程序本身逻辑功能简单，但依旧存在一些隐患，比如说直接原生操作mysqli，未做防sql注入，还有之前随意做的一个点赞按钮，被某个贴吧的爱玩家伙在浏览器控制台直接一次性干到了好好好多个赞。\n* 后端替换为thinkPHP其实挺早就写完了，但是一直没时间去测试和对接，GitHub上源码也比较早上传上去，前几日也刚好将数据库调整对接了下，目前头疼的依旧是前端渲染几乎无SEO，也许以后有心情了再来改前端吧。\n* 还有就是，本站的域名似乎快要过期了……','2018-07-11 00:00:00','http://www.bianquan.com/uploads\\user/1/article\\1551096208eYilP.jpeg',1,1,1,0,1,1,'2019-02-25 20:03:37',NULL,1,'这个博客的由来是我在自学前端后自己动手的第一个项目，当时还没有php基础，只是大概看了下php语法，基本是用着js的思维和语法来写后端php的，也是之前侧重点在前端的VUE框架上。'),
(18,'测试','打发打发','2019-02-21 17:12:35','',1,0,1,0,1,3,'2019-02-25 20:02:59',NULL,1,'dfadsfsadfasdfdsf');

/*Table structure for table `tv_comment` */

DROP TABLE IF EXISTS `tv_comment`;

CREATE TABLE `tv_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(6) NOT NULL COMMENT '文章ID',
  `user_id` int(10) DEFAULT NULL COMMENT '用户id',
  `user_name` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '用户名',
  `content` text CHARACTER SET utf8 NOT NULL COMMENT '内容',
  `create_time` timestamp NULL DEFAULT NULL COMMENT '评论时间',
  `type` int(6) NOT NULL,
  `target_id` int(10) NOT NULL COMMENT '回复目标评论ID',
  `published` int(6) NOT NULL COMMENT '状态，1正常，0封禁',
  `father_id` int(10) DEFAULT NULL COMMENT '最顶级评论ID',
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_comment` */

insert  into `tv_comment`(`id`,`article_id`,`user_id`,`user_name`,`content`,`create_time`,`type`,`target_id`,`published`,`father_id`,`update_time`,`delete_time`) values 
(61,0,1,'边泉','dfadff','0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00',NULL),
(62,0,1,'边泉','fdadfaf','0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00',NULL),
(63,0,1,'边泉','dfadsfa','0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00',NULL),
(64,0,1,'边泉','dfafadfad','0000-00-00 00:00:00',0,61,0,61,'0000-00-00 00:00:00',NULL),
(65,0,1,'边泉','fdsafadsfdsafd','0000-00-00 00:00:00',0,62,0,62,'0000-00-00 00:00:00',NULL),
(66,0,1,'边泉','fdafdaf','0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00',NULL),
(67,0,1,'边泉','fdafdafdfafads','0000-00-00 00:00:00',0,66,0,66,'0000-00-00 00:00:00',NULL),
(68,0,1,'边泉','fdfadsfa','0000-00-00 00:00:00',0,61,0,61,'0000-00-00 00:00:00',NULL),
(69,0,1,'边泉','dffadfdaf','0000-00-00 00:00:00',0,68,0,61,'0000-00-00 00:00:00',NULL),
(70,0,1,'边泉','fdaf','0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00',NULL),
(71,0,1,'边泉','fdaf','0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00',NULL),
(72,0,1,'边泉','fdaf','0000-00-00 00:00:00',0,64,0,61,'0000-00-00 00:00:00',NULL),
(73,0,1,'边泉','fdasfad','0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00',NULL),
(74,0,1,'边泉','fdfadsfad','0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00',NULL),
(75,0,1,'边泉','fdfadfad','0000-00-00 00:00:00',0,64,0,61,'0000-00-00 00:00:00',NULL),
(76,0,1,'边泉','dfa','0000-00-00 00:00:00',0,64,0,61,'0000-00-00 00:00:00',NULL),
(77,0,1,'边泉','dfadf','0000-00-00 00:00:00',0,61,0,61,'0000-00-00 00:00:00',NULL),
(78,0,1,'边泉','fdsafadsfa','0000-00-00 00:00:00',0,70,0,70,'0000-00-00 00:00:00',NULL),
(79,0,1,'边泉','dfafaf','0000-00-00 00:00:00',0,73,0,73,'0000-00-00 00:00:00',NULL),
(80,16,1,'边泉','发放的沙发','0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00',NULL),
(81,16,1,'边泉','打啊','0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00',NULL),
(82,0,1,'边泉','fadfa打发打发','0000-00-00 00:00:00',0,0,0,0,'2019-02-11 15:29:58',NULL),
(83,0,1,'边泉','发打发打发','2019-02-11 15:31:13',0,0,0,0,'2019-02-11 15:31:13',NULL),
(84,17,0,'方方达','大的事发后暗示法','2019-02-18 21:32:50',0,0,0,0,'2019-02-18 21:32:50',NULL);

/*Table structure for table `tv_config` */

DROP TABLE IF EXISTS `tv_config`;

CREATE TABLE `tv_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL COMMENT '配置名',
  `value` varchar(255) NOT NULL COMMENT '配置值',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_config` */

insert  into `tv_config`(`id`,`key`,`value`,`create_time`,`update_time`,`delete_time`) values 
(1,'user_register_status','1','2019-02-11 18:14:28','0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2,'blog_article_status','1','2019-02-11 18:14:47','0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3,'blog_comment_status','1','2019-02-11 18:14:57','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*Table structure for table `tv_images` */

DROP TABLE IF EXISTS `tv_images`;

CREATE TABLE `tv_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(500) CHARACTER SET utf8 NOT NULL COMMENT '图片名',
  `path` varchar(255) DEFAULT NULL COMMENT '本地拼接路劲',
  `user_id` int(11) NOT NULL COMMENT '上传用户id',
  `used` int(1) DEFAULT '0' COMMENT '0未使用，1已使用',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_images` */

insert  into `tv_images`(`id`,`image`,`path`,`user_id`,`used`,`create_time`,`update_time`,`delete_time`) values 
(107,'1551096208eYilP.jpeg','user/1/article',1,1,'2019-02-25 20:03:31','2019-02-25 20:03:31',NULL),
(108,'1551096208gMybS.jpeg','user/1/article',1,1,'2019-02-25 20:03:31','2019-02-25 20:03:31',NULL);

/*Table structure for table `tv_images_source` */

DROP TABLE IF EXISTS `tv_images_source`;

CREATE TABLE `tv_images_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL COMMENT '图片id',
  `table_name` varchar(255) DEFAULT NULL COMMENT '关联表名',
  `table_id` int(11) NOT NULL COMMENT '关联表id',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `delete_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`table_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_images_source` */

insert  into `tv_images_source`(`id`,`image_id`,`table_name`,`table_id`,`create_time`,`update_time`,`delete_time`) values 
(11,107,'article',17,'2019-02-25 20:03:31','2019-02-25 20:03:31',NULL),
(12,108,'article',17,'2019-02-25 20:03:31','2019-02-25 20:03:31',NULL);

/*Table structure for table `tv_menu_api` */

DROP TABLE IF EXISTS `tv_menu_api`;

CREATE TABLE `tv_menu_api` (
  `menu_api_id` int(6) NOT NULL AUTO_INCREMENT COMMENT '菜单关联api路劲id',
  `menu_id` int(6) DEFAULT NULL COMMENT '系统菜单id',
  `api_id` int(6) DEFAULT NULL COMMENT 'api路劲id',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`menu_api_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_menu_api` */

insert  into `tv_menu_api`(`menu_api_id`,`menu_id`,`api_id`,`create_time`,`update_time`,`delete_time`) values 
(22,5,25,NULL,NULL,NULL),
(23,5,26,NULL,NULL,NULL),
(24,5,24,NULL,NULL,NULL),
(25,5,9,NULL,NULL,NULL),
(27,8,31,NULL,NULL,NULL),
(35,7,29,NULL,NULL,NULL),
(36,7,40,NULL,NULL,NULL),
(37,7,28,NULL,NULL,NULL),
(38,6,20,NULL,NULL,NULL),
(39,6,22,NULL,NULL,NULL),
(40,6,21,NULL,NULL,NULL),
(41,5,23,NULL,NULL,NULL),
(42,5,19,NULL,NULL,NULL),
(43,6,41,NULL,NULL,NULL),
(44,6,42,NULL,NULL,NULL),
(45,7,27,NULL,NULL,NULL),
(46,8,28,NULL,NULL,NULL);

/*Table structure for table `tv_neighbors` */

DROP TABLE IF EXISTS `tv_neighbors`;

CREATE TABLE `tv_neighbors` (
  `nb_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nb_name` text CHARACTER SET utf8 NOT NULL COMMENT '友链标题',
  `nb_url` text CHARACTER SET utf8 NOT NULL COMMENT '地址',
  `nb_icon` text CHARACTER SET utf8 NOT NULL COMMENT '图标地址',
  `create_time` timestamp NULL DEFAULT NULL,
  `nb_published` int(11) NOT NULL COMMENT '状态',
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '关联userID',
  PRIMARY KEY (`nb_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_neighbors` */

insert  into `tv_neighbors`(`nb_id`,`nb_name`,`nb_url`,`nb_icon`,`create_time`,`nb_published`,`update_time`,`delete_time`,`user_id`) values 
(2,'我的GitHub','https://github.com/920200256','123','2018-04-14 00:00:00',1,NULL,NULL,1),
(3,'奔三路学习网','http://www.bslxx.com/','123','2018-04-14 00:00:00',1,NULL,NULL,1);

/*Table structure for table `tv_role` */

DROP TABLE IF EXISTS `tv_role`;

CREATE TABLE `tv_role` (
  `role_id` int(6) NOT NULL AUTO_INCREMENT COMMENT '管理员角色ID',
  `role_name` varchar(255) DEFAULT NULL COMMENT '角色名',
  `role_desc` varchar(1000) DEFAULT NULL COMMENT '角色描述',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  `write_auth` int(1) DEFAULT NULL COMMENT '0只读，1读写',
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_role` */

insert  into `tv_role`(`role_id`,`role_name`,`role_desc`,`create_time`,`update_time`,`delete_time`,`write_auth`) values 
(1,'admin','这是超级管理员',NULL,NULL,NULL,NULL),
(2,'worker','这是工作人员',NULL,NULL,NULL,NULL),
(6,'测试员','测试用的',NULL,NULL,NULL,NULL);

/*Table structure for table `tv_role_menu` */

DROP TABLE IF EXISTS `tv_role_menu`;

CREATE TABLE `tv_role_menu` (
  `role_menu_id` int(6) NOT NULL AUTO_INCREMENT COMMENT '角色菜单管理ID',
  `role_id` int(6) DEFAULT NULL COMMENT '角色id',
  `menu_id` int(6) DEFAULT NULL COMMENT '菜单id',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_menu_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_role_menu` */

insert  into `tv_role_menu`(`role_menu_id`,`role_id`,`menu_id`,`create_time`,`update_time`,`delete_time`) values 
(2,2,2,NULL,NULL,NULL),
(8,1,6,NULL,NULL,NULL),
(9,1,7,NULL,NULL,NULL),
(11,2,3,NULL,NULL,NULL),
(19,6,2,NULL,NULL,NULL),
(20,6,3,NULL,NULL,NULL),
(21,1,2,NULL,NULL,NULL),
(26,1,5,NULL,NULL,NULL),
(28,1,8,NULL,NULL,NULL),
(29,1,11,'2019-02-25 20:21:58','2019-02-25 20:21:58',NULL),
(30,1,12,'2019-02-25 20:21:58','2019-02-25 20:21:58',NULL);

/*Table structure for table `tv_system_menu` */

DROP TABLE IF EXISTS `tv_system_menu`;

CREATE TABLE `tv_system_menu` (
  `menu_id` int(6) NOT NULL AUTO_INCREMENT COMMENT '系统权限菜单表ID',
  `title` varchar(255) DEFAULT NULL COMMENT '权限菜单名',
  `father_id` int(6) DEFAULT '0' COMMENT '父级id',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  `path` varchar(255) DEFAULT '/' COMMENT '前端路由路劲',
  `component` varchar(255) DEFAULT NULL COMMENT '路由关联组件',
  `icon` varchar(255) DEFAULT NULL COMMENT '关联图标',
  `name` varchar(255) DEFAULT NULL COMMENT '路由名称',
  `sort` int(2) DEFAULT '0' COMMENT '菜单排序',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tv_system_menu` */

insert  into `tv_system_menu`(`menu_id`,`title`,`father_id`,`create_time`,`update_time`,`delete_time`,`path`,`component`,`icon`,`name`,`sort`) values 
(1,'用户管理',0,NULL,NULL,NULL,'/user','layout/Layout','chart','userManage',0),
(2,'会员管理',1,NULL,NULL,NULL,'user','user/user',NULL,'user',0),
(4,'权限管理',0,NULL,NULL,NULL,'/auth','layout/Layout','chart','authManage',0),
(5,'管理员管理',4,NULL,'2019-03-02 16:20:56',NULL,'admin','auth/admin','','admin',0),
(6,'角色管理',4,NULL,'2019-03-02 16:35:03',NULL,'role','auth/role','','role',2),
(7,'菜单管理',4,NULL,'2019-03-02 16:57:40',NULL,'menu','auth/menu','','menu',3),
(8,'接口管理',4,NULL,'2019-03-02 16:57:27',NULL,'api','auth/api','','api',4),
(9,'系统管理',0,NULL,'2019-03-02 16:36:48',NULL,'/system','layout/Layout','chart','system',20),
(10,'博客管理',0,NULL,NULL,NULL,'/blog','layout/Layout','chart','blog',0),
(11,'文章管理',10,NULL,NULL,NULL,'article','blog/article',NULL,'article',0),
(12,'友情链接管理',10,NULL,NULL,NULL,'neighbor','blog/neighbor',NULL,'neighbor',0);

/*Table structure for table `tv_tags` */

DROP TABLE IF EXISTS `tv_tags`;

CREATE TABLE `tv_tags` (
  `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_name` text CHARACTER SET utf8 NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tag_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `tv_tags` */

insert  into `tv_tags`(`tag_id`,`tag_name`,`create_time`,`update_time`,`delete_time`) values 
(1,'生活随笔',NULL,NULL,NULL),
(2,'观后感',NULL,NULL,NULL),
(3,'前端',NULL,NULL,NULL),
(4,'后端',NULL,NULL,NULL);

/*Table structure for table `tv_user` */

DROP TABLE IF EXISTS `tv_user`;

CREATE TABLE `tv_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户自增ID',
  `user_name` varchar(30) NOT NULL COMMENT '用户名',
  `user_pwd` varchar(32) NOT NULL COMMENT '用户密码',
  `user_email` varchar(30) NOT NULL COMMENT '用户邮箱',
  `user_status` varchar(30) NOT NULL DEFAULT '0' COMMENT '用户状态',
  `user_pwd_salt` varchar(32) DEFAULT NULL COMMENT '用户密码盐',
  `introduction` varchar(1000) NOT NULL COMMENT '用户简介',
  `update_time` timestamp NULL DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  `user_mobile` int(11) DEFAULT NULL COMMENT '手机号',
  `gender` int(1) DEFAULT '0' COMMENT '性别，1男，2女',
  `birthday` timestamp NULL DEFAULT NULL COMMENT '生日',
  `user_level` int(1) DEFAULT '0' COMMENT '用户等级',
  `user_avatar` varchar(1000) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '用户头像',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

/*Data for the table `tv_user` */

insert  into `tv_user`(`user_id`,`user_name`,`user_pwd`,`user_email`,`user_status`,`user_pwd_salt`,`introduction`,`update_time`,`create_time`,`delete_time`,`user_mobile`,`gender`,`birthday`,`user_level`,`user_avatar`) values 
(1,'边泉','e7d66c8b123ffad09aa180a9531b6f82','920200256@qq.com','1','eNHm0hMygWF8ggQU0sW6qpusGIo2rxWj','打发吃的是草','2018-04-01 00:00:00',NULL,NULL,2147483647,1,NULL,1,'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif'),
(36,'边泉111','b38ed29006731b720b50732a94423ac7','9202002516@qq.com','0','CDgFwnvzCuoDdr35cd3ESgvy6yYueyBG','',NULL,NULL,NULL,NULL,0,NULL,0,NULL),
(37,'边泉1111','6f47e37ec8c63c49a793f12c73259125','92020025116@qq.com','0','YKYWYH3OExillINMVc8OHsqFwtf5KHIf','',NULL,NULL,NULL,NULL,0,NULL,0,NULL),
(38,'边泉1111对方','c79e4cdca5b2704fbcaa9556dbba4269','9202002511的6@qq.com','0','PmbJUx6zb5GzZt2X8GIt0aRiqT1aKlkj','',NULL,NULL,NULL,NULL,0,NULL,0,NULL),
(39,'的道法','f1d7150365f0402c783202a716d3f601','920200@qq.com','0','asT0mREOe7Ah7JLERFOCPmMqQOiLftrR','',NULL,NULL,NULL,NULL,0,NULL,0,NULL),
(40,'测试用户了','4d87a8155b62270c710dfeed718789f1','920@qq.com','0','5xM6n0dhYtqgdoxgWL6Zv2fGKby10F6g','',NULL,NULL,NULL,NULL,0,NULL,0,NULL),
(41,'dfadsf','b46c1e4b6fac23c29723c0937a8e1262','1234@qq.com','0','4XJBVdXEdp8Qt7N9m5xwQQwyf5VcQWGx','','2019-02-17 21:04:31','0000-00-00 00:00:00',NULL,NULL,0,NULL,0,NULL),
(42,'打发打发','e7d66c8b123ffad09aa180a9531b6f82','92012556@qq.com','0','eNHm0hMygWF8ggQU0sW6qpusGIo2rxWj','','2019-02-21 16:44:38','0000-00-00 00:00:00',NULL,NULL,0,NULL,0,NULL);

/*Table structure for table `tv_web_data` */

DROP TABLE IF EXISTS `tv_web_data`;

CREATE TABLE `tv_web_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_num` int(11) NOT NULL,
  `user_num` int(11) NOT NULL,
  `comment_num` int(11) NOT NULL,
  `praise_num` int(11) NOT NULL,
  `tags_num` int(11) NOT NULL,
  `viewers_num` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `delete_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=FIXED;

/*Data for the table `tv_web_data` */

insert  into `tv_web_data`(`id`,`article_num`,`user_num`,`comment_num`,`praise_num`,`tags_num`,`viewers_num`,`create_time`,`update_time`,`delete_time`) values 
(1,17,17,47,23190,0,0,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
