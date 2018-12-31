import Vue from 'vue'
import Reference from '../models/ReferenceModel'

export default {
  namespaced: true,

  state: {
    reference: null
  },

  getters: {
    getReference: state => state.reference
  },

  mutations: {
    storeReference: (state, reference) => {
      Vue.set(state, 'reference', reference)
    },
    updateProperty: (state, property) => {
      Vue.set(state.reference, property.name, property.value)
    },
    updateParent: (state, reference) => {
      Vue.set(state.reference, 'parent', reference)
    }
  },

  actions: {
    get: function (context, id) {
      return axios.get(`${process.env.MIX_REFERENCE_API_URL}/references/${id}`)
          .then(response => {
            context.commit('storeReference', new Reference(response.data))
            return Promise.resolve(context.state.reference)
          }).catch(error => {
            context.commit('storeReference', null)
            return Promise.reject(error)
          })
    },
    updateParent: function (context, id) {
      return axios.get(`${process.env.MIX_REFERENCE_API_URL}/references/${id}`)
          .then(response => {
            context.commit('updateParent', new Reference(response.data))
            return Promise.resolve(context.state.reference.parent)
          }).catch(error => {
            context.commit('updateParent', null)
            return Promise.reject(error)
          })
    },
    storeReference: function(context, reference) {
      context.commit('storeReference', reference)
    },
    updateProperty: function(context, property) {
      context.commit('updateProperty', property)
    },
    dropParent: function(context) {
      context.commit('updateParent', {})
    }
  }
}
