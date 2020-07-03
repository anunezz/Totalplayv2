import Vue from 'vue'
import Vuex from 'vuex'
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
        loading,
        user,
        bulkLoading,
    }
});
