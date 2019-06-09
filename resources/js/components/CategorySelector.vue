<template>
    <div id="place-selector" class="place-selector">
        <h5 v-if="isSingleCategoryMode">Главная категория</h5>
        <h5 v-else>Категории</h5>
        <!-- Place selector -->
        <div class="row">
            <div class="col-sm-3" v-for="(category, index) in categories">
                <div class="card card-body">
                    <div>
                        {{category.attributes.title}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="removeCategory(index)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <span v-if="canAddCategory" v-on:click="showSelectorWindow()" class="btn btn-link" data-toggle="modal" data-target="#placeSelectorModal"><span class="glyphicon glyphicon-pencil"> </span>Добавить</span>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="categorySelectorModal" tabindex="-1" role="dialog" aria-labelledby="categorySelectorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content search-list">
                    <div class="modal-header">
                        <input name="searchTitle" class="w-100 form-control input-cool" v-model="searchTitle" placeholder="Введите название категории"/>
                        <button v-if="!loading" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="spinner-grow text-dark float-right" role="status" v-if="loading" style="width: 1.5rem; height: 1.5rem;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <ul class="list-group list-group-flush" v-if="allCategories.length && !loading">
                                <li class="list-group-item" v-for="(category ,index) in allCategories" v-on:click="addCategory(index)">
                                    {{category.attributes.title}}
                                    <span class="btn btn-link float-right">Выбрать</span>
                                </li>
                            </ul>
                            <div v-if="noSearchResults" class="mt-2">
                                Ничего не нашли, измените ваш запрос
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "CategorySelector",

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
            }
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

</style>