<template>
  <div @wheel="scrollBar" @touchend="touch" >
      <nav-header></nav-header>
      <!--登录页面-->
      <log-in></log-in>
      <!-- 背景图 -->
      <div class="bg-pic">
        <img src="../../assets/imgs/nav.jpg" alt="">
      </div>
       <!-- 面包屑导航 -->
      <div class="crumbs">
        <ul class="top-nav">
        <li @click="goHome" >
          <i class="glyphicon glyphicon-home" ></i>
          <span>首页</span>
        </li>
        <li v-show="_crumbs" @click="getListByTag" >
          <i class="glyphicon glyphicon-menu-right" ></i>
          <span>{{_crumbs}}</span>
        </li>
        <li v-show="crumbs.title" >
          <i class="glyphicon glyphicon-menu-right" ></i>
          <span>{{crumbs.title}}</span>
        </li>
      </ul>
      </div>
      <!-- 内容区域 -->
    <main class="center-block clearfix">
      <router-view></router-view>

        <!-- 侧边区域 -->
      <aside-bar></aside-bar>
      </main>

    <div class="return-top t-c"><a href="javascript:scroll(0,0)"> <i class="glyphicon glyphicon-circle-arrow-up" ></i> </a></div>
    <div class="show-nav-btn" @click="showNav"  >
        <i class="glyphicon" :class="change_color" ></i>
    </div>
    <nav-footer></nav-footer>

  </div>
</template>

<script>


  import NavHeader from './header.vue';
  import NavFooter from './footer.vue';
  import ArticleList from '@/views/article/articleList.vue';
  import AsideBar from './aside.vue';
  import LogIn from '@/views/login.vue';

  import { mapMutations,mapState,mapActions } from 'vuex';



  export default {
    name: 'home',
    methods:{
      ...mapActions(['getArticleList']),
      ...mapMutations(['SHOW_NAV','CHANGE_CRUMBS','CLEAR_CRUMBS','IF_TOUCHED','SET_ARTICLE_LIST_INFO']),
      touch:function(e) {
        let w = document.documentElement.clientWidth || document.body.clientWidth;
        this.IF_TOUCHED();
        if(w< 501) {
          this.SHOW_NAV(false);
        }
      },
      scrollBar:function(e) {
        if (e.deltaY>0 ){
          this.SHOW_NAV(false);
        } else {
          this.SHOW_NAV(true);
        }
      },
      showNav:function() {
        if(this.showHeaderNav) {
          this.SHOW_NAV(false);
        } else {
          this.SHOW_NAV(true);
        }
      },
      getListByTag() {
        let tagName = this.crumbs.tagName
        let tagID = this.crumbs.tagID
        if(tagID && tagName) {
          let listObj = {
            page: 1,
            tagID
          }
          this.$store.commit('SET_ARTICLE_LIST_INFO',listObj)
          this.getArticleList()
          let obj = {
            tagName,
            tagID,
            title: ''
          }
          this.CHANGE_CRUMBS(obj)
          this.$router.push('/');
        }
        
      },
      goHome:function() {
        if(this.$route.name == 'articleList') {
          let listObj = {
            page: 1,
            tagID: ''
          }
          this.$store.commit('SET_ARTICLE_LIST_INFO',listObj)
          this.getArticleList()
        }   
        this.CLEAR_CRUMBS();
        this.$router.push('/');
      }
    },
    computed: {
      ...mapState(['showHeaderNav','crumbs','show_article']),
      change_color: function() {
        if(this.showHeaderNav) {
          return 'white glyphicon-option-horizontal';
        } else {
          return 'black glyphicon-option-vertical';
        }
      },
      _crumbs:function() {
        let tagName
        switch(this.$route.name) {
          case 'articleList':
            if(this.crumbs.tagName) {
              tagName = this.crumbs.tagName
            } else {
              tagName = '所有文章'
            }
            return tagName
            break
          case 'article':
            tagName = this.crumbs.tagName
            return tagName
            break
          case 'msgborder':
            tagName = '留言板'
            break;
          case 'timer':
            tagName = '时间轴'
            break;
          case 'about':
            tagName = '关于'
            break;
          default:
        }
        this.CLEAR_CRUMBS()
        return tagName
      }
    },
    created:function(){

    },
    mounted(){
    },
    components: {
      NavHeader,
      NavFooter,
      ArticleList,
      AsideBar,
      LogIn
    }
  }

</script>


<style scoped>


  .bg-pic img {
    width: 100%;
  }

  .return-top a {
    position: fixed;
    right: 20px;
    bottom: 50px;
    width: 40px;
    height: 40px;
    line-height: 40px;
    color: rgba(33,33,33,0.9);
    font-size: 30px;
  }

  .crumbs {
    width: 100%;
    height: 32px;
    overflow: hidden;
    border-bottom: 1px solid #ccc;
  }
  .crumbs .top-nav {
    width: 80%;
    margin: 0 auto;
    padding: 5px 0;

  }
  .crumbs .top-nav li {
    display: inline-block;
     cursor: pointer;
  }
  .crumbs .top-nav li:hover {
    color: #339;
  }



.show-nav-btn {
  display: none;
  opacity: 0;
}

.black {
  color: #000;
  left: 5px;
  transition: all 1s;
}

.white {
  color: #fff;
  left: 20px;
  transition: all 1s;
}
@media screen and (max-width:1365px) {
  .crumbs .top-nav {
    width: 95%;
  }
}
@media only screen and (max-width: 500px) {
  .show-nav-btn {
   position: fixed;
  font-size: 30px;
  z-index: 9998;
  display: block;
  bottom: 10px;
  left: 0px;
  opacity: 1;
}
.return-top a {
  bottom: 10px;
}
  


}


@media screen and (min-width:768px) {
  main {
    max-width: 95%;
  }
}

@media screen and (min-width:1366px) {
  main {
    max-width: 80%;
  }
}


</style>
