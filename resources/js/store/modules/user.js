import {getIPs, getIPv4, getIPv6} from 'webrtc-ips';

// Initial state
const state = {
    hash_id				: null,
    fullname			: null,
    name				: null,
    firstName			: null,
    secondName			: null,
    profile				: null,
    username            : null
};

// Getters
const getters = {

};

// Actions
const actions = {
    getUserInfo({dispatch, commit}){
        return new Promise((resolve, reject) => {
            // Action to fix sesion user information if window browser is refreshed.
            if ( window.sessionStorage.getItem("access_token") ) {
                dispatch('getUserIP')
                    .then(()  => { resolve() })
                    .catch(() => { reject() });
            } else {
                dispatch('logout');
                commit('deleteUser');
                reject();
            }
        });
    },
    sessionInfo({dispatch, commit}, ip){

        return new Promise( (resolve, reject) => {
            axios.get("/api/user/" + window.sessionStorage.getItem("access_hash"), { params: { ip: ip } })
                .then(response => {
                    commit("setUser", response.data.user);
                    resolve();
                })
                .catch(error => {
                    dispatch('logout');
                    commit('deleteUser');
                    reject();
                });
        });

    },
    logout(){
        console.log("store");
        sessionStorage.removeItem("access_token");
        sessionStorage.removeItem("access_token_expiration");
        sessionStorage.removeItem("access_hash");

        axios.defaults.headers.common = {
            'Authorization': 'Bearer'
        };
    },
    getUserIP({dispatch, commit}) {

        return new Promise( (resolve, reject) => {

            getIPs()
                .then(ip => {
                    dispatch('sessionInfo', ip)
                        .then(()  => {
                            //console.log("ip usuario: ",ip);
                            resolve();
                        })
                        .catch(() => { reject() });
                })
                .catch((error) => { reject() });

        });

    }
};

// Mutations
const mutations = {
    setUser: (state, user) => {
        console.log("usuario: ",user);
        state.hash_id			= user.hash_id;
        state.fullname			= user.fullname;
        state.name				= user.name;
        state.firstName			= user.firstName;
        state.secondName		= user.secondName;
        state.profile			= user.profile;
        state.username          = user.username;
    },
    setPasswordUpdated: state => {
        state.needUpdatePass = false;
    },
    deleteUser: state => {
        state.hash_id			= null;
        state.fullname			= null;
        state.name				= null;
        state.firstName			= null;
        state.secondName		= null;
        state.profile			= null;
        state.username			= null;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
