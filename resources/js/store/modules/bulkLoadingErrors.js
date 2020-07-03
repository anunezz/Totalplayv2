const state = {
    errorsBulk: [],
    indexEdit:null,
};

const mutations = {
    addRows(state, data){
        state.errorsBulk = data;
    },
    deleteRow(state,data){
        state.errorsBulk.splice(data, 1);
    },
    indexRow(state,data){
        state.indexEdit = data;
    }
};

const actions = {
    addRows({commit}, data) {
        commit('addRows', data)
    },
    deleteRow({commit}, data){
        commit('deleteRow', data)
    },
    indexRow({commit}, data){
        commit('indexRow', data);
    }
};

const getters = {
    errorsBulk: state => state.errorsBulk,
    editRow: (state) => (index) => {
        return state.errorsBulk[index]
    },
    indexEdit : state => state.indexEdit
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
