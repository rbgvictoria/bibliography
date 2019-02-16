import Vue from 'vue'
import axios from 'axios'
import store from './store'
import NProgress from 'nprogress'
import '../css/nprogress.css'
NProgress.configure({
    template: '<div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><i class="fa fa-spinner fa-2x fa-spin"></i></div>'
})

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Search from './components/Search.vue'
import ReferencePage from './components/ReferencePage.vue'
import LoginPage from './components/LoginPage.vue'
import PassportDashboard from './components/PassportDashboard.vue'

let router = new VueRouter({
  mode: 'history',
  routes: [
    { 
      path: '/', 
      component: Search, 
      name: 'home',
      beforeEnter: (to, from, next) => {
        const lastRoute = JSON.parse(window.localStorage.getItem('litLastRoute'))
        if (lastRoute) {
          window.localStorage.removeItem('litLastRoute')
          next(lastRoute)
        }
        else {
          next()
        }
      }
    },
    {
      path: '/home',
      component: PassportDashboard,
      name: 'passport'
    },
    { 
      path: '/references/:id', 
      component: ReferencePage, 
      name: 'reference',
      beforeEnter: (to, from, next) => {
        store.dispatch('reference/get', to.params.id)
        next()
      }
    },
    { 
      path: '/references', 
      component: Search, 
      name: 'search',
      beforeEnter: (to, from, next) => {
        store.dispatch('citations/search', to.query )
        next()
      }
    },
    { 
      path: '/login', 
      component: LoginPage, 
      name: 'login',
      beforeEnter: (to, from, next) => {
        const lastRoute = JSON.stringify({
          name: from.name,
          params: from.params,
          query: from.query
        })
        console.log(lastRoute)
        window.localStorage.setItem('litLastRoute', lastRoute)
        next()
      }
    }
  ],
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
})

router.beforeEach((to, from, next) => {
  NProgress.start()
  let serverData = window.bibliography_server_data ? JSON.parse(window.bibliography_server_data) : null
  if (serverData) {
      store.dispatch('auth/storeAuthenticationInfo', { route: to.name, serverData })
  }
  next()
})

router.afterEach((to, from) => {
  NProgress.done()
})

export default router
