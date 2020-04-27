<template>
    <div id="idea-editor" v-loading="loading">
        <div class="w-100 bg-white">
            <div class="container pt-4">
                <div class="row w-100">
                        <div class="col-sm-12 col-md-8">
                            <h2 class="text-first-uppercase">{{this.documentTitle}}</h2>
                        </div>
                        <div class="col-sm-12 col-md-4 text-right">
                            <button v-if="hasPageChanges" :disabled="loading" class="btn btn-primary float-right" dusk="savebtn" v-on:click.prevent="formSubmit()">
                                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span v-if="loading" class="sr-only">{{Lang.get('editor.loading')}}...</span>
                                <span v-else>{{Lang.get('editor.save_button')}}</span>
                            </button>
                        </div>

                    </div>
            </div>
        </div>
        <div v-if="dataLoaded && !loading" class="bg-white pt-4">
            <el-container style="height: 500px; border: 1px solid #eee">
                <el-aside width="200px" style="background-color: rgb(238, 241, 246)">
                    <el-menu :default-openeds="['1', '2']">
                        <el-submenu index="1">
                            <template slot="title">{{Lang.get('editor.tab_main')}}</template>
                            <el-menu-item index="1-1" @click="activeTabName='main'">{{Lang.get('editor.tab_main')}}</el-menu-item>
                            <el-menu-item index="1-2" @click="activeTabName='itinerary'">{{Lang.get('editor.tab_itinerary')}}</el-menu-item>
                            <el-menu-item index="1-3" @click="activeTabName='dates'">{{Lang.get('editor.tab_dates')}}</el-menu-item>
                            <el-menu-item index="1-4" @click="activeTabName='images'">{{Lang.get('editor.tab_pictures')}}</el-menu-item>
                        </el-submenu>
                        <el-submenu index="2">
                            <template slot="title">{{Lang.get('editor.tab_main')}}</template>
                            <el-menu-item index="2-1">Option 1</el-menu-item>
                            <el-menu-item index="2-2">Option 1</el-menu-item>
                            <el-menu-item index="2-3">Option 1</el-menu-item>
                        </el-submenu>
                    </el-menu>
                </el-aside>

                <el-container>
                    <el-main>
                        <errors :errors="errors"></errors>
                        <div class="">
                            <div id="idea-details-editor" v-if="dataLoaded && activeTabName === 'main'">
                                <form id="frm_form" name="frm_form" method="post" autocomplete="off">
                                    <input type="hidden" name="city_id" :value="this.cityId"/>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <el-form label-position="top" :model="item" ref="descriptionForm" label-width="120px" class="demo-dynamic">
                                                <h4 class="text-first-uppercase mb-4">{{Lang.get('idea.idea_description')}}</h4>
                                                <el-form-item :label="Lang.get('editor.label_title')">
                                                    <el-input v-model="item.attributes.title"></el-input>
                                                </el-form-item>
                                                <el-form-item :label="Lang.get('editor.label_intro')">
                                                    <el-input v-model="item.attributes.intro"></el-input>
                                                </el-form-item>
                                                <el-form-item :label="Lang.get('editor.label_description')">
                                                    <el-input type="textarea" v-model="item.attributes.description"></el-input>
                                                </el-form-item>
                                            </el-form>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="row form-group">
                                                <div class="col-sm-4 col-6">
                                                    <input type="radio" class="radio" name="active" id="active_0"
                                                           value="0" v-model="item.attributes.active"/>
                                                    <label dusk="active_0" for="active_0" style="margin-right: 12px;"> {{Lang.get('editor.label_draft')}}</label>
                                                </div>
                                                <div class="col-sm-4 col-6">
                                                    <input type="radio" class="radio" name="active" id="active_1"
                                                           value="1"  v-model="item.attributes.active"/>
                                                    <label dsk="active_1" for="active_1"> {{Lang.get('editor.label_published')}}</label>
                                                </div>
                                            </div>
                                            <category-selector
                                                    v-model = "item.relationships.categories"
                                                    :locale = "locale"
                                                    @change="categoryChanged"
                                            ></category-selector>
                                            <hr/>
                                            <idea-selector
                                                    v-if="item !== null"
                                                    :locale = "locale"
                                                    v-model = "item.relationships.idea"
                                            ></idea-selector>
                                            <hr>
                                            <place-selector
                                                    v-if="item !== null"
                                                    :locale = "locale"
                                                    v-model = "item.relationships.places"
                                            ></place-selector>
                                            <hr>
                                            <extended-tag-selector v-if="item" v-model="item.relationships.tags"></extended-tag-selector>
                                            <hr>
                                            <div>
                                                <tags-editor
                                                        :tags="item.relationships.tags"
                                                ></tags-editor>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>

                                </form>
                            </div>

                            <itinerary-editor
                                    v-if="dataLoaded && activeTabName === 'itinerary'"
                                    v-model="item.relationships.itineraries"
                                    :hid="item.hid"
                            ></itinerary-editor>

                            <dates-and-prices-editor
                                    v-if="dataLoaded && activeTabName === 'dates'"
                                    v-model="item.relationships.dates"
                                    :currencies="currencies"
                                    :hid="item.hid"
                            ></dates-and-prices-editor>

                            <photo-uploader
                                    v-if="dataLoaded && activeTabName === 'images'"
                                    :type="this.item.type"
                                    :item-id="item.hid"
                                    :hid="item.hid"
                            />
                        </div>
                    </el-main>
                </el-container>
            </el-container>
        </div>
    </div>
