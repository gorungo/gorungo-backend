<template>
    <div id="place-selector" class="place-selector">
        <h5>Места</h5>
        <!-- Place selector -->
        <div class="row">
            <div class="col-sm-4" v-for="(place, index) in places">
                <div class="card card-body">
                    <div>
                        {{place.attributes.title}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="removePlace(index)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <span class="btn btn-link" data-toggle="modal" data-target="#placeSelectorModal"><span class="glyphicon glyphicon-pencil"> </span>Добавить</span>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="placeSelectorModal" tabindex="-1" role="dialog" aria-labelledby="placeSelectorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content search-list">
                    <div class="modal-header">
                        <input name="placeTitle" class="w-100 form-control input-cool" v-model="searchTitle" placeholder="Введите название места"/>
                        <button v-if="!loading" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="spinner-grow text-dark float-right" role="status" v-if="loading" style="width: 1.5rem; height: 1.5rem;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <ul class="list-group list-group-flush" v-if="foundPlaces.length && !loading">
                                <li class="list-group-item" v-for="(place ,index) in foundPlaces" v-on:click="addPlace(index)">
                                    {{place.attributes.title}}
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
        name: "PlaceSelector",

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
            }
        },

//------PROPERTIES-----------------------------------------------------------------------------------------------

        props: ['places', 'locale'],

//------METHODS-----------------------------------------------------------------------------------------------

        mounted: function(){
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

        computed:{
            noSearchResults(){
                return !this.loading && !this.foundPlaces.length && this.searchTitle.length >= this.searchMinimum;
            }
        },

        methods: {

            getPlacesByTitle:
                _.debounce(function(title){

                    this.foundPlaces = [];

                    axios.get( this.placesByTitleRequestUrl(), { params:{
                            locale: this.locale,
                            title: title,
                        } } )
                        .then( (resp) => {
                            if (resp.status === 200) {
                                this.dataLoaded = true;
                                this.foundPlaces = resp.data.data;
                            }

                        }).catch( (error) => {

                        if (error.response === undefined) {
                            userui.showNoInternetNotification();
                        }

                        this.loading = false;

                    }).finally( () => {
                        this.loading = false;
                    })

                }, 2000),



            placesByTitleRequestUrl: function(){
                return '/api/' + window.systemInfo.apiVersion + '/' + this.type + '/get_by_title' ;
            },

            addPlace: function(index){
                this.places.push(this.foundPlaces[index]);
                this.closeSelectorWindow();
            },

            removePlace: function(index){
                this.places.splice(index,1);
            },

            closeSelectorWindow: function(){
                $('#placeSelectorModal').modal('hide');
            }

        },

//------COMPUTED-----------------------------------------------------------------------------------------------


    }
</script>

<style scoped>

</style>