<template>
    <div id="idea-category-editor" class="category-selector">
        <!-- Category selector -->
        <div class="d-flex" style="justify-content: center;">
            <el-col :span="12">
                <el-card class="box-card text-center" shadow="never">
                    <h3 class="text-capitalize">{{Lang.get('editor.label_categories')}}</h3>
                    <div class="my-4" v-if="categories.length > 0" v-for="(category, index) in categories">
                        <el-card shadow="hover">
                            <div class="categories-wrap">
                                <div class="category-title">{{category.attributes.title}}</div>
                                <el-button @click="removeCategory(index)" type="default" icon="el-icon-delete" circle></el-button>
                            </div>
                        </el-card>
                    </div>
                    <p v-if="categories.length === 0" class="text-first-uppercase">{{go.firstToUpperCase(Lang.get('itinerary.editor_no_itinerary_description'))}}</p>
                    <el-button v-if="canAddCategory" @click="showSelectorWindow" type="primary" icon="el-icon-plus" round>{{Lang.get('editor.label_add')}}</el-button>
                </el-card>
            </el-col>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="categorySelectorModal" tabindex="-1" role="dialog" aria-labelledby="categorySelectorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content search-list">
                    <div class="modal-header">
                        <input name="searchTitle" class="w-100 form-control input-cool" v-model="searchTitle" :placeholder="Lang.get('editor.label_tape_category_name')"/>
                        <button v-if="!loading" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="spinner-grow text-dark float-right" role="status" v-if="loading" style="width: 1.5rem; height: 1.5rem;">
                            <span class="sr-only">{{Lang.get('editor.loading')}}...</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <ul class="list-group list-group-flush" v-if="allCategories.length && !loading">
                                <li class="list-group-item" v-for="(category ,index) in allCategories" v-on:click="addCategory(index)">
                                    {{category.attributes.title}}
                                    <span class="btn btn-link float-right">{{Lang.get('editor.to_select')}}</span>
                                </li>
                            </ul>
                            <div v-if="noSearchResults" class="mt-2">
                                {{Lang.get('editor.label_nothing_found')}}
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
        name: "IdeaCategoryEditor",
        mixins: [Localized],

//------DATA-----------------------------------------------------------------------------------------------

        data(){
            return {
                type: 'categories',
                searchMinimum: 3,
                mode: 'select', // show or select
                loading: false,
                selectedCategories: {},
                allCategories: [],
                searchTitle: '',
                foundPlaces: [],
            }
        },

        model: {
            prop: 'categories',
            event: 'change'
        },

//------PROPERTIES-----------------------------------------------------------------------------------------------

        props: {
            categories: Array,
            locale: String,
            isSingleCategoryMode: Boolean,
        },

//------METHODS-----------------------------------------------------------------------------------------------

        mounted: function(){
            $('#CategorySelectorModal').on('hidden.bs.modal', function (e) {
                this.foundPlaces = [];
                this.searchTitle = '';
            });
        },

        watch: {
            searchTitle(title){
                if(this.allCategories.length){
                    this.findInAllCatgories(title);
                }
            }
        },

        computed:{
            noSearchResults(){
                return !this.loading && !this.foundPlaces.length && this.searchTitle.length >= this.searchMinimum;
            },
            canAddCategory(){
                if(this.isSingleCategoryMode){
                    if(this.categories.length === 0) {
                        return true
                    }
                }else{
                    if(this.categories.length < 10) {
                        return true
                    }
                }

                return false;
            },

            go(){
                return window.go;
            },
        },

        methods: {

            getAllCategories(){
                this.foundPlaces = [];

                axios.get( this.fetchUrl(), { params:{
                        locale: this.locale,
                        title: '',
                    } } )
                    .then( (resp) => {
                        if (resp.status === 200) {
                            this.dataLoaded = true;
                            this.allCategories = resp.data.data;
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

            fetchUrl: function(){
                return '/api/' + window.systemInfo.apiVersion + '/' + this.type + '/children'  ;
            },

            addCategory: function(index){
                this.categories.push(this.allCategories[index]);
                this.$emit('change', this.categories);
                this.closeSelectorWindow();
            },

            removeCategory: function(index){
                this.categories.splice(index,1);
                this.$emit('change', this.categories);
            },

            showSelectorWindow(){
                this.getAllCategories();
                $('#categorySelectorModal').modal('show');
            },

            closeSelectorWindow: function(){
                $('#categorySelectorModal').modal('hide');
            },

        },

//------COMPUTED-----------------------------------------------------------------------------------------------


    }
</script>

<style scoped>
    .categories-wrap{
        display: flex;
        justify-content: space-between;
    }
    .category-title{
        font-weight: bold;
    }
</style>