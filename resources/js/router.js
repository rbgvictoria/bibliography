import Vue from 'vue';
import axios from 'axios';
import store from './store';
import NProgress from 'nprogress';
import '../css/nprogress.css';
NProgress.configure({
    template: '<div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><i class="fa fa-spinner fa-2x fa-spin"></i></div>'
});

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Search from './components/Search.vue';
import ReferenceForm from './components/ReferenceForm.vue';

let router = new VueRouter({
  mode: 'history',
  routes: [
    { 
      path: '/', 
      component: Search, 
      name: 'home' 
    },
    { 
      path: '/references/:id', 
      component: ReferenceForm, 
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
    }

  ],
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
});

router.beforeEach((to, from, next) => {
  NProgress.start()
  next()
})

router.afterEach((to, from) => {
  NProgress.done()
})

export default router;
