import {
    SET_IDEAS,
    SET_IDEA,
    UPDATE_IDEA_ATTRIBUTES_FIELD,
    UPDATE_IDEA_RELATIONSHIPS_FIELD, SET_CURRENCIES, SET_USER_IDEAS
} from '../mutation_types';

export default {
    namespaced: true,
    state: {
        idea: null,
        userIdeas: [],
        ideasNotModerated: [],
    },
    actions: {

        async fetchUserIdeas({commit, rootState}){
            return new Promise(async (resolve, reject) => {
                try{
                    const res = await axios.get( `/api/v${rootState.App.apiVersion}/users/${rootState.App.user.id}/ideas`, { params: {
                            locale: rootState.locale,
                        }});

                    console.log(res);
                    if (res.status === 200 && res.data !== undefined) {
                        commit(SET_USER_IDEAS, res.data);
                        resolve(res);
                    }
                }catch(e){
                    reject(e);
                }
            });

        },

        setIdea({commit}, payload){
            commit(SET_IDEA, payload);
        },

        save({commit}){

        },

        approveIdea({commit}, idea){

        },

        refuseIdea({commit}, idea){

        }
    },
    mutations: {
        [SET_IDEA](state, idea){
            state.idea = idea;
        },
        [SET_USER_IDEAS](state, ideas){
            state.userIdeas = ideas;
        },
        [UPDATE_IDEA_ATTRIBUTES_FIELD](state, {field, value}){
            this.set(state.idea.attributes, field, value);
        },
        [UPDATE_IDEA_RELATIONSHIPS_FIELD](state, {field, value}){
            this.set(state.idea.relationships, field, value);
        },
    },
    getters: {
        idea(state){
            return state.idea;
        },

        ideasNotModerated(state){
            return state.ideasNotModerated;
        },

        readyToPublish(state){
            //return state.idea.attributes.active === 1 && state.idea.attributes.is_approved === 1;
            return true;
        },

        userIdeas(state){
            return state.userIdeas;
        }
    },
}
