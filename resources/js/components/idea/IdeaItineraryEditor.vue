<template>
    <div id="itinerary-editor" class="pb-4">
        <div v-if="sortedItineraries && sortedItineraries.length">
            <h4 class="text-first-uppercase mb-4">{{go.firstToUpperCase(Lang.get('itinerary.itinerary'))}}
                <span class="float-right text-primary" @click="addItinerary"><span class="glyphicon glyphicon-pencil"> </span><span class="text-capitalize">{{Lang.get('editor.label_add')}}</span></span>
            </h4>
            <el-container :id="'itinerary-item-' + index" class="itinerary-editor__itinerary-item" v-for="(itinerary, index) in sortedItineraries" :key="'i-'+index+'-'+itinerary.id">
                <el-header v-if="index > 0 && itinerary.attributes.dayNum > sortedItineraries[index-1].attributes.dayNum">
                </el-header>
                <el-main style="padding: 0;">
                    <div class="card card-body">
                        <div class="d-flex">
                            <el-col :span="4">
                                <el-select v-model="itinerary.attributes.dayNum" :placeholder="go.firstToUpperCase(Lang.get('itinerary.select_day'))">
                                    <el-option
                                            v-for="dayNum in daysCount"
                                            :key="dayNum"
                                            :label="itinerary.attributes.dayNum ? go.firstToUpperCase(Lang.get('itinerary.day')) + ' ' + itinerary.attributes.dayNum : go.firstToUpperCase(Lang.get('itinerary.select_day'))"
                                            :value="dayNum"
                                    ><span>{{go.firstToUpperCase(Lang.get('itinerary.day'))}}</span> {{dayNum}}</el-option>
                                    <el-option
                                            :key="daysCount+1"
                                            :label="itinerary.attributes.dayNum ? Lang.get('itinerary.day') + ' ' + itinerary.attributes.dayNum : go.firstToUpperCase(Lang.get('itinerary.select_day'))"
                                            :value="daysCount+1"
                                    ><span>{{go.firstToUpperCase(Lang.get('itinerary.day'))}}</span> {{daysCount+1}}</el-option>

                                </el-select>
                            </el-col>
                            <el-col :span="20" style="text-align: right;">
                                <el-button @click="removeItinerary(itinerary)" type="default" icon="el-icon-delete" circle></el-button>
                            </el-col>
                        </div>
                        <div class="d-flex">
                            <el-container>
                                <el-aside width="200px" v-if="hid && itinerary.id">
                                    <div class="itinerary-item__image-uploader mt-3">
                                        <img class="image-uploader__image" v-if="imageUploadAvailable(itinerary) && itinerary.attributes.fullTmbImgPath !==''" :src="itinerary.attributes.fullTmbImgPath" alt="itinerary-image" />
                                        <one-image-uploader
                                                v-model="itinerary.attributes.fullTmbImgPath"
                                                :uploadAvailable="imageUploadAvailable(itinerary)"
                                                :actionUrl="imageUploadActionUrl(itinerary)"
                                                @uploaded="onItineraryImageUpload"
                                                :clipper=false
                                        ></one-image-uploader>
                                    </div>
                                </el-aside>
                                <el-main>
                                    <el-form :model="itinerary" ref="ruleForm" label-width="200px" class="demo-ruleForm">
                                        <el-form-item :label="Lang.get('itinerary.start_time')" prop="startTime">
                                            <el-time-select
                                                    v-model="itinerary.attributes.startTime"
                                                    :picker-options="{
                                                        start: '00:00',
                                                        step: '00:15',
                                                        end: '24:00'
                                                      }"
                                                    :placeholder="Lang.get('itinerary.select_start_time')">
                                            </el-time-select>
                                        </el-form-item>
                                        <el-form-item :label="Lang.get('itinerary.title')" prop="title">
                                            <el-input v-model="itinerary.attributes.title"></el-input>
                                        </el-form-item>
                                        <el-form-item :label="Lang.get('itinerary.description')" prop="description">
                                            <el-input type="textarea" v-model="itinerary.attributes.description"></el-input>
                                        </el-form-item>
                                        <el-form-item :label="Lang.get('itinerary.what_included')" prop="whatIncluded">
                                            <el-input type="textarea" v-model="itinerary.attributes.whatIncluded"></el-input>
                                        </el-form-item>
                                        <el-form-item :label="Lang.get('itinerary.will_visit')" prop="willVisit">
                                            <el-input type="textarea" v-model="itinerary.attributes.willVisit"></el-input>
                                        </el-form-item>
                                    </el-form>
                                </el-main>
                            </el-container>
                        </div>
                    </div>
                </el-main>
            </el-container>
            <div id="itineraries-footer"></div>

        </div>
        <div v-else class="clearfix d-flex" style="justify-content: center;">
            <el-col :span="12">
                <el-card class="box-card text-center" shadow="never">
                    <h3 class="text-first-uppercase">{{go.firstToUpperCase(Lang.get('itinerary.editor_no_itinerary_title'))}}</h3>
                    <p class="text-first-uppercase">{{go.firstToUpperCase(Lang.get('itinerary.editor_no_itinerary_description'))}}</p>
                    <el-button @click="addItinerary" type="primary" icon="el-icon-plus" round>{{Lang.get('editor.label_add')}}</el-button>
                </el-card>
            </el-col>
        </div>
    </div>
</template>

<script>
    import ElementUI from 'element-ui';
    import Localized from '../../mixins/Localized.js';
    import OneImageUploader from "../photo/OneImageUploader";
    export default {
        name: "IdeaItineraryEditor",

        components: {OneImageUploader, ElementUI},

        mixins: [Localized],

        props: {
            propItineraries: Array,
            hid: String,
        },

        model:{
            prop: 'propItineraries',
            event: 'change'

        },

        data(){
            return {
                itineraries: [],
                settings: {
                    maxDaysCount: 31,
                    defaultStartTime: '06:00:00',
                },
            }
        },

        mounted() {
            if(this.propItineraries){
                this.itineraries = this.propItineraries;
            }
        },

        watch: {
            propItineraries(val){
                if(val){
                    this.itineraries = val;
                }
            },
        },

        methods: {
            addItinerary(){

                let newItinerary = {
                    id: 0,
                    type: 'itinerary',
                    attributes: {
                        dayNum: this.daysCount+1,
                        startTime: this.settings.defaultStartTime,
                        title: '',
                        description: '',
                        whatIncluded: null,
                        willVisit: null,
                        fullTmbImgPath: '',
                    }

                };

                this.itineraries.push(newItinerary);

                this.$nextTick(function () {
                        // scroll to new element
                        let element = document.getElementById('itineraries-footer');
                        element.scrollIntoView({ behavior: 'smooth', block: 'end'});
                    })

            },

            removeItinerary(itinerary){
                this.sortedItineraries.splice(this.itineraries.indexOf(itinerary), 1);
            },

            imageUploadActionUrl(itinerary){
                if(itinerary.id) {
                    return '/api/' + window.systemInfo.apiVersion + '/ideas/' + this.hid +'/itineraries/' + itinerary.id + '/photo'
                } else{
                    return null;
                }
            },

            imageUploadAvailable(itinerary){
                return itinerary.id !== null;
            },

            onItineraryImageUpload(pathToImage) {

            },



        },

        computed: {
            sortedItineraries(){
                return this.itineraries.sort(function (a, b) {
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

            daysCount(){
                let count = 0;

                this.sortedItineraries.forEach((item, index) => {
                    if(index > 0 && item.attributes.dayNum > this.sortedItineraries[index-1].attributes.dayNum){
                        count++;
                    }
                    if(index === 0){
                        count++;
                    }
                });

                return count;
            },

            go(){
                return window.go;
            },

        }
    }
</script>

<style scoped>
    .itinerary-item__image-uploader img{
        width: 100%;
    }

</style>