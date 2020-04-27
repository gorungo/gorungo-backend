<template>
    <div id="date-editor" class="date-selector pb-4">
        <!-- Date selector -->
        <div v-if="orderedDates.length !== 0">
            <h4 class="text-first-uppercase mb-4">{{Lang.get('editor.label_dates')}}
                <span class="float-right text-primary" v-on:click="handleNewDate"><span class="glyphicon glyphicon-pencil"> </span><span class="text-capitalize">{{Lang.get('editor.label_add')}}</span></span>
            </h4>
            <el-row>
                <el-col  v-for="(date, index) in orderedDates" :span="6" :key="date.id">
                    <div class="card date-card">
                        <div class="card-body date-card__wrap">
                            <el-button class="float-right" type="default" icon="el-icon-delete" circle v-on:click="handleRemoveDate(index)"></el-button>
                            <div class="date-card__info" v-on:click="handleShowDate(index)">
                                <div>
                                    <i class="el-icon-date mr-2"></i>{{Go.localizeMySqlDateToLocale(date.attributes.start_date, 'ru-RU')}}
                                </div>
                                <div><i class="el-icon-coin mr-2"></i>{{date.relationships.ideaPrice.attributes.price}} {{date.relationships.ideaPrice.relationships.currency.attributes.title}}</div>
                            </div>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </div>
        <div v-else class="clearfix d-flex" style="justify-content: center;">
            <el-col :span="12">
                <el-card class="box-card text-center" shadow="never">
                    <h3 class="text-first-uppercase">{{Go.firstToUpperCase(Lang.get('editor.editor_no_dates_title'))}}</h3>
                    <p class="text-first-uppercase">{{Go.firstToUpperCase(Lang.get('editor.editor_no_dates_description'))}}</p>
                    <el-button @click="handleNewDate" type="primary" icon="el-icon-plus" round>{{Lang.get('editor.label_add')}}</el-button>
                </el-card>
            </el-col>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="dateSelectorModal" tabindex="-1" role="dialog" aria-labelledby="dateSelectorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content search-list">
                    <div class="modal-header">
                        <h5 class="modal-title text-first-uppercase">{{Lang.get('editor.label_date_editing')}}</h5>
                        <button type="button" class="close" v-on:click="handleCloseSelectorWindow" :aria-label="Lang.get('editor.close')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="editDate != null">
                        <el-form ref="form" :model="editDate" label-width="100px">
                            <el-form-item :label="Lang.get('editor.label_start_date')">
                                <el-col :span="10">
                                    <el-date-picker
                                            v-model="editDate.attributes.start_date"
                                            type="date"
                                            format="dd.MM.yyyy"
                                            value-format="yyyy-MM-dd"
                                            class="w-100"
                                            :placeholder="Lang.get('editor.label_start_date')">
                                    </el-date-picker>
                                </el-col>
                                <el-col class="line text-center" :span="2">-</el-col>
                                <el-col :span="10">
                                    <el-time-picker
                                            class="w-100"
                                            v-model="editDate.attributes.start_time"
                                            value-format="HH:mm:ss"
                                            placeholder="Arbitrary time">
                                    </el-time-picker>
                                </el-col>
                            </el-form-item>
                            <el-form-item :label="Lang.get('editor.label_price')">
                                <el-row v-if="currencies.length">
                                    <el-col :span="10">
                                        <el-input v-money="money" v-model.lazy="editDate.relationships.ideaPrice.attributes.price">
                                            <i slot="prefix" class="el-input__icon el-icon-coin"></i>
                                        </el-input>
                                    </el-col>
                                    <el-col class="line" :span="2">&nbsp;</el-col>
                                    <el-col :span="10">
                                        <el-select value-key="id" v-model="editDate.relationships.ideaPrice.relationships.currency" :placeholder="Lang.get('editor.label_currency')">
                                            <el-option
                                                    v-for="currency in currencies"
                                                    :key="currency.id"
                                                    :label="currency.attributes.title"
                                                    :value="currency">
                                            </el-option>
                                        </el-select>
                                    </el-col>

                                </el-row>
                            </el-form-item>

                        </el-form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" v-on:click="handleCloseSelectorWindow">{{Lang.get('editor.close_button')}}</button>
                        <button type="button" class="btn btn-primary" v-on:click="handleSaveDate">{{Lang.get('editor.save_button')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {Money} from 'v-money';
    import Localized from '../../mixins/Localized.js';
    import Datepicker from 'vuejs-datepicker';
    import TimeSelector from '../TimeSelector';
    import ElementUI from 'element-ui';

    export default {
        name: "DatesAndPricesEditor",
        components: {Datepicker, TimeSelector, Money, ElementUI} ,

        props: {
            dates: Array,
            currencies: Array,
            hid: String,
        },
        mixins: [Localized],
        model:{
            prop: 'dates',
            event: 'change',
        },

//------DATA-----------------------------------------------------------------------------------------------

        data(){
            return {

                loading: false,

                // date structure template
                money: {
                    decimal: ',',
                    thousands: '',
                    prefix: '',
                    suffix: '',
                    precision: 2,
                    masked: false
                },

                editDate: null,
                editDateIndex: null,
            }
        },



//------METHODS-----------------------------------------------------------------------------------------------

        computed: {
            Go(){
                return window.go;
            },

            defaultCurrency(){
                return {
                    id: 3,
                    locale: 'en',
                    type: 'Currency',
                    attributes: {
                        title: 'Russian Ruble',
                        code: 'RUB',
                        number: 643 ,
                    }
                }
            },

            emptyDate() {
                return {
                    id: Date.now(), // 13 symbols
                    type: "Dates",
                    locale: this.locale,
                    attributes: {
                        start_date: null,
                        start_time: null,
                        time_zone_offset: this.Go.getTimeZoneOffset(),
                    },
                    relationships: {
                        ideaPrice: {
                            id: null,
                            locale: null,
                            type: '',
                            attributes: {
                                price: '0,000',
                            },
                            relationships: {
                                currency: this.defaultCurrency
                            }
                        }
                    }
                }

            },

            orderedDates(){
                return this.dates
            },

            dateToSave(){
                return this.editDate;
            },


        },
        watch: {

        },
        methods: {

            /**
             * Push date to dates array from modal window
             */

            addDate(){
                if(this.editDateIndex !== null){
                    // if updating date
                    this.$set(this.dates, this.editDateIndex, this.dateToSave);
                    this.$emit('change', this.dates);
                }else{
                    // if creating new
                    this.dates.push(this.dateToSave);
                }
                this.reset();
            },

            /**
             * Reset date modal window data
             */
            reset(){
                this.editDate = null;
                this.editIndex = null;
            },

            // handlers

            handleNewDate: function(){
                this.editDateIndex = null;
                this.editDate = { ...this.emptyDate };
                $('#dateSelectorModal').modal('show');
            },

            handleShowDate: function(index){
                this.editDateIndex = index;
                this.editDate = { ...this.dates[index] };

                $('#dateSelectorModal').modal('show');
            },

            handleRemoveDate: function(index){
                this.dates.splice(index,1);
            },

            handleCloseSelectorWindow: function(){
                $('#dateSelectorModal').modal('hide');
                this.reset();
            },

            handleSaveDate(){
                this.addDate();
                $('#dateSelectorModal').modal('hide');
            },



        },

//------COMPUTED-----------------------------------------------------------------------------------------------


    }
</script>

<style scoped>

    .date-card{
        cursor: pointer;
    }

</style>