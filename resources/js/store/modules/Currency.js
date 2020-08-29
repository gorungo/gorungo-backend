import { SET_CURRENCIES, SET_ACTIVE_CURRENCY } from '../mutation_types'
export default {
    namespaced: true,
    state: {
        // all available currencies
        currencies: [],
        activeCurrency: null,

        //
        loading: false,
    },
    actions: {
        async fetchCurrencies({commit, rootState}){
            return new Promise(async (resolve, reject) => {
                try{
                    const res = await axios.get( '/api/v' + rootState.App.apiVersion + '/currencies', { params: {
                            locale: rootState.App.locale,
                        }});
                    if (res.status === 200 && res.data !== undefined) {
                        commit(SET_CURRENCIES, res.data);
                        resolve(res);
                    }
                }catch(e){
                    reject(e);
                }
            });

        },
        setCurrencies({commit}, currencies){
            commit(SET_CURRENCIES, currencies);
        },
        setActiveCurrency({commit}, currency){
            commit(SET_ACTIVE_CURRENCY, currency);
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
        currencies(state){
            return state.currencies;
        }
    },
}
