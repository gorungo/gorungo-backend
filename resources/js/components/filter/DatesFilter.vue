<template>
    <div id="datesFilter" class="filter">
        <!-- Dates filter button  -->
        <button type="button" class="btn-filter dropdown-toggle" data-toggle="modal" data-target="#datesFilterModal">
            {{buttonTitle}}
        </button>

        <!-- Place filter modal -->
        <div class="modal fade" id="datesFilterModal" tabindex="-1" role="dialog" aria-labelledby="datesFilterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        {{Lang.get('menu.select_dates')}}
                        <button v-if="!loading" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="block w-100">
                            <el-date-picker
                                    v-model="formattedDateRange"
                                    type="daterange"
                                    format="dd.MM.yyyy"
                                    value-format="dd.MM.yyyy"
                                    size="large"
                                    :clearable=false
                                    range-separator="To"
                                    :start-placeholder="Lang.get('texts.from')"
                                    :end-placeholder="Lang.get('texts.to')">
                            </el-date-picker>
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

    import enLang from 'element-ui/lib/locale/lang/en';
    import ruLang from 'element-ui/lib/locale/lang/ru-RU';
    import cnLang from 'element-ui/lib/locale/lang/zh-CN';
    import locale from 'element-ui/lib/locale'

    import Filter from '../../mixins/Filter';
    import { DatePicker } from 'element-ui';
    export default {
        name: "DatesFilter",
        mixins: [Filter],
        props: ['propFilters'],
        component: {
            DatePicker
        },

        data(){
            return {
                type: 'filters',
                locale: 'ru',
                filters: null,
                activeFilters: [],
                filterName: 'dates',
                loading: false,
                formattedDateRange: '',
                needFetchFilters: false,
            }
        },

        mounted(){
            // configure language
            switch(this.locale){
                case 'ru':
                    locale.use(ruLang);
                    break;

                case 'en':
                    locale.use(enLang);
                    break;

                case 'ch':
                    locale.use(cnLang);
                    break;

            }


            if(this.URLActiveFilter){
                this.activeFilters.push(this.URLActiveFilter);

                // todo нужно сделать проверку, что фильтр - массив с валидными датами
                this.formattedDateRange = this.URLActiveFilter.split('to');
            }
        },

        computed:{
            defaultButtonTitle(){
                return window.go.firstToUpperCase(Lang.get('menu.any_dates'));
            },

            buttonTitle(){
                let title = '';
                if (this.formattedDateRange && this.formattedDateRange.length) {
                    title = Lang.get('texts.from') + ' ' + this.formattedDateRange[0];
                }else{
                    title = this.defaultButtonTitle;
                }

                return title;
            },
        },

        watch: {
            formattedDateRange(val){
                if (val && val !== '') this.activeFilters[0] = val.join('to');
            },
        },

        methods: {
            clearFilterHandler() {
                this.activeFilters = [];
                this.formattedDateRange = [];
                this.applyFilterHandler();
            }
        }
    }
</script>

<style scoped lang="scss">
    @import 'resources/sass/filter.scss';
    .el-range-editor.el-input__inner{
        width: 100%;
    }
</style>
