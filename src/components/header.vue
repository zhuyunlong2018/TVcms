<template>
	<div>
    <!--[if lte IE 8]>
    <p class="browserupgrade">您的浏览器版本已经落后了, 请到 <a href="http://browsehappy.com/">这里</a> 更新, 以获取最佳的体验</p>
    <![endif]-->
    <transition name="show-nav" >
      <nav class="nav-content" v-show="show_header_nav" >
        <ul class="header-nav">
          <li @click="go_home">
            <router-link to="/articleList">
              <i class="glyphicon glyphicon-home" ></i>
              <span>主页</span>
            </router-link></li>
          <li >
            <router-link to="/msgborder">
              <i class="glyphicon glyphicon-comment" ></i>
              <span>留言板</span>
            </router-link>
          </li>
          <li >
            <router-link to="/project">
              <i class="glyphicon glyphicon-folder-open" ></i>
              <span>实验室</span>
            </router-link>
          </li>
          <li >
            <router-link to="/timer">
              <i class="glyphicon glyphicon-calendar" ></i>
              <span>时间轴</span>
            </router-link>
          </li>
          <li >
            <router-link to="/about">
              <i class="glyphicon glyphicon-info-sign" ></i>
              <span>关于</span>
            </router-link></li>
          <li @click='_get_bing' class="search">
            <a href="javascript:;">
              <i class="glyphicon glyphicon-search" ></i>
              <span>搜索</span>
            </a>
          </li>
          <li class="login_user">
            <a href="javascript:;" @click="check_login">
              <i class="glyphicon glyphicon-user" ></i>
              <span>{{ login_user }}</span>
            </a>
          </li>
          <li class="logout_user" :class="{'touch-logout': if_touch }" v-show="logout_register" >
            <a href="javascript:;" @click="logout">
              <i class="glyphicon glyphicon-off" ></i>
              <span>退出登录</span>
            </a>
          </li>
          <li class="register" v-show="!logout_register" >
            <a href="javascript:;" @click="_show_register_box">
              <i class="glyphicon glyphicon-plus-sign" ></i>
              <span>注册</span>
            </a>
          </li>
        </ul>
      </nav>
    </transition>
	</div>
</template>

<script>
import { mapState, mapActions,mapMutations } from 'vuex';
  export default {
      data(){
          return{

          }
      },
    methods:{
      ...mapActions(['check_login','getPage','getPageCount','get_bing']),
      ...mapMutations(['logout','change','show_register_box','CLEAR_CRUMBS','changePage','TOGGLE_SEARCH']),
      _show_register_box:function() {
        this.change();
        this.show_register_box();
      },
      _get_bing:function() {
        if(!this.search.bing){
          this.get_bing();
        }
        this.TOGGLE_SEARCH(true);
      },
        go_home:function() {
          this.CLEAR_CRUMBS();
          this.changePage(0);
          this.getPage();
          this.$router.push('/');
          this.getPageCount();
        }

    },
    computed: {
      ...mapState(['login_user','show_header_nav','search','if_touch']),
      logout_register:function() {
        if (this.login_user == '登录') {
          return false;
        } else {
          return true ;
        }
      }
    }
  }

</script>

<style scoped>





/* 导航部分 */
.nav-content {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 50px;
  overflow: hidden;
  z-index: 9998;
  background: rgba(33,33,33,0.8);
}
.header-nav{
  width: 80%;
  margin: 0 auto;
}
 .header-nav li{
	float: left;
}
 .header-nav li a{
   text-decoration: none;
	line-height: 50px;
  padding: 0 10px;
	color: #fff;
	transition: 0.6s;
	-webkit-transition: 0.6s;
	-o-transition: 0.6s;
	-ms-transition: 0.6s;
	-moz-transition: 0.6s;
	cursor: pointer;

}
.header-nav li a:hover{
	color: #ffcdcd;
} 

.header-nav li .router-link-active {
  color: rgb(186, 248, 243);
}
.show-nav-enter-active {
  transition: all .3s ease;
}
.show-nav-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.show-nav-enter, .show-nav-leave-to
/* .slide-fade-leave-active for below version 2.1.8 */ {
  transform: translateY(-10px);
  opacity: 0;
}

.header-nav li.logout_user {
  padding: 0;
  opacity: 0;
  width: 0;
  transition: all .5s;
}

.touch-logout,
.header-nav li.login_user:hover + .logout_user,
.header-nav li.logout_user:hover  {
  opacity: 1 !important;
  width: 110px !important;
}



@media only screen and (min-width: 768px) and (max-width: 1024px) {
  .header-nav {
  width: 100% !important;
}
}

@media only screen and (min-width: 501px) and (max-width: 768px) {
  .header-nav {
  width: 100% !important;
}

.header-nav li:nth-child(6),
.header-nav li:nth-child(7),
.header-nav li:nth-child(9) {
  width: 30px;
  
}
.touch-logout,
.header-nav li.login_user:hover + .logout_user,
.header-nav li.logout_user:hover  {
  opacity: 1 !important;
  width: 40px !important;
}


}

@media only screen and (max-width: 500px) {
 .nav-content {
  position: fixed;
  top: 0;
  left: 0;
  width: 30%;
  height: 100%;
  overflow: hidden;
  background: rgba(33,33,33,0.9);
}
 
 .header-nav {
  width: 100% !important;
}
 .header-nav li{
  float: none;
  width: 80px;
  height: 50px;
  overflow:hidden;
}
.header-nav li:nth-child(7),
.header-nav li:nth-child(8) {
 height: 50px;
 overflow: hidden;
}
.header-nav li.logout_user {
  padding: 0;
  opacity: 1;
  width: 70px;
}

.header-nav li.login_user:hover + .logout_user,
.header-nav li.logout_user:hover  {
  opacity: 1;
  width: 70px !important;
}

.show-nav-leave-active {
  transition: all .5s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.show-nav-enter, .show-nav-leave-to
/* .slide-fade-leave-active for below version 2.1.8 */ {
  transform: translateX(-10px);
  opacity: 0;
}

}


</style>
