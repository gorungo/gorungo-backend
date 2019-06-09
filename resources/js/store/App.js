export default {
    state: {
        // authorised user
        user: null,
    },
    mutations: {
        setUser(state, payload){
            state.user = payload;
        },

    },
    actions: {
        initialiseStore({commit}) {

        },
        setUser({commit}, payload){
            commit('setUser', payload);
        },
    },
    getters: {
        user(state){
            return state.user;
        },
    },
}