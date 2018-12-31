import Vue from 'vue'
import Citation from '../models/CitationModel'
import Pagination from '../models/PaginationModel'

export default {
  namespaced: true,
  // -----------------------------------------------------------------
  state: {
    citations: [],
    query: null,
    pagination: null
  },
  // -----------------------------------------------------------------
  getters: {
    getCitations: state => state.citations,
    getPagination: state => state.pagination,
    getQuery : state => state.query
  },
  // -----------------------------------------------------------------
  mutations: {
    storeCitations: (state, citations) => {
      Vue.set(state, 'citations', citations)
    },
    storePagination: (state, pagination) => {
      Vue.set(state, 'pagination', pagination)
    },
    storeQuery: (state, query) => {
      Vue.set(state, 'query', query)
    }
  },
  // -----------------------------------------------------------------
  actions: {
    search: function(context, params) {
      if (!params || typeof params.author === 'undefined') {
        context.commit('storeCitations', {})
        return Promise.resolve({})
      }
      const apiParams = {}
      apiParams['filter[author]'] = params.author
      if (params.page) {
        apiParams.page = params.page
      }
      return axios.get(`${process.env.MIX_REFERENCE_API_URL}/citations`, {
        params: apiParams
      }).then(response => {
        const newCollection = []
        for (const citation of response.data.data) {
          newCollection.push(new Citation(citation))
        }
        context.commit('storeCitations', newCollection)
        if (typeof response.data.meta.pagination !== 'undefined') {
          context.commit('storePagination', new Pagination(response.data.meta.pagination))
        }
        context.commit('storeQuery', params)
        return Promise.resolve(context.state.citations)
      }).catch(error => {
        context.commit('storeCitations', {})
        return Promise.reject(error)
      })
    }

  }
}
