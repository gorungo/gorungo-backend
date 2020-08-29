<template>
    <div id="timeFilter" class="filter">
        <!-- Time filter button  -->
        <button type="button" class="btn-filter dropdown-toggle" data-toggle="modal" data-target="#timeFilterModal">
            {{buttonTitle}}
        </button>

        <!-- Place filter modal -->
        <div class="modal fade" id="timeFilterModal" tabindex="-1" role="dialog" aria-labelledby="timeFilterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        {{Lang.get('menu.select_time')}}
                        <button v-if="!loading" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="filters && filters.length !== 0" class="distance-selector">
                            <div class="custom-control custom-checkbox" v-for="(filter, index) in filters">
                                <input @change="filterChanged(filter)" v-if="filters" class="custom-control-input" type="checkbox" v-model="activeFilters" :value="filter" :id="filterName + '-' + filter.attributes.name">
                                <label class="custom-control-label" :for="filterName + '-' + filter.attributes.name">
                                    {{filter.attributes.title}}
                                </label>
                            </div>
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
    import Filter from '../../mixins/Filter';
    export default {
        name: "TimeFilter",
        mixins: [Filter],
        props: ['propFilters'],

        data(){
            return {
                type: 'filters',
                locale: 'ru',
                filters: null,
                activeFilters: null,
                filterName: 'time',
                loading: false,
            }
        },

        computed:{
            defaultButtonTitle(){
                return window.go.firstToUpperCase(Lang.get('menu.select_time'));
            }
        }
    }
</script>

<style scoped lang="scss">
    @import 'resources/sass/filter.scss';
</style>
