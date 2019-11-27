<template>
    <div id="place-type-selector">
        <h5>Тип места</h5>
        <div class="form-group">
        <select class="form-control" @change="onChange" v-model="placeType">
            <option disabled value="null">Выберите тип объекта</option>
            <option v-for="(vPlaceType, index) in allPlaceTypes" :value="vPlaceType">{{vPlaceType.attributes.slug}}</option>
        </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PlaceTypeSelector",
        props: ['allPlaceTypes', 'PlaceTypeGroups', 'propPlaceType'],

        model:{
            prop: 'propPlaceType',
            event: 'change'
        },

        data(){
           return {
               placeType: null,
           }
        },

        mounted(){
            if(this.propPlaceType){
                this.placeType = this.propPlaceType;
            }
        },

        methods:{
            onChange(){
                this.$emit('change', this.placeType);
            }
        }
    }
</script>

<style scoped>

</style>