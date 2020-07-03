const state = {
    msg: 'Cargado...',
    status: false
};

const mutations = {
    setStatus(state, { msg, status }) {
        if (!status){
            status = false;
        }
        state.status = status;
        state.msg = msg
    }
};

const actions = {
    spinner({ state, commit }, { msg, status}) {
        commit('setStatus', {msg,status});
    }
};

const getters = {
    message: state => state.msg,
    status: state => state.status
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
