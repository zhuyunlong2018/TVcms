# TVcms

一个基于thinkPHP5+Vue2.5的简单cms内容管理程序


* 简单说明：本项目由原个人初学时开发博客重构而来，参考项请查看下方致谢


* [文档](https://gitee.com/zhuyunlong2018/TVcms/wikis)（暂未书写，有空会补充进去）

 

## 演示

还未搭建好，敬请期待……

## 项目代码

* [码云](https://gitee.com/zhuyunlong2018/TVcms)
* [GitHub](https://github.com/920200256/TVcms)

## 项目架构
![](./doc/pic/system_pic1.png)    

## 使用技术栈

> 1. thinkPHP5.0
> 2. Vue2.5
> 




## 项目启动

1. 下载代码

    打开命令行，输入以下命令
    ```bash
    git clone 项目地址
    cd TVcms
    ```
    
2. 配置数据库：
    * 后端数据库参考TP5填写参数
    * 将TVcms.sql文件导入自己的数据库中


3. 配置后台

    ```bash
    cd servers
    composer install
    ```
    
4. 配置前端

    命令行返回项目根目录
    ```bash
	cd admin
    npm install//按照不成功可以用cnpm install
    npm run dev
    ```
    blog模块相同
    
5. 说明
   
   后端tp5的file类型cache实现容易有bug，即将使用redis更好，请确保安装PHP-redis扩展及redis服务端


## 版本更新

目前一直未dev版，细节及功能都还待修改丰富中……

   
## 相关截图

管理总后台（cms)
![](./doc/pic/show_admin1.png)   

原博客项目前台
![](./doc/pic/show_blog1.png)   

原博客项目后台
![](./doc/pic/show_blog2.png)   

## 致谢

本项目的admin前端模块基于或参考以下项目：
> 1. [vue-element-admin](https://github.com/PanJiaChen/vue-element-admin)
> 一个基于Vue和Element的后台集成方案
> 
> 2. [litemall](https://github.com/linlinjava/litemall)
>一个基于springboot+vue的前后端分离商城项目



