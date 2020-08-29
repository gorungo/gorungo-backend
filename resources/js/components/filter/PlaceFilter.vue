<template>
    <div id="mainPlaceFilter" class="filter">
        <!-- Place filter button  -->
        <button type="button" class="filter__btn dropdown-toggle" data-toggle="modal" data-target="#mainPlaceFilterModal">
            <span class="text-first-uppercase">{{showButtonTitle}}</span>
        </button>

        <!-- Place filter modal -->
        <div class="modal fade" id="mainPlaceFilterModal" tabindex="-1" role="dialog" aria-labelledby="mainPlaceFilterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered filter-modal" role="document">
                <div class="modal-content search-list">
                    <div class="modal-header">
                        <h5 class="p-0 m-0">{{Lang.get('menu.select_place')}}</h5>
                        <button v-if="!loading" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="selectedPlace === null"  class="filter__input-wrap">
                            <i class="fas fa-search"></i><input name="placeTitle" class="form-control filter__input" v-model="searchTitle" :placeholder="Lang.get('place.type_place_name')"/>
                        </div>
                        <div v-if="selectedPlace !== null" class="filter__active-place">
                            <i class="fas fa-map-pin"></i>{{selectedPlace.attributes.title}} <span @click="clearPlaceHandler" class="btn btn-link float-right">{{Lang.get('editor.remove')}}</span>
                        </div>
                        <div class="filter__list-item filter__list-item-nearby" @click="nearestHandler">
                            <i class="fas fa-location-arrow"></i>{{Lang.get('place.distance.nearby')}}
                        </div>
                        <div class="spinner-grow text-dark float-right" role="status" v-if="loading" style="width: 1.5rem; height: 1.5rem;">
                            <span class="sr-only">{{Lang.get('editor.loading')}}...</span>
                        </div>
                        <ul class="list-group list-group-flush" v-if="foundPlaces.length && !loading">
                            <li class="list-group-item filter__list-item filter__list-item-place" :key="place.hid" v-for="(place) in foundPlaces" v-on:click="setPlaceHandler(place)">
                                <img :src="place.attributes.tmb" class="tmb" alt="tmb" />
                                <span>{{place.attributes.title}}</span>
                                <span class="btn btn-link float-right">{{Lang.get('editor.select')}}</span>
                            </li>
                        </ul>
                        <div v-if="noSearchResults" class="filter__no-results mt-2">
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
    import {getLocation, firstToUpperCase} from '../../go'

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
                filterParamName: 'pl',
                filterAttributeName: 'hid',
                loading: false,
                searchTitle: '',
                searchMinimum: 3,
                mode: 'place', // place or position
                activePlace: null, // items of this place already loaded
                selectedPlace: null, // the place selected in filter window
                lastPlaces: [], // what we searched early
                position: null,
            }
        },

        mounted(){
            if(this.propActivePlace !== undefined && this.propActivePlace !== null){
                this.activePlace = this.propActivePlace;
                this.selectedPlace = this.propActivePlace;
            }
            this.locale = Lang.getLocale();

            if(this.filterUrl && this.filterUrl.charAt(0) === 'l'){
                this.mode = 'position';
            }else{
                this.mode = 'place';
            }

            this.hideComponentPreloader();

        },

        watch: {
            searchTitle(title){
                if(!this.loading && title.length >= this.searchMinimum) {
                    this.loading = true;
                    this.getRegionOrCityByTitle(title);
                }
            },

            filterUrl(filter){
                console.log(filter);
                if(filter && filter.charAt(0) === 'l'){
                    // if filter is location coordinates
                    this.mode = 'position';
                    const location = filter.split('lng');
                    if(location.length === 2){
                        this.locations = {
                            latitude: location[0].substr(2),
                            longitude: location[1],
                        }
                    }
                }else{
                    // if filter is location hid
                    this.mode = 'place';
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
                    return firstToUpperCase(this.activePlace.attributes.title);
                }
                if(this.mode === 'position'){
                    return firstToUpperCase(this.Lang.get('place.distance.nearby'));
                }
                return firstToUpperCase(this.Lang.get('menu.any_place'));
            },

            filterUrl: {
                // геттер:
                get: function () {
                    let newUrl = new URL(window.location.href);
                    const filter = encodeURI(newUrl.searchParams.get(this.filterParamName));
                    return filter;
                },
                // сеттер:
                set: function (newValue) {
                    if(newValue){
                        let newUrl = new URL(window.location.href);
                        newUrl.searchParams.set(this.filterParamName, encodeURI(newValue.toString()));
                        window.location.href = newUrl;
                    }else{
                        let newUrl = new URL(window.location.href);
                        newUrl.searchParams.delete(this.filterParamName);
                        window.location.href = newUrl;
                    }
                }
            },

        },

        methods:{
            setPlaceHandler(place){
                this.mode = 'place';
                this.selectedPlace = place;
            },

            clearPlaceHandler(){
                this.selectedPlace = null;
            },

            hideComponentPreloader(){
                const f = document.querySelector('.fw-fake');
                if(f){
                    f.classList.remove('fw-fake');
                }
            },

            async nearestHandler(){
                this.mode = 'position';
                this.loading = true;

                try{
                    const position = await getLocation();
                    this.position = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                    };

                }catch(e){
                    console.log('Не могу получить местоположение');
                    this.position = null;
                }

                this.loading = false;
            },

            applyFilterHandler(){
                if(this.mode === 'place'){
                    if(this.selectedPlace){
                        this.activePlace = this.selectedPlace;
                        this.filterUrl = this.activePlace[this.filterAttributeName];
                    }else{
                    }
                }else if(this.mode === 'position'){
                    this.filterUrl = `lat${this.position.latitude}lng${this.position.longitude}`;
                }else{
                    this.filterUrl = null;
                }
                $('#mainPlaceFilterModal').modal('hide');
            },

            clearFilterHandler(){
                this.selectedPlace = null;
                this.activePlace = null;
                this.filterUrl = null;
                $('#mainPlaceFilterModal').modal('hide');
            },


        }
    }
</script>

<style scoped lang="scss">
    //@import 'resources/sass/filter.scss';
    .filter{
        .filter__input-wrap{
            display: flex;
            padding: 0.5rem 1rem;
            align-items: center;
            i{
                width: 2rem;
                margin-right: 1rem;
                text-align: center;
            }
            .filter__input{
                font-weight: bold;
                border-radius: unset;
                border: none;
                padding: 1.5rem 0;
                margin: 0;
                font-size: 18px;
                border-bottom: 2px solid black;
            }
            .filter__input:focus{
                box-shadow: none;
            }
        }
        .filter__active-place, .filter__input-wrap{

        }
        .filter__active-place, .filter__list-item{
            padding: 1rem;
            i{
                width: 2rem;
                margin-right: 1rem;
                text-align: center;
            }
            .tmb{
                height: 2rem;
                width: 2rem;
                margin-right: 1rem;
                object-fit: cover;
            }
        }
        .filter__list-item{
            cursor: pointer;
            .btn {
                padding: 0;
            }
        }
        .filter__list-item:hover{
            background: #f8f8f8;
        }
        .filter__no-results{
            padding: 1rem;
            text-align: center;
        }
        .modal-body{
            padding: 0;
        }
    }


</style>
