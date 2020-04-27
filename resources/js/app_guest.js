
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//import ElementUI from 'element-ui';
import enlLocale from 'element-ui/lib/locale/lang/en';
import 'element-ui/lib/theme-chalk/index.css';
import ElementUI from "element-ui";

Vue.use(ElementUI, { enlLocale });

Vue.component('RandomIdea', require('./components/idea/RandomIdea.vue').default);
Vue.component('PlaceFilter', require('./components/filter/PlaceFilter.vue').default);
Vue.component('SeasonFilter', require('./components/filter/SeasonFilter.vue').default);
Vue.component('TimeFilter', require('./components/filter/TimeFilter.vue').default);
Vue.component('DatesFilter', require('./components/filter/DatesFilter.vue').default);
Vue.component('ItinerariesList', require('./components/ItinerariesList.vue').default);
Vue.component('IdeaItemDropdown', require('./components/idea/IdeaItemDropdown.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// version of api we use
window.systemInfo = {
    apiVersion: 'v1',
};

let app = new Vue({
    el: '#app',
    data: {}
});

