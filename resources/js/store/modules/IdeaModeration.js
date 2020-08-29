import {
    SET_NOT_MODERATED_IDEAS,
    APPROVE_IDEA,
    REFUSE_IDEA, SET_CURRENCIES,
} from '../mutation_types';

export default {
    namespaced: true,
    state: {
        ideasNotModerated: [],
    },
    actions: {
        fetchNotModeratedIdeas({commit, rootState}){
            return new Promise(async (resolve, reject) => {
                try{
                    const res = await axios.get( '/api/' + rootState.apiVersion + '/ideas', { params: {
                            locale: this.locale,
                            f: 'not-moderated',
                        }});
                    if (res.status === 200 && res.data.data !== undefined) {
                        commit(SET_NOT_MODERATED_IDEAS, res.data.data);
                        resolve(res);
                    }
                }catch(e){
                    reject(e);
                }
            });
        },

        save({commit}){

        },

        approveIdea({commit}, idea){

        },

        refuseIdea({commit}, idea){

        }
    },
    mutations: {
        [SET_NOT_MODERATED_IDEAS](state, payload){
            state.ideasNotModerated = payload;
        },
        [APPROVE_IDEA](state, payload){
            state.idea = payload;
        },
        [REFUSE_IDEA](state, payload){
            state.idea = payload;
        },
        // [UPDATE_IDEA_ATTRIBUTES_FIELD](state, {field, value}){
        //     this.set(state.idea.attributes, field, value);
        // },
        // [UPDATE_IDEA_RELATIONSHIPS_FIELD](state, {field, value}){
        //     this.set(state.idea.relationships, field, value);
        // },
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
    },
}
