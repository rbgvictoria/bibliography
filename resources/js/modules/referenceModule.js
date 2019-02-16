import Vue from 'vue'
import Reference from '../models/ReferenceModel'
import Author from '../models/AuthorModel'

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
      if (property.name === 'contributors') {
        context.commit('updateProperty', {
          name: 'authorId',
          value: null
        })
      }
    },
    dropParent: function(context) {
      context.commit('updateParent', {})
    },
    reset: (context, ref) => {
      context.commit('storeReference', ref)
    },
    storeAgent: function(context, {agent, contributor}) {
      return axios.post(`/api/agents`, agent)
          .then(response => {
            const contributors = context.state.reference.contributors
            contributors[contributor.sequence].agent = response.data
            context.commit('updateProperty', {
              name: 'contributors',
              value: contributors
            })
            context.commit('updateProperty', {
              name: 'authorString',
              value: Reference.getAuthorString(context.state.reference)
            })
          }).catch(error => {
            console.log(error)
          })

    },
    updateReference: function(context, reference) {
      //delete reference.contributors
      delete reference.authorString
      delete reference.book
      delete reference.journal
      return axios.put('/api/references/' + reference.id, reference)
          .then(response => {
            context.commit('storeReference', new Reference(response.data))
            return Promise.resolve(context.state.reference)
          })
    }
  }
}
