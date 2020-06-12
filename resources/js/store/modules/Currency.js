import { SET_CURRENCIES, SET_ACTIVE_CURRENCY } from '../mutation_types'
export default {
    namespaced: true,
    state: {
        // all available currencies
        currencies: [],
        activeCurrency: null,
    },
    actions: {
        setCurrencies({commit}, currencies){
            commit('setItem', currencies);
        },
        setActiveCurrency({commit}, currency){
            commit('setItem', currency);
        },
    },
    mutations: {
        [SET_CURRENCIES](state, currencies){
            state.currencies = currencies;
        },
        [SET_ACTIVE_CURRENCY](state, currency){
            state.activeCurrency = currency;
        },
    },
    getters: {
        //
    },
}
