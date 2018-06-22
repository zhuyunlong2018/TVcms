<template>
  <div @wheel="scrollBar" @touchend="touch" >
      <nav-header></nav-header>
      <!--登录页面-->
      <log-in></log-in>
      <!-- 背景图 -->
      <div class="bg-pic">
        <img src="../assets/imgs/nav.jpg" alt="">
      </div>
       <!-- 面包屑导航 -->
      <div class="crumbs">
        <ul class="top-nav">
        <li @click="go_home" >
          <i class="glyphicon glyphicon-home" ></i>
          <span>首页</span>
        </li>
        <li v-show="_crumbs" @click="_get_article_by_tag" >
          <i class="glyphicon glyphicon-menu-right" ></i>
          <span>{{_crumbs}}</span>
        </li>
        <li v-show="crumbs.second" >
          <i class="glyphicon glyphicon-menu-right" ></i>
          <span>{{crumbs.second}}</span>
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
    <div class="show-nav-btn" @click="_show_nav"  >
        <i class="glyphicon" :class="change_color" ></i>
    </div>
    <nav-footer></nav-footer>

  </div>
</template>

<script>


  import NavHeader from '../components/header.vue';
  import NavFooter from '../components/footer.vue';
  import ArticleList from '../components/articleList.vue';
  import AsideBar from '../components/aside.vue';
  import LogIn from '../components/login.vue';

  import { mapMutations,mapState,mapActions } from 'vuex';



  export default {
      name: 'home',
      methods:{
        ...mapActions(['getPage','getPageCount']),
        ...mapMutations(["refresh",'show_nav','CHANGE_CRUMBS','CLEAR_CRUMBS','changePage','if_touched']),
        touch:function(e) {
          let w = document.documentElement.clientWidth || document.body.clientWidth;
          this.if_touched();
          if(w< 501) {
            this.show_nav(false);
          }
        },
        scrollBar:function(e) {
          if (e.deltaY>0 ){
            this.show_nav(false);
          } else {
            this.show_nav(true);
          }
        },
        _show_nav:function() {
          if(this.show_header_nav) {
            this.show_nav(false);
          } else {
            this.show_nav(true);
          }
        },
        _get_article_by_tag:function() {
          if(this._crumbs == this.show_article.a_tag) {
            //console.log(this._crumbs);
            let obj = {};
            obj.tag = this._crumbs;
            obj.title = '';
            this.CHANGE_CRUMBS(obj);
            this.changePage(0);
            this.$router.push('/');
            
          }

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
      ...mapState(['show_header_nav','crumbs','show_article']),
      change_color: function() {
        if(this.show_header_nav) {
          return 'white glyphicon-option-horizontal';
        } else {
          return 'black glyphicon-option-vertical';
        }
      },
      _crumbs:function() {
        let obj = {};
        switch(this.$route.name) {
          case 'articleList':
            obj.title = '';
            this.CHANGE_CRUMBS(obj);
            if(this.crumbs.first) {
              return this.crumbs.first;
            } else {
              return '所有文章';
            }
            break;
          case 'article':
            obj.tag = '';
            obj.title = this.show_article.a_title;
            this.CHANGE_CRUMBS(obj);
            return this.show_article.a_tag;
            break;
          case 'msgborder':
            this.CLEAR_CRUMBS();
            return '留言板';
            break;
          case 'project':
            this.CLEAR_CRUMBS();
            return '实验室';
            break;
          case 'timer':
            this.CLEAR_CRUMBS();
            return '时间轴';
            break;
          case 'about':
            this.CLEAR_CRUMBS();
            return '关于';
            break;
          default:
            this.CLEAR_CRUMBS();
        }
       // console.log(this.$route.name);
      }
    },
     
      created:function(){
        this.refresh();

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
