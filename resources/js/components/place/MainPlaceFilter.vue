<template>
    <div id="mainPlaceFilter">
        <!-- Place filter button  -->
        <button type="button" class="btn btn-lg btn-outline-success dropdown-toggle" data-toggle="modal" data-target="#mainPlaceFilterModal">
            {{showButtonTitle}}
        </button>

        <!-- Place filter modal -->
        <div class="modal fade" id="mainPlaceFilterModal" tabindex="-1" role="dialog" aria-labelledby="mainPlaceFilterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
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
                            <div v-if="searchTitle.length === 0" id="mainPlaceFilterModalDistanceSelector" style="justify-content: space-evenly;" class="d-flex distance-selector">
                                <span @click="activeDistanceFilter = 'popular'" class="distance-selector__item" :class="{active: activeDistanceFilter === 'popular'}">{{Lang.get('place.distance.popular')}}</span>
                                <span @click="activeDistanceFilter = null" class="distance-selector__item" :class="{active: activeDistanceFilter === null}">{{Lang.get('place.distance.any')}}</span>
                                <span @click="activeDistanceFilter = 'close'" class="distance-selector__item" :class="{active: activeDistanceFilter === 'close'}">{{Lang.get('place.distance.close')}}</span>
                            </div>
                            <ul class="list-group list-group-flush" v-if="foundPlaces.length && !loading">
                                <li class="list-group-item" v-for="(place ,index) in foundPlaces" v-on:click="setPlace(index)">
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
    import PlaceSelector from '../../mixins/PlaceSelector.js';

    export default {
        name: "MainPlaceFilter",
        props: ['propActivePlace'],
        mixins: [PlaceSelector],

        data(){
            return {
                type: 'places',
                loading: false,
                searchTitle: '',
                searchMinimum: 3,
                mode: 'select', // show or select
                activePlace: null,
            }
        },

        mounted(){
            if(this.propActivePlace !== undefined && this.propActivePlace != null){
                this.activePlace = this.propActivePlace;
            }
            this.locale = Lang.getLocale();
        },

        watch: {
            searchTitle(title){
                if(!this.loading && title.length >= this.searchMinimum) {
                    this.loading = true;
                    this.getPlacesByTitle(title);
                }
            }
        },

        computed:{
            Lang(){
                return window.Lang;
            },

            noSearchResults(){
                return !this.loading && !this.foundPlaces.length && this.searchTitle.length >= this.searchMinimum;
            },

            showButtonTitle(){
                if(this.activePlace){
                    return this.activePlace.attributes.title;
                }
                return this.Lang.get('place.select_place');
            },

            activeDistanceFilter: {
                // геттер:
                get: function () {
                    let newUrl = new URL(window.location.href);
                    return newUrl.searchParams.get('distance');
                },
                // сеттер:
                set: function (newValue) {
                    if(newValue){
                        let newUrl = new URL(window.location.href);
                        newUrl.searchParams.set( 'distance', newValue );
                        window.location.href = newUrl;
                    }else{
                        let newUrl = new URL(window.location.href);
                        newUrl.searchParams.delete('distance');
                        window.location.href = newUrl;
                    }
                }
            }
        },

        methods:{
            setPlace(index){
                if (this.foundPlaces.length) {
                    this.activePlace = this.foundPlaces[index];
                    this.updateBrowserUrl();
                }else{
                    this.activePlace = null;
                }
            },

            updateBrowserUrl(){
                // set id param of active place
                if(this.activePlace){
                    let newUrl = new URL(window.location.href);
                    newUrl.searchParams.set( 'plid', this.activePlace.id );
                    window.location.href = newUrl;

                }
                if(this.activeDistanceFilter){
                    let newUrl = new URL(window.location.href);
                    newUrl.searchParams.set( 'distance', this.activePlace.id );
                    window.location.href = newUrl;

                }

            },
        }
    }
</script>

<style scoped>

</style>