import Vue from 'vue';
import Router from 'vue-router';
import homePage from './views/home.vue';
import aboutPage from './components/about.vue';
import adminPage from './views/admin.vue';
import articleList from './components/articleList.vue';
import article from './components/article.vue';
import project from './components/project.vue';
import msgborder from './components/msgborder';
import outline from './components/outline.vue';
import write from './components/write.vue';
import editor from './components/editor.vue';
import editorComment from './components/editor_comment.vue';
import memberList from './components/menber_list.vue';
import imgsList from './components/imgs_list.vue';
import otherSeting from './components/other_seting.vue';
import user from './components/user.vue';
import timer from './components/timer.vue';
import lab from './components/lab.vue';
import store from './vuex/store.js';




Vue.use(Router);


const routes = [
		{
			path:'/',
			component:homePage,
      children: [
        {
          path:'/',
          name:'home',
          redirect:'/articleList'
      },
        {
          path:'about',
          name:'about',
          component:aboutPage
      },
        {
          path:'articleList',
          name:'articleList',
          component:articleList,
        },
        {
            path:'articleList/article/:id',
            name:'article',
          component:article
          },

        {
          path:'project',
          name:'project',
          component:project
        },
        {
          path:'timer',
          name:'timer',
          component:timer
        },
        {
          path:'msgborder',
          name:'msgborder',
          component:msgborder
        }]

		},
		{
			path:'/admin',
      component:adminPage,
      name:'admin',
      meta: { requireAuth: true },
      children: [
        {
          path: '/admin',
          redirect: '/admin/outline',
          meta: { requireAuth: true }
        },
        {
        path: '/admin/outline',
        component: outline,
          meta: { requireAuth: true }
      },
        {
          path: '/admin/write',
          component: write,
          meta: { requireAuth: true }
        },
        {
          path: '/admin/editor',
          component: editor,
          meta: { requireAuth: true }
        },
        {
          path: '/admin/editorComment',
          component: editorComment,
          meta: { requireAuth: true }
        },
        {
          path: '/admin/memberList',
          component: memberList,
          meta: { requireAuth: true }
        },
        {
          path: '/admin/imgsList',
          component: imgsList,
          meta: { requireAuth: true }
        },
        {
          path: '/admin/otherSeting',
          component: otherSeting,
          meta: { requireAuth: true }
        },
        {
          path: '/admin/user',
          component: user,
          meta: { requireAuth: true }
        },
        {
          path: '/admin/lab',
          component: lab,
          meta: { requireAuth: true }
        }
      ]
		}
	];


const router = new Router({
  routes,
  mode: 'history',
  scrollBehavior(to, from, savedPosition){
    if (savedPosition) {
      return savedPosition
    } else {
      return new Promise((resolve, reject) => {
        setTimeout(() => {
          resolve({x: 0, y: 0})
        }, 50)
      });
    }
  },
  // beforeRouteLeave (to, from , next) {
  //   const answer = window.confirm('Do you really want to leave? you have unsaved changes!')
  //   if (answer) {
  //     next()
  //   } else {
  //     next(false)
  //   }
  // }
});


router.beforeEach((to, from, next) => {
 // console.log(from.fullPath);
  if (to.meta.requireAuth) {  // 判断该路由是否需要登录权限
    if (store.state.token) {  // 通过vuex state获取当前的token是否存在
      next();
    }
    else {
      store.commit("change");
      next({
        path: from.fullPath,
        query: {redirect: from.fullPath}  // 将跳转的路由path作为参数，登录成功后跳转到该路由
      })
    }
  }
  else {
    next();
  }
})




export default router;
