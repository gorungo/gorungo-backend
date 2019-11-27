<template>
    <div id="date-selector" class="date-selector">
        <h5 class="text-capitalize">{{Lang.get('editor.label_dates')}}
            <span class="float-right text-primary" v-on:click="newDate"><span class="glyphicon glyphicon-pencil"> </span><span class="text-capitalize">{{Lang.get('editor.label_add')}}</span></span>
        </h5>
        <!-- Date selector -->
        <div>
            <div v-for="(date, index) in dates">
                <div class="card card-body" v-on:click="showDate(index)" :key="index">
                    <div>
                        <span v-if="!date.attributes.end_datetime_utc">{{go.localizeMySqlDate(date.attributes.start_datetime_utc)}}</span>
                        <span v-if="date.attributes.end_datetime_utc">{{go.localizeMySqlDate(date.attributes.start_datetime_utc)}} — {{go.localizeMySqlDate(date.attributes.end_datetime_utc)}}</span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="removeDate(index)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="dateSelectorModal" tabindex="-1" role="dialog" aria-labelledby="dateSelectorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content search-list">
                    <div class="modal-header">
                        <h5 class="modal-title">{{Lang.get('editor.label_date_editing')}}</h5>
                        <button type="button" class="close" v-on:click="closeSelectorWindow" :aria-label="Lang.get('editor.close')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="editDate != null">
                        <div class="form-group">
                            <select v-model="dateType" class="form-control">
                                <option value="1">{{Lang.get('editor.label_date_1_time')}}</option>
                                <option value="2">{{Lang.get('editor.label_dates_range')}}</option>
                                <option value="3">{{Lang.get('editor.label_dates_recurring')}}</option>
                            </select>
                        </div>
                        <form>
                        <div class="form-row" v-if="dateType === '1'">
                            <div class="col">
                            <datepicker input-class="form-control" v-model="editDate.attributes.start_date" format="dd.MM.yyyy" :placeholder="Lang.get('editor.label_start_date')"></datepicker>
                            </div>
                            <div class="col">
                                <time-selector v-model="editDate.attributes.start_time" />
                            </div>
                            <div class="col">
                                 <div class="custom-control custom-switch">
                                     <input id="f_all_day" class="custom-control-input" type="checkbox" v-model="editDate.attributes.is_all_day"/>
                                     <label class="custom-control-label" for="f_all_day">{{Lang.get('editor.label_all_day')}}</label>
                                 </div>
                            </div>
                        </div>
                            <div v-if="dateType === '2'">
                                <div class="form-row">
                                    <div class="col">
                                        <datepicker input-class="form-control" v-model="editDate.attributes.start_date" format="dd.MM.yyyy" :placeholder="Lang.get('editor.label_start_date')"></datepicker>
                                    </div>
                                    <div class="col">
                                        <time-selector v-model="editDate.attributes.start_time" />
                                    </div>
                                </div>
                                <div class="form-row mt-2">
                                    <div class="col">
                                        <datepicker input-class="form-control" v-model="editDate.attributes.end_date" format="dd.MM.yyyy" :placeholder="Lang.get('editor.label_finish_date')"></datepicker>
                                    </div>
                                    <div class="col">
                                        <time-selector v-model="editDate.attributes.end_time" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="custom-control custom-switch">
                                        <input id="f_all_day" class="custom-control-input" type="checkbox" v-model="editDate.attributes.is_all_day"/>
                                        <label class="custom-control-label" for="f_all_day">{{Lang.get('editor.label_all_day')}}</label>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" v-on:click="closeSelectorWindow">{{Lang.get('editor.close')}}</button>
                        <button type="button" class="btn btn-primary" v-on:click="saveDate">{{Lang.get('editor.save')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Localized from '../mixins/Localized.js';
    import Datepicker from 'vuejs-datepicker';
    import TimeSelector from './TimeSelector';
    import go from '../go.js';

    export default {
        name: "DateSelector",
        components: {Datepicker,TimeSelector} ,

        props: ['locale', 'dates'],
        mixins: [Localized],
        model:{
            prop: 'dates',
            event: 'change',
        },

//------DATA-----------------------------------------------------------------------------------------------

        data(){
            return {
                // dateType: 1 - only start date, 2 - start and end,
                dateType: "1",
                loading: false,

                // date structure template
                emptyDate: {
                    id: null,
                    type: "Dates",
                    locale: this.locale,
                    attributes: {
                        duration: 0,
                        start_date: null,
                        start_time: '00:00',
                        end_date: null,
                        end_time: '00:00',
                        time_zone_offset: window.go.getTimeZoneOffset(),
                        is_all_day: false,
                        is_recurring: false,
                        recurrence_pattern: null,
                    }

                },

                editDate: null,
                editDateIndex: null,
            }
        },



//------METHODS-----------------------------------------------------------------------------------------------

        computed: {
            go(){
                return window.go;
            },
        },
        watch: {

        },
        methods: {

            newDate: function(){
                this.editDate = _.cloneDeep(this.emptyDate);
                $('#dateSelectorModal').modal('show');
            },

            showDate: function(index){

                this.editDateIndex = index;

                this.editDate = _.cloneDeep(this.dates[index]);
                this.dateType = "1";

                this.editDate.attributes.start_date = this.editDate.attributes.start_datetime_utc  !== null ? go.mySqlDateTimeToJsUTC(this.editDate.attributes.start_datetime_utc) : '';
                this.editDate.attributes.end_date = this.editDate.attributes.end_datetime_utc  !== null ? go.mySqlDateTimeToJsUTC(this.editDate.attributes.end_datetime_utc) : '';
                this.editDate.attributes.start_time = this.editDate.attributes.start_datetime_utc  !== null ? go.localizeMySqlTime(this.editDate.attributes.start_datetime_utc) : '';
                this.editDate.attributes.end_time = this.editDate.attributes.end_datetime_utc  !== null ? go.localizeMySqlTime(this.editDate.attributes.end_datetime_utc): '';

                if(this.editDate.attributes.end_datetime_utc !== null && this.editDate.attributes.is_recurring === 0){
                    this.dateType = "2";
                }else if(this.editDate.attributes.end_datetime_utc !== null && this.editDate.attributes.is_recurring === 1){
                    this.dateType = "3";
                }

                $('#dateSelectorModal').modal('show');
            },

            removeDate: function(index){
                this.dates.splice(index,1);
            },

            addDate: function(){
                this.dates.push(this.dateToSave());
                this.closeSelectorWindow();
            },

            closeSelectorWindow: function(){
                $('#dateSelectorModal').modal('hide');
                this.reset();
            },

            dateToSave(){

                let da = this.editDate.attributes;

                if(da.start_date !== undefined && da.start_date !== null && da.start_time !== '') {
                    da.start_date.setHours(da.start_time.split(':')[0]);
                    da.start_date.setMinutes(da.start_time.split(':')[1]);
                }

                if(da.end_date !== undefined && da.end_date !== null && da.end_time !== ''){
                    da.end_date.setHours(da.end_time.split(':')[0]);
                    da.end_date.setMinutes(da.end_time.split(':')[1]);
                }

                return {
                    id: this.editDate.id,
                    type: "Dates",
                    locale: this.locale,
                    attributes: {
                        start_datetime_utc:  window.go.dateTimeMySql(da.start_date),
                        end_datetime_utc: window.go.dateTimeMySql(da.end_date),
                        time_zone_offset: window.go.getTimeZoneOffset(),
                        is_all_day: da.is_all_day,
                        is_recurring: da.is_recurring,
                        recurrence_pattern: da.recurrence_pattern,
                        duration: 0,
                    }

                }
            },

            saveDate(){
                if(this.editDateIndex !== null){
                    this.$set(this.dates, this.editDateIndex ,this.dateToSave());
                }else{
                    this.dates.push(this.dateToSave());
                }
                this.$emit('change', this.dates);
                $('#dateSelectorModal').modal('hide');
            },

            reset(){
                this.dateType = "1";
                this.editDate = null;
                this.editIndex = null;
            },



        },

//------COMPUTED-----------------------------------------------------------------------------------------------


    }
</script>

<style scoped>

</style>