<template>
    <div id="seasonFilter">
        <!-- Place filter button  -->
        <button type="button" class="btn btn-lg btn-outline-success dropdown-toggle" data-toggle="modal" data-target="#seasonFilterModal">
            {{buttonTitle}}
        </button>

        <!-- Place filter modal -->
        <div class="modal fade" id="seasonFilterModal" tabindex="-1" role="dialog" aria-labelledby="seasonFilterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="p-0 m-0">{{Lang.get('menu.select_season')}}</h5>
                        <button v-if="!loading" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body py-5">
                        <div v-if="filters && filters.length !== 0" class="d-flex distance-selector">
                            <div class="form-check" v-for="(filter, index) in filters">
                                <input @change="filterChanged(filter)" v-if="filters" class="form-check-input" type="checkbox" v-model="activeFilters" :value="filter" :id="filterName + '-' + filter.attributes.name">
                                <label class="form-check-label" :for="filterName + '-' + filter.attributes.name">
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
        name: "SeasonFilter",
        mixins: [Filter],
        props: ['propFilters'],

        data(){
            return {
                type: 'filters',
                locale: 'ru',
                filters: null,
                activeFilters: null,
                filterName: 'season',
                loading: false,
            }
        },
        }
</script>

<style scoped>

</style>