import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import ActionEdit from './ActionEdit'
import App from './App'


export default new Vuex.Store({
    modules:{
        App,
        ActionEdit
    },

    beforeCreate() {
        this.$store.dispatch('initialiseStore');
    }
});