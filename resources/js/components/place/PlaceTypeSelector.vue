<template>
    <div id="place-type-selector">
        <h5>Тип места</h5>
        <div class="form-group">
        <select class="form-control" @change="onChange" v-model="placeType">
            <option disabled value="null">Выберите тип объекта</option>
            <option v-for="(placeType, index) in allPlaceTypes" :value="placeType">{{placeType.attributes.slug}}</option>
        </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PlaceTypeSelector",
        props: ['allPlaceTypes', 'PlaceTypeGroups', 'placeType'],

        model:{
            prop: 'placeType',
            event: 'change'
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