export default {
  namespaced: true,

  state: {
    auth: false,
    user: {}
  },

  getters: {
    checkAuth: state => state.auth,
    getUser: state => state.user
  },

  mutations: {
    setAuth(state, auth) {
      state.auth = auth
    },
    setUser(state, user) {
      state.user = user
    }
  },

  actions: {
    storeAuthenticationInfo: function(context, data) {
      if (data.serverData.auth) {
        context.commit('setAuth', data.serverData.auth)
        context.commit('setUser', data.serverData.user)
      }
    },
    deleteAuthenticationInfo: function(context) {
      context.commit('setAuth', false)
      context.commit('setUser', {})
    }
  }
}