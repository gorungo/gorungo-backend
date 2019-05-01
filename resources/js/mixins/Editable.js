import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import Errors from '../components/Errors.vue';
export default {

    props: ['propTitle', 'propUser', 'propCityId', 'propItemId', 'propLocale'],
    components: {Errors},

    data(){
        return{

            // system state
            cityId: 4741,
            locale: 'en',

            // item info ----------------------------
            type: 'actions',
            item: null,

            // --------------------------------------
            dataLoaded: false,
            hasPageChanges: false,
            loading: false,
            errors: null,

            editor: ClassicEditor,
            editorConfig: {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ]
            }

        }
    },

    mounted: function () {

        this.test();
        this.initialise();

    },

    watch: {

        dataLoaded: function(val){
            if(val === true){
                document.title = this.documentTitle;
                this.title = this.documentTitle;
            }
        },

        loading: function(val){
            if(val === true){
                userui.showProgress();
            }else{
                userui.hideProgress();
            }
        },

        itemId: function(val){
            document.title = this.documentTitle;
            this.title = this.documentTitle;
        }

    },

    computed: {

        itemId: function(){

            if(this.item !== null && this.item.id !== null) {
                return this.item.id;
            }

            if(this.propItemId !== undefined && this.propItemId !== null){
                return this.propItemId;
            }

            return null;
        },


    },

    methods: {

        /**
         *  testing component
         */

        test: function(){
            console.log('component mounted');
        },

        /**
         *  initialising component, loading data
         */

        initialise: function (){
            this.locale = this.getBrowserLocale();
            this.fetch();
            document.title = this.documentTitle;

        },

        /**
         * get item data
         */

        fetch: function(){

            axios.get( this.fetchRequestUrl(), {
                params: this.fetchRequestParams() } )
                .then( (resp) => {

                    this.loading = true;
                    if (resp.status === 200) {
                        this.dataLoaded = true;
                        this.item = resp.data.data;
                    }

                }).catch( (error) => {

                if (error.response === undefined) {
                    userui.showNoInternetNotification();
                }
                this.loading = false;

            }).finally( () => {
                this.loading = false;
            })

        },

        /**
         * save new / update item data
         */

        save: function(){

            axios({
                method: this.saveMethod(),
                url: this.saveRequestUrl(),
                data: this.item,

            }).then( (resp) => {

                this.loading = true;
                this.errors = null;

                if (resp.status === 200) {

                    if(resp.data.data.id !== null ){

                        this.updateBrowserUrl(resp.data.data.edit_url);

                        if(this.itemId === null){
                            this.item.id = resp.data.data.item.id;
                            this.item.url = resp.data.data.item.url;
                        }

                        this.loading = false;

                        userui.showNotification('Успешно сохранено', 'green');
                    }else{
                        userui.showNoInternetNotification();
                    }


                }

            }).catch( (error) => {

                if(error.response){
                    if(error.response.data.errors){
                        this.errors = error.response.data.errors;
                    }
                }

                if (error.response === undefined) {
                    userui.showNoInternetNotification();
                }

                this.loading = false;

            }).finally( () => {
                this.loading = false;
            })
        },


        formSubmit: function(){
            this.hasPageChanges = false;
            this.save();
        },



        updateBrowserUrl: function(editUrl){
            if(editUrl) history.replaceState(this.item, this.documentTitle, editUrl);
        },

        // get request url
        fetchRequestUrl: function(){
            if(this.itemId === null){
                return this.saveRequestUrl() + '/create' ;
            }else{
                return this.saveRequestUrl() + '/edit' ;
            }
        },

        fetchRequestParams(){
            return {
                locale: this.locale,
            }
        },

        // post / patch request url
        saveRequestUrl: function(){

            if(this.itemId === null){
                return '/api/' + window.systemInfo.apiVersion + '/' + this.type ;
            }else{
                return '/api/' + window.systemInfo.apiVersion + '/' + this.type + '/' + this.itemId;
            }


        },

        saveMethod: function(){
            let saveMethod = 'post';

            if(this.itemId !== null){
                saveMethod = 'patch';
            }

            return saveMethod;
        },

        getBrowserLocale: function() {
            return document.documentElement.lang;
        }

    }
}