<template>
    <div>
        <div v-if="sortedItineraries && sortedItineraries.length" id="itineraries-list" class="itinerary-list">
            <div @click="showItineraryInfoWindow(itinerary)" class="itinerary-list__itinerary-item" v-for="(itinerary, index) in sortedItineraries" :key="itinerary.id">
                <span class="itinerary-item__day-num text-first-uppercase">{{Lang.get('itinerary.day')}} {{itinerary.attributes.dayNum}}</span>
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="itinerary-image">
                            <img :src="itinerary.attributes.fullTmbImgPath" alt="itinerary-image"/>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h5>{{itinerary.attributes.title}}</h5>
                        <p>{{go.strLimit(itinerary.attributes.description, 100)}}</p>
                        <span class="link">{{Lang.get('texts.show_more')}}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="itinerariesListModal" tabindex="-1" role="dialog" aria-labelledby="itinerariesListModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" v-if="activeItinerary">
                    <div class="modal-header">
                        <h5>{{Lang.get('itinerary.day')}} {{activeItinerary.attributes.dayNum}}</h5>
                    </div>
                    <div class="modal-body">
                        <h3>{{activeItinerary.attributes.title}}</h3>
                        <p>{{activeItinerary.attributes.description}}</p>
                        <p>{{activeItinerary.attributes.whatIncluded}}</p>
                        <p>{{activeItinerary.attributes.willVisit}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ElementUI from 'element-ui';
    import Localized from '../mixins/Localized.js';
    export default {
        name: "ItinerariesList",

        components: {ElementUI},
        mixins: [Localized],

        props: {
            propItineraries: Array,
        },

        data(){
            return {
                activeItinerary: null,
            }
        },

        computed: {
            sortedItineraries(){
                return this.propItineraries.sort(function (a, b) {
                    if (a.attributes.dayNum > b.attributes.dayNum) {
                        return 1;
                    }
                    if (a.attributes.dayNum < b.attributes.dayNum) {
                        return -1;
                    }

                    if (a.attributes.dayNum === b.attributes.dayNum) {
                        if (a.attributes.startTime > b.attributes.startTime) {
                            return 1;
                        }
                        if (a.attributes.startTime < b.attributes.startTime) {
                            return -1;
                        }
                    }

                    return 0;
                });
            },

            go(){
                return window.go;
            },
        },

        methods: {
            showItineraryInfoWindow(itinerary){
                this.activeItinerary = itinerary;
                $('#itinerariesListModal').modal('show');
            },

            hideItineraryInfoWindow(){
                this.activeItinerary = null;
                $('#itinerariesListModal').modal('hide');
            }
        }

    }
</script>

<style scoped>
    .itinerary-image {
        background: #f8f8f8;
    }
    .itinerary-image img{
        width: 100%;
        object-fit: cover;
    }
    .itinerary-list__itinerary-item {
        cursor: pointer;
    }
</style>