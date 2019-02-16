import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

import citations from './modules/citationsModule'
import reference from './modules/referenceModule'
import auth from './modules/authenticationModule'
import route from './modules/routeModule'

export default new Vuex.Store({
    modules: {
      route,
      auth,
      citations,
      reference
    }
});
