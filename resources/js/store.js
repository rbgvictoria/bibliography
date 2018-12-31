import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

import citations from './modules/citationsModule'
import reference from './modules/referenceModule'

export default new Vuex.Store({
    modules: {
      citations,
      reference
    }
});