</template>

<script>
    import Editable from '../../mixins/Editable.js';
    import PhotoUploader from '../photo/PhotoUploader.vue';
    import ExtendedTagSelector from '../ExtendedTagSelector.vue';
    import CategorySelector from '../CategorySelector.vue';
    import DateSelector from '../DateSelector.vue';
    import PlaceSelector from '../place/PlaceSelector.vue';
    import IdeaSelector from '../idea/IdeaSelector.vue';
    import LocaleSelector from '../LocaleSelector.vue';
    import ElementUI from 'element-ui';
    import TagsEditor from "./TagsEditor";


    export default {

        name: "IdeaEditor",

        props: {
            propTitle : String,
            propItemId : Number,
            propLocale : String,
            propHid : String,
        },

        mixins: [ Editable ],

        components: {
            TagsEditor,
            PhotoUploader,
            LocaleSelector,
            CategorySelector,
            ExtendedTagSelector,
            IdeaSelector,
            DateSelector,
            PlaceSelector,
            ElementUI,
        },

        data(){
            return{
                type: 'ideas',

                currencies: [],

                money: {
                    decimal: ',',
                    thousands: '',
                    prefix: '',
                    suffix: '',
                    precision: 2,
                    masked: false
                },

                activeTabName: 'main'
            }
        },

        mounted(){
            this.fetchCurrencies();
        },

        computed: {
            documentTitle: function(){
                if(this.dataLoaded){
                    if(!this.item.id) {
                        return Lang.get('editor.new_idea');
                    }else{
                        return Lang.get('editor.edit_idea');
                    }
                }
            },
            ideaId(){
                return this.propIdeaId;
            }

        },

        methods: {

            categoryChanged(){
                if(this.item.relationships.categories.length){
                    this.item.attributes.main_category_id = this.item.relationships.categories[0].id;
                }else{
                    this.item.attributes.main_category_id = null;
                }
            },

            fetchCurrencies(){
                axios.get(
                    this.fetchCurrenciesRequestUrl(), { params: {
                            locale: this.locale,
                        }}
                ).then((resp) => {
                    if (resp.status === 200 || resp.status === 201){
                        this.currencies = resp.data;
                    }
                }).catch(

                ).finally(

                );
            },

            fetchCurrenciesRequestUrl(){
                return '/api/' + window.systemInfo.apiVersion + '/currencies/active';
            },

            handleTabClick(){
                //
            }

        }
    }
</script>

<style scoped>
    .btn-edit{
        margin-left: 10px;
        cursor:pointer;
        opacity: 0.3;
    }
    .btn-edit:hover{
        opacity: 0.6;
    }
    .ck.ck-editor__editable_inline {
        min-height: 500px !important;
    }
</style>