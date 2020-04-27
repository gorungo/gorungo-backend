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
                        <h5 class="p-0 m-0">{{Lang.get('menu.select_place')}}</h5>
                        <button v-if="!loading" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-cool-wrap" v-if="selectedPlace === null">
                            <input name="placeTitle" class="form-control input-cool" v-model="searchTitle" :placeholder="Lang.get('place.type_place_name')"/>
                            <span class="btn btn-link" @click="nearestHandler">Рядом</span>
                        </div>
                        <div class="spinner-grow text-dark float-right" role="status" v-if="loading" style="width: 1.5rem; height: 1.5rem;">
                            <span class="sr-only">{{Lang.get('editor.loading')}}...</span>
                        </div>
                        <p v-if="selectedPlace !== null" class="active-place">{{selectedPlace.attributes.title}} <span @click="clearPlaceHandler" class="btn btn-link float-right">{{Lang.get('editor.remove')}}</span></p>
                        <ul class="list-group list-group-flush" v-if="foundPlaces.length && !loading">
                            <li class="list-group-item" v-for="(place ,index) in foundPlaces" v-on:click="setPlaceHandler(index)">
                                {{place.attributes.title}}
                                <span class="btn btn-link float-right">{{Lang.get('editor.select')}}</span>
                            </li>
                        </ul>
                        <div v-if="noSearchResults" class="mt-2">
                            {{Lang.get('editor.nothing_found_try_to_change_query')}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click="clearFilterHandler" type="button" class="btn btn-link float-left">{{Lang.get('texts.clear')}}</button>
                        <button @click="applyFilterHandler" type="button" class="btn btn-primary">{{Lang.get('texts.apply')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PlaceSelector from '../../mixins/PlaceSelector.js';

    export default {
        name: "PlaceFilter",
        props: {
            // active place resource
            propActivePlace: {
                type: Object,
                default: function (){
                    return null;
                }

            },
            // selected section
            propSection: {
                type: String,
                default: 'places'

            },
        },
        mixins: [PlaceSelector],

        data(){
            return {
                type: 'places',
                loading: false,
                searchTitle: '',
                searchMinimum: 3,
                mode: 'select', // show or select
                activePlace: null, // items of this place already loaded
                selectedPlace: null, // place selected in window
                lastPlaces: [], // what we searched early
            }
        },

        mounted(){
            if(this.propActivePlace !== undefined && this.propActivePlace != null){
                this.activePlace = this.propActivePlace;
                this.selectedPlace = this.propActivePlace;
            }
            this.locale = Lang.getLocale();

            //this.fetchLastPlaces();
        },

        watch: {
            searchTitle(title){
                if(!this.loading && title.length >= this.searchMinimum) {
                    this.loading = true;
                    this.getRegionOrCityByTitle(title);
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
                if(this.activeDistanceFilter){
                    if(this.activeDistanceFilter === 'popular'){
                        return this.Lang.get('place.distance.popular');
                    }
                    if(this.activeDistanceFilter === 'close'){
                        return this.Lang.get('place.distance.close');
                    }
                }
                return window.go.firstToUpperCase(this.Lang.get('menu.any_place'));
            },

            activeDistanceFilter: {
                // геттер:
                get: function () {
                    let newUrl = new URL(window.location.href);
                    return newUrl.searchParams.get('distance');
                },
                // сеттер:
                set: function (newValue) {
                    console.log(newValue);
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
            },

        },

        methods:{
            setPlaceHandler(index){
                if (this.foundPlaces.length) {
                    this.selectedPlace = this.foundPlaces[index];
                }else{
                    this.selectedPlace = null;
                }
            },

            clearPlaceHandler(){
                this.selectedPlace = null;
            },

            nearestHandler(){
                //todo
            },

            updateBrowserUrl(){
                // set id param of active place
                if(this.activePlace){
                    let newUrl = new URL(window.location.href);
                    newUrl.searchParams.set( 'plid', this.activePlace.id );
                    window.location.href = newUrl;

                }else{
                    let newUrl = new URL(window.location.href);
                    newUrl.searchParams.delete('plid');
                    window.location.href = encodeURI(newUrl);
                }
            },

            applyFilterHandler(){
                this.activePlace = this.selectedPlace;
                this.updateBrowserUrl();
            },

            clearFilterHandler(){
                if(this.activePlace !== null){
                    this.selectedPlace = null;
                    this.applyFilterHandler();
                }else{
                    $('#mainPlaceFilterModal').modal('hide');
                }
            }
        }
    }
</script>

<style scoped>
    .distance-selector__item{
        cursor: pointer;
    }
    .active-place{
        line-height: 2.1rem;
    }
    .input-cool {

    }
    .input-cool-wrap{
        display: flex;
        justify-content: flex-end;
        align-content: center;
    }
    .input-cool-wrap span{
        align-content: center;
    }
</style>