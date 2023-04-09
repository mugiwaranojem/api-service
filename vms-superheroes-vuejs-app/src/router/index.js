import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import(/* webpackChunkName: "home" */ '../components/HomePage.vue'),
    meta:{
      middleware: 'auth',
      title: 'Home'
    }
  },
  {
    path: '/login',
    name: 'login',
    component: () => import(/* webpackChunkName: "login" */ '../components/LoginPage.vue'),
    meta:{
      middleware: 'guest',
      title: 'Login'
    }
  }
]

const router = new VueRouter({
  routes
})

router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title} - API`

  const { middleware } = to.meta;
  const currentUser = localStorage.getItem('currentUser') || '{}';

  if (middleware === 'auth') {
    if (!currentUser || currentUser === '{}') {
      return next({ path: '/login' })
    }
  }

  next()
})

export default router