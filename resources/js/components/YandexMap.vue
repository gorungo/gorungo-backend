<template>
    <div id="map-block" class="card card-body">
        <div class="map-cap"></div>
        <div id="map" style="height: 400px;"></div>
    </div>
</template>

<script>
    export default {
        name: "YandexMap",
        props: ["place", "search"],

        data(){
            return{
                myMap: null,
                ymaps: null,
            }
        },

        created(){
            //this.initialiseMapObject();
        },

        mounted(){


        },

        methods: {

            initialiseMapObject: async function () {
                this.ymaps = window.ymaps;

                await this.$nextTick();

                this.ymaps.ready(init);
                if(this.search){
                    var result = this.ymaps.geoQuery(this.ymaps.geocode(this.search));
                    result.then(function () {
                        this.addSearchResultsToMap(result);
                    }, function () {
                        alert('Произошла ошибка.');
                    });
                }

            },

            init() {
                this.myMap = new this.ymaps.Map('map', {
                    center: [43.1056200, 131.8735300],
                    zoom: 9
                });
            },

            addSearchResultsToMap(result){
                result.addToMap(myMap)
            }
        },

        computed:{

        }
    }

</script>

<style scoped>

</style>