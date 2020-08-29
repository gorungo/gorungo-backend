import {
    SET_FOUND_PLACES,
    SET_PLACE,
    SET_USER_PLACES,
    UPDATE_PLACE_ATTRIBUTES_FIELD,
    UPDATE_PLACE_RELATIONSHIPS_FIELD,
} from '../mutation_types';

export default {
    namespaced: true,
    state: {
        place: null,
        userPlaces: [],
        foundPlaces: [],
    },
    actions: {

        async findPlacesByTitle({commit, rootState}, title) {
            return new Promise(async (resolve, reject) => {
                try {
                    const res = await axios.get(`/api/v${rootState.App.apiVersion}/osm/search`, {
                            params: {
                                locale: rootState.locale,
                                title
                            }
                        });

                    console.log(res);
                    if (res.status === 200 && res.data !== undefined) {
                        commit(SET_USER_PLACES, res.data);
                        resolve(res);
                    }
                } catch (e) {
                    reject(e);
                }
            });

        },

        setIdea({commit}, payload) {
            commit(SET_PLACE, payload);
        },

        save({commit}) {

        },

        approveIdea({commit}, idea) {

        },

        refuseIdea({commit}, idea) {

        }
    },
    mutations: {
        [SET_PLACE](state, idea) {
            state.idea = idea;
        },
        [SET_FOUND_PLACES](state, places) {
            state.foundPlaces = places;
        },
        [SET_USER_PLACES](state, places) {
            state.userPlace = places;
        },
        [UPDATE_PLACE_ATTRIBUTES_FIELD](state, {field, value}) {
            this.set(state.idea.attributes, field, value);
        },
        [UPDATE_PLACE_RELATIONSHIPS_FIELD](state, {field, value}) {
            this.set(state.idea.relationships, field, value);
        },
    },
    getters: {},
}
