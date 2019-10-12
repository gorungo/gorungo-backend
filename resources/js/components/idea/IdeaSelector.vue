<template>
    <div id="ideas-selector" class="ideas-selector">
        <h5 class="text-capitalize">{{Lang.get('idea.title')}}</h5>
        <!-- Idea selector -->
        <div class="row">
            <div v-if="idea && multiselect" class="col-sm-4" v-for="(ideaItem, index) in idea">
                <div class="card card-body">
                    <div>
                        {{ideaItem.attributes.title}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="removeIdea(index)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" v-if="idea && !multiselect">
                <div class="card card-body">
                    <div>
                        {{idea.attributes.title}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="removeIdea(0)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" v-if="needAddButton">
                <span class="btn btn-link" data-toggle="modal" data-target="#ideasSelectorModal"><span class="glyphicon glyphicon-pencil"> </span><span class="text-capitalize">{{Lang.get('editor.label_add')}}</span></span>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ideasSelectorModal" tabindex="-1" role="dialog" aria-labelledby="ideasSelectorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content search-list">
                    <div class="modal-header">
                        <input name="ideaTitle" class="w-100 form-control input-cool" v-model="searchTitle" :placeholder="Lang.get('idea.type_idea_title')"/>
                        <button v-if="!loading" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="spinner-grow text-dark float-right" role="status" v-if="loading" style="width: 1.5rem; height: 1.5rem;">
                            <span class="sr-only">{{Lang.get('editor.loading')}}...</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <ul class="list-group list-group-flush" v-if="foundIdeas.length && !loading">
                                <li class="list-group-item" v-for="(idea ,index) in foundIdeas" v-on:click="addIdea(index)">
                                    {{idea.attributes.title}}
                                    <span class="btn btn-link float-right">{{Lang.get('editor.select')}}</span>
                                </li>
                            </ul>
                            <div v-if="noSearchResults" class="mt-2">
                                {{Lang.get('editor.nothing_found_try_to_change_query')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Localized from '../../mixins/Localized.js';
    export default {

        name: "IdeaSelector",
        mixins: [Localized],

//------DATA-----------------------------------------------------------------------------------------------

        data(){
            return {
                type: 'ideas',
                idea: null,
                searchMinimum: 3,
                mode: 'select', // show or select
                loading: false,
                selectedIdea: {},
                searchTitle: '',
                foundIdeas: [],
                multiselect: false,

            }
        },

        model: {
            prop: 'propIdea',
            event: 'change',
        },

//------PROPERTIES-----------------------------------------------------------------------------------------------

        props: ['propIdea', 'locale', 'propMultiselect'],

//------METHODS-----------------------------------------------------------------------------------------------

        mounted: function(){
            $('#ideasSelectorModal').on('hidden.bs.modal', function (e) {
                this.foundIdeas = [];
                this.searchTitle = '';
            });

            if (this.propMultiselect !== undefined && this.propMultiselect === true){
                this.multiselect = this.propMultiselect;
            }

            if (this.propIdea !== undefined && this.propIdea != null){
                this.idea = this.propIdea;
            }else{
                if(this.multiselect){
                    this.idea = [];
                }else{
                    this.idea = null;
                }
            }


        },

        watch: {
            searchTitle(title){
                if(!this.loading && title.length >= this.searchMinimum) {
                    this.loading = true;
                    this.getIdeasByTitle(title);
                }
            }
        },

        methods: {

            addIdea: function(index){
                if(this.multiselect) {
                    this.idea.push(this.foundIdeas[index]);
                }else{
                    this.idea = this.foundIdeas[index];
                }
                this.$emit('change', this.idea);
                this.closeSelectorWindow();
            },

            removeIdea: function(index){
                if(this.multiselect){
                    this.idea.splice(index,1);
                }else{
                    this.idea = null;
                }

            },

            closeSelectorWindow: function(){
                $('#ideasSelectorModal').modal('hide');
            },

            getIdeasByTitle:
                _.debounce(function(title){

                    this.foundIdeas = [];

                    axios.get( this.ideasByTitleRequestUrl(), { params:{
                            locale: this.locale,
                            title: title,
                        } } )
                        .then( (resp) => {
                            if (resp.status === 200) {
                                this.dataLoaded = true;
                                this.foundIdeas = resp.data.data;
                            }

                        }).catch( (error) => {

                        if (error.response === undefined) {
                            userui.showNoInternetNotification();
                        }

                    }).finally( () => {
                        this.loading = false;
                    })


                }, 500),

            ideasByTitleRequestUrl: function(){
                return '/api/' + window.systemInfo.apiVersion + '/' + this.type + '/getByTitle' ;
            },

        },

//------COMPUTED-----------------------------------------------------------------------------------------------
        computed:{
            Lang(){
                return window.Lang;
            },

            noSearchResults(){
                return !this.loading && !this.foundIdeas.length && this.searchTitle.length >= this.searchMinimum;
            },

            needAddButton(){
                return (this.idea == null && !this.multiselect) || (this.multiselect)
            }
        },

    }
</script>

<style scoped>

</style>