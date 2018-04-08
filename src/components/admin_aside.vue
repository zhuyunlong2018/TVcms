<template>

  <div class="admin-aside" :class="_toggle_sidebar" @click="close_logout" >
      <ul class="sidebar-menu">
        <li class="header" >欢迎使用边泉博客管理平台</li>
        <li>
          <router-link to="/admin/outline">
            <i class="glyphicon glyphicon-th-list"></i>
            <span>网站概要</span>
          </router-link>
        </li>
        <li class="treeview">
        <router-link to="/admin/user">
          <i class="glyphicon glyphicon-user"></i> <span>个人中心</span>
        </router-link>
        </li>
        <li class="treeview" @click="slide_article">
          <a href="#">
            <i class="glyphicon glyphicon-book"></i>
            <span>文章管理</span>
            <span class="glyphicon pull-right" :class="icon.article"></span>
          </a>
          <transition name="slide-fade">
            <ul class="treeview-menu" v-show="treeview_menu.article" @click="stopProp">
              <li><li><router-link to="/admin/write"><i class="glyphicon glyphicon-edit"></i> 发布文章</router-link></li>
              <li><router-link to="/admin/editor"><i class="glyphicon glyphicon-check"></i> 编辑文章</router-link></li>
            </ul>
          </transition>
        </li>
        <li class="treeview">
          <router-link to="/admin/editorComment" >
            <i class="glyphicon glyphicon-comment"></i> <span>评论管理</span>
          </router-link>
        </li>
        <li>
          <router-link to="/admin/memberList" >
            <i class="glyphicon glyphicon-credit-card"></i>
            <span>会员管理</span>
          </router-link>
        </li>
        <li>
          <router-link to="/admin/imgsList" >
            <i class="glyphicon glyphicon-picture"></i>
            <span>图片管理</span>
          </router-link>
        </li>
        <li>
          <router-link to="/admin/otherSeting" >
            <i class="glyphicon glyphicon-cog"></i>
            <span>其他设置</span>
          </router-link>
        </li>
        <li>
          <router-link to="/admin/lab" >
            <i class="glyphicon glyphicon-folder-open"></i>
            <span>实验室</span>
          </router-link>
        </li>
        <li class="header">浏览博客</li>
        <li><router-link to="/articleList"><i class="glyphicon glyphicon-home" ></i> <span>返回首页</span></router-link></li>
      </ul>
  </div>
</template>

<script>

import { mapState,mapMutations } from 'vuex';

  export default {
    data() {
      return {
        treeview_menu: {
          article: false
        },
        icon: {
          article: 'glyphicon-menu-left'
        }
      };
    },
    methods: {
      ...mapMutations(['close_logout','toggle_sidebar']),
      slide_article:function() {
        this.treeview_menu.article = !this.treeview_menu.article;
        if(this.icon.article == 'glyphicon-menu-left') {
          this.icon.article = 'glyphicon-menu-down'
        } else {
          this.icon.article = 'glyphicon-menu-left'
        }
      },
      stopProp: function(e) {
        e = e || event;
        e.stopPropagation();
      }
    },
    computed: {
      ...mapState(['logout_box','show_sidebar']),
      _toggle_sidebar:function() {
        if(this.show_sidebar) {
          return 'show-sidebar';
        } else {
          return 'close-sidebar';
        }
      }
    }
    
  }

</script>


<style>

.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active for below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}



  .admin-aside {
	position: absolute;
	top: 0;
	left: 0;
	height: 100%;
	min-height: 100%;
	width: 230px;
	z-index: 810;
	background-color: #222d32;
 }

 .sidebar-menu {
  list-style: none;
  margin: 0;
  padding: 0;
  background-color: #222d32; }
  .sidebar-menu > li {
    position: relative;
    margin: 0;
    padding: 0; }
    .sidebar-menu > li > a {
      padding: 12px 5px 12px 15px;
      display: block;
      border-left: 3px solid transparent;
      color: #b8c7ce; }
      .sidebar-menu > li > a > .fa {
        width: 20px; }
    .sidebar-menu > li:hover > a, .sidebar-menu > li.active > a {
      color: #fff;
      background: #1e282c;
      border-left-color: #3c8dbc; }
    .sidebar-menu > li > .treeview-menu {
      margin: 0 1px;
      background: #2c3b41; }
    .sidebar-menu > li .label,
    .sidebar-menu > li .badge {
      margin-top: 3px;
      margin-right: 5px; }
  .sidebar-menu li.header {
    padding: 10px 25px 10px 15px;
    font-size: 12px;
    color: #4b646f;
    background: #1a2226; }
  .sidebar-menu li > a > .fa-angle-left {
    width: auto;
    height: auto;
    padding: 0;
    margin-right: 10px;
    margin-top: 3px; }
  .sidebar-menu li.active > a > .fa-angle-left {
    transform: rotate(-90deg); }
  .sidebar-menu li.active > .treeview-menu {
    display: block; }
  .sidebar-menu a {
    color: #b8c7ce;
    text-decoration: none; }
  .sidebar-menu .treeview-menu {
    
    list-style: none;
    padding: 0;
    margin: 0;
    padding-left: 5px; }
    .sidebar-menu .treeview-menu .treeview-menu {
      padding-left: 20px; }
    .sidebar-menu .treeview-menu > li {
      margin: 0; }
      .sidebar-menu .treeview-menu > li > a {
        padding: 5px 5px 5px 15px;
        display: block;
        font-size: 14px;
        color: #8aa4af; }
        .sidebar-menu .treeview-menu > li > a > .fa {
          width: 20px; }
        .sidebar-menu .treeview-menu > li > a > .fa-angle-left,
        .sidebar-menu .treeview-menu > li > a > .fa-angle-down {
          width: auto; }
      .sidebar-menu .treeview-menu > li.active > a, .sidebar-menu .treeview-menu > li > a:hover {
        color: #fff; }


        @media only screen and (max-width: 1024px) {
          .admin-aside {
            width: 130px;
          }

        }

        @media only screen and (max-width: 500px) {
          .close-sidebar {
            left: -130px;
            transition: all 0.5s;
          }
        }
          .show-sidebar {
            left: 0;
              transition: all 0.5s;
          }

</style>


