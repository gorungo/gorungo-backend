export default {
    namespaced: true,
    state: {
        item: null,
    },
    actions: {
        setItem({commit}, payload){
            commit('setItem', payload);
        },
    },
    mutations: {
        setItem(state, payload){
            state.item = payload;
        },
    },
    getters: {
        item(state){
            return state.item;
        },
    },
}
