export default {
    state: {
        item: null,
    },
    mutations: {
        setItem(state, payload){
            state.item = payload;
        },
    },
    actions: {
        setItem({commit}, payload){
            commit('setItem', payload);
        },
    },
    getters: {
        item(state){
            return state.item;
        },
    },
}