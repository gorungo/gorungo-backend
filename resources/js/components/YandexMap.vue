<template>
    <div class="map-cap"></div>
    <div id="map" style="height: 400px;"></div>
</template>

<script>
    export default {
        name: "YandexMap",
        props: "search",

        data(){
            return{
                myMap: null,
            }
        },

        mounted(){
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

        methods: {
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
            ymaps(){
                return window.ymaps;
            }
        }
    }

</script>

<style scoped>

</style>