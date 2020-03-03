
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import ElementUI from 'element-ui';
import CKEditor from '@ckeditor/ckeditor5-vue';
import enlLocale from 'element-ui/lib/locale/lang/en';
import rulLocale from 'element-ui/lib/locale/lang/ru-RU';
import cnlLocale from 'element-ui/lib/locale/lang/zh-CN';
import locale from 'element-ui/lib/locale'
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(CKEditor);
Vue.use(ElementUI, { locale });

// configure language
locale.use(enlLocale);

//vuex --------------------
//import Vuex from 'vuex';
//Vue.use(Vuex);
//import store from './store';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('CategoryEditor', require('./components/category/CategoryEditor.vue').default);
Vue.component('ActionEditor', require('./components/action/ActionEditor.vue').default);
Vue.component('PlaceEditor', require('./components/place/PlaceEditor.vue').default);

Vue.component('IdeaEditor', require('./components/idea/IdeaEditor.vue').default);
Vue.component('DatesAndPricesEditor', require('./components/idea/DatesAndPricesEditor.vue').default);
Vue.component('ItineraryEditor', require('./components/idea/ItineraryEditor.vue').default);

Vue.component('ProfileEditor', require('./components/profile/ProfileEditor.vue').default);

Vue.component('RandomIdea', require('./components/idea/RandomIdea.vue').default);
Vue.component('MainPlaceFilter', require('./components/place/MainPlaceFilter.vue').default);
Vue.component('SeasonFilter', require('./components/filter/SeasonFilter.vue').default);
Vue.component('TimeFilter', require('./components/filter/TimeFilter.vue').default);

Vue.component('ItinerariesList', require('./components/ItinerariesList.vue').default);


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

