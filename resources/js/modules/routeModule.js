import Vue from 'vue'

export default {
  namespaced: true,
  state: {
    lastRoute: null
  },
  getters: {
    getLastRoute: state => state.lastRoute
  },
  mutations: {
    storeLastRoute: (state, lastRoute) => {
      Vue.set(state, 'lastRoute', lastRoute)
    }
  },
  actions: {
    storeLastRoute: function(context, lastRoute) {
      context.commit('storeLastRoute', lastRoute)
    }
  }
}