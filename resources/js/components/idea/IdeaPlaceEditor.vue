<template>
    <div id="idea-category-editor" class="category-selector">
        <!-- Category selector -->
        <div class="d-flex" style="justify-content: center;">
            <el-col :span="12">
                <el-card class="box-card text-center" shadow="never">
                    <h3 class="text-capitalize">{{Lang.get('editor.label_places')}}</h3>
                    <div class="my-4" v-if="places.length > 0"  v-for="(place, index) in places">
                        <el-card shadow="hover">
                            <div class="places-wrap">
                                <div class="place-title">{{place.attributes.title}}</div>
                                <el-button @click="removePlace(index)" type="default" icon="el-icon-delete" circle></el-button>
                            </div>
                        </el-card>
                    </div>
                    <p v-if="places.length === 0" class="text-first-uppercase">{{go.firstToUpperCase(Lang.get('itinerary.editor_no_itinerary_description'))}}</p>
                    <el-button @click="showSelectorWindow" type="primary" icon="el-icon-plus" round>{{Lang.get('editor.label_add')}}</el-button>
                </el-card>
            </el-col>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="placeSelectorModal" tabindex="-1" role="dialog" aria-labelledby="placeSelectorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content search-list">
                    <div class="modal-header">
                        <input name="placeTitle" class="w-100 form-control input-cool" v-model="searchTitle" :placeholder="Lang.get('place.type_place_name')"/>
                        <button v-if="!loading" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="spinner-grow text-dark float-right" role="status" v-if="loading" style="width: 1.5rem; height: 1.5rem;">
                            <span class="sr-only">{{Lang.get('editor.loading')}}...</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <ul class="list-group list-group-flush" v-if="foundPlaces.length && !loading">
                                <li class="list-group-item" v-for="(place ,index) in foundPlaces" v-on:click="addPlace(index)">
                                    {{place.attributes.title}}
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
    import PlaceSelector from '../../mixins/PlaceSelector.js';

    export default {

        name: "IdeaPlaceEditor",
        mixins: [ PlaceSelector, Localized ],

//------DATA-----------------------------------------------------------------------------------------------

        data(){
            return {
                type: 'places',
                searchMinimum: 3,
                mode: 'select', // show or select
                loading: false,
                selectedPlace: {},
                searchTitle: '',
                foundPlaces: [],
                places: [],
            }
        },

//------PROPERTIES-----------------------------------------------------------------------------------------------

        props: ['propPlaces', 'locale'],

        model: {
            prop: 'propPlaces',
            event: 'change',
        },

//------METHODS-----------------------------------------------------------------------------------------------

        mounted: function(){

            if(this.propPlaces){
                this.places = this.propPlaces;
            }

            $('#placeSelectorModal').on('hidden.bs.modal', function (e) {
                this.foundPlaces = [];
                this.searchTitle = '';
            });
        },

        watch: {
            searchTitle(title){
                if(!this.loading && title.length >= this.searchMinimum) {
                    this.loading = true;
                    this.getPlacesByTitle(title);
                }
            }
        },

        methods: {

            addPlace: function(index){
                this.places.push(this.foundPlaces[index]);
                this.$emit('change', this.places);

                this.closeSelectorWindow();
            },

            removePlace: function(index){
                this.places.splice(index,1);
                this.$emit('change', this.places);
            },

            showSelectorWindow: function(){
                $('#placeSelectorModal').modal('show');
            },

            closeSelectorWindow: function(){
                $('#placeSelectorModal').modal('hide');
            }

        },

//------COMPUTED-----------------------------------------------------------------------------------------------
        computed:{
            Lang(){
                return window.Lang;
            },

            noSearchResults(){
                return !this.loading && !this.foundPlaces.length && this.searchTitle.length >= this.searchMinimum;
            },

            go(){
                return window.go;
            },
        },

    }
</script>

<style scoped>
    .places-wrap{
        display: flex;
        justify-content: space-between;
    }
    .place-title{
        font-weight: bold;
    }
</style>