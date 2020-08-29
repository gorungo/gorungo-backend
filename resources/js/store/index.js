import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
import App from './modules/App';
import Idea from './modules/Idea';
import Profile from './modules/Profile';
import Currency from './modules/Currency';

export default new Vuex.Store({
    modules:{
        App,
        Idea,
        Profile,
        Currency
    },
});
