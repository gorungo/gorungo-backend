import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

import ActionEdit from './ActionEdit'


export default new Vuex.Store({
    modules:{
        ActionEdit
    }
});