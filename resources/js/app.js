
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import ElementUI from 'element-ui';
import CKEditor from '@ckeditor/ckeditor5-vue';
import VueRouter from 'vue-router';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(CKEditor);
Vue.use(ElementUI);


// configure language
//locale.use(enlLocale);

//vuex --------------------
import Vuex from 'vuex';
Vue.use(Vuex);
import store from './store';
require('./store/subscriber');

window.axios.defaults.baseUrl = window.location.protocol + '//' + window.location.hostname + '/api/v' +  store.state.apiVersion;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
//
// Vue.component('CategoryEditor', require('./components/category/CategoryEditor.vue').default);
// Vue.component('ActionEditor', require('./components/action/ActionEditor.vue').default);
// Vue.component('PlaceEditor', require('./components/place/PlaceEditor.vue').default);
//
// Vue.component('IdeaEditor', require('./components/idea/IdeaEditor.vue').default);
// Vue.component('OfficeIdeasList', require('./components/office/OfficeIdeasList.vue').default);
// Vue.component('IdeaItemDropdown', require('./components/idea/IdeaItemDropdown.vue').default);
//
// Vue.component('ProfileEditor', require('./components/profile/ProfileEditor.vue').default);
//
// Vue.component('RandomIdea', require('./components/idea/RandomIdea.vue').default);
// Vue.component('PlaceFilter', require('./components/filter/PlaceFilter.vue').default);
// Vue.component('SeasonFilter', require('./components/filter/SeasonFilter.vue').default);
// Vue.component('TimeFilter', require('./components/filter/TimeFilter.vue').default);
// Vue.component('DatesFilter', require('./components/filter/DatesFilter.vue').default);
//
// Vue.component('ItinerariesList', require('./components/ItinerariesList.vue').default);

import App from './components/App';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

let router = new VueRouter({
    mode: 'history',
    routes: [
        // {
        //     path: '/ideas/:id/edit',
        //     name: 'ideas.edit.start',
        //     component: CEStartPage,
        // },
        //
        // {
        //     path: '/candidates/:id/edit/title',
        //     name: 'title',
        //     component: CETitlePage,
        // },
        // {
        //     path: '/candidates/:id/edit/city',
        //     name: 'city',
        //     component: CECityPage,
        // },
        // {
        //     path: '/candidates/:id/edit/job-positions',
        //     name: 'job-positions',
        //     component: CEJobPositionsPage,
        // },
        // {
        //     path: '/candidates/:id/edit/active',
        //     name: 'active',
        //     component: CEActivePage,
        // },
        // {
        //     path: '/candidates/:id/edit/description',
        //     name: 'description',
        //     component: CEDescriptionPage,
        // },
        // {
        //     path: '/candidates/:id/edit/education',
        //     name: 'education',
        //     component: CEEducationPage,
        // },
        // {
        //     path: '/candidates/:id/edit/experience',
        //     name: 'experience',
        //     component: CEExperiencePage,
        // },
        // {
        //     path: '/candidates/:id/edit/parameters',
        //     name: 'parameters',
        //     component: CEParametersPage,
        // },
        // {
        //     path: '/candidates/:id/edit/competencies',
        //     name: 'competencies',
        //     component: CECompetenciesPage,
        // },
        // {
        //     path: '/candidates/:id/edit/personal-qualities',
        //     name: 'personal-qualities',
        //     component: CEPersonalQualitiesPage,
        // },
        // {
        //     path: '/candidates/:id/edit/contacts',
        //     name: 'contacts',
        //     component: CEContactsPage,
        // },
        // {
        //     path: '/candidates/:id/edit/images',
        //     name: 'images',
        //     component: CEImagesPage,
        // },

    ]
});

store.dispatch('initialiseStore').then(() => {
    new Vue({
        store,
        router,
        render: h => h(App)
    }).$mount('#app');
});


