
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use( CKEditor );

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
Vue.component('ProfileEditor', require('./components/profile/ProfileEditor.vue').default);

Vue.component('RandomIdea', require('./components/idea/RandomIdea.vue').default);
Vue.component('MainPlaceFilter', require('./components/place/MainPlaceFilter.vue').default);


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

