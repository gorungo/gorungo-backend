import {
    SET_USER,
    SET_TOKEN,
} from '../mutation_types';
export default {
    state: {
        // authorised user
        user: window.activeUser,
        token: null,
        apiVersion: 1,
        locale: 'ru',
    },
    actions: {
        initialiseStore({dispatch, state}) {
            if(localStorage.getItem('token')){
                dispatch('attempt', localStorage.getItem('token'));
            }
            if(state.token){
                dispatch('attempt', state.token);
            }
        },

        setUser({commit}, user){
            commit(SET_USER, user);
        },

        async signIn({dispatch}, credentials){
            let resp = axios.post('auth/signin', credentials);
            return dispatch('attempt', resp.data.token);
        },

        async attempt({commit, state}, token){
            if(token){
                commit(SET_TOKEN, token);
            }

            if(state.token){
                try{
                    let resp = await axios.post('auth/me');
                    commit(SET_USER, resp.data);
                }catch(e){
                    commit(SET_USER, null);
                    commit(SET_TOKEN, null);
                }
            }
        }

    },
    mutations: {
        [SET_USER](state, user){
            state.user = user;
        },
        [SET_TOKEN](state, token){
            state.token = token;
        },
    },
    getters: {
        authenticated(state){
            return state.user && state.token;
        },
        user(state){
            return state.user;
        },
        apiVersion(state){
            return state.apiVersion;
        }
    },
}
