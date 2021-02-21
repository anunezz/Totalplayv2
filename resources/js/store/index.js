import Vue from 'vue'
import Vuex from 'vuex'
import totalplay from './modules/totalplay'
import loading from './modules/loading'
import user from './modules/user'
import bulkLoading from './modules/bulkLoadingErrors'
import createPersistedState from "vuex-persistedstate";
Vue.use(Vuex);

export default new Vuex.Store({
    plugins:[
        createPersistedState({
            key: 'bulkLoading',
            paths:['bulkLoading']
        }),

    ],
    modules: {
        totalplay,
        user,
        bulkLoading,
        loading
    }
});
