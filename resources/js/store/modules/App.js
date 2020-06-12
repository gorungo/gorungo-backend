export default {
    state: {
        // authorised user
        user: null,
    },
    actions: {
        initialiseStore({commit}) {

        },
        setUser({commit}, payload){
            commit('setUser', payload);
        },
    },
    mutations: {
        setUser(state, payload){
            state.user = payload;
        },
    },
    getters: {
        user(state){
            return state.user;
        },
    },
}
