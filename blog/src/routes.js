import Vue from 'vue';
import Router from 'vue-router';
import homePage from '@/views/layout/home.vue';
import aboutPage from '@/views/about.vue';
import adminPage from '@/views/admin/admin.vue';
import articleList from '@/views/article/articleList.vue';
import article from '@/views/article/article.vue';
import msgborder from '@/views/components/msgborder';
import outline from '@/views/components/outline.vue';
import write from '@/views/components/write.vue';
import editor from '@/views/components/editor.vue';
import otherSeting from '@/views/components/other_seting.vue';
import user from '@/views/components/user.vue';
import timer from '@/views/components/timer.vue';
import store from '@/store';




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
          name: 'admin',
          redirect: '/admin/outline',
          meta: { requireAuth: true }
        },
        {
        path: '/admin/outline',
        name: 'outline',
        component: outline,
          meta: { requireAuth: true }
      },
        {
          path: '/admin/write',
          name: 'write',
          component: write,
          meta: { requireAuth: true }
        },
        {
          path: '/admin/editor',
          name: 'editor',
          component: editor,
          meta: { requireAuth: true }
        },
        {
          path: '/admin/otherSeting',
          name: 'otherSeting',
          component: otherSeting,
          meta: { requireAuth: true }
        },
        {
          path: '/admin/user',
          name: 'user',
          component: user,
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
  }
});


router.beforeEach((to, from, next) => {
  if (to.meta.requireAuth) {  // 判断该路由是否需要登录权限
    if (store.getters.token) {  // 获取当前的token是否存在
      next();
    } else {
      store.commit("SHOW_LOGIN_BOX");
      store.dispatch('logOut')
      next({
        path: from.fullPath,
        query: {redirect: from.fullPath}  // 将跳转的路由path作为参数，登录成功后跳转到该路由
      })
    }
  } else {
    next();
  }
})
export default router;
