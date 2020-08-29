<template>
    <div id="idea-editor" v-loading="loading">
        <div class="w-100 bg-white">
            <div class="d-flex pt-4 px-3 justify-content-between">
                <h2 class="text-first-uppercase">{{this.documentTitle}}</h2>
                <button v-if="hasPageChanges" :disabled="loading" class="btn btn-primary float-right" dusk="savebtn" v-on:click.prevent="formSubmit()">
                    <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span v-if="loading" class="sr-only">{{Lang.get('editor.loading')}}...</span>
                    <span v-else>{{Lang.get('editor.save_button')}}</span>
                </button>
            </div>
        </div>
        <div v-if="dataLoaded && !loading" class="bg-white pt-4">
            <el-container style="height: 500px; border: 1px solid #eee">
                <el-aside width="200px" style="background-color: rgb(238, 241, 246)">
                    <el-menu :default-openeds="['1']">
                        <el-submenu index="1">
                            <template slot="title">
                                <div @click="activeTabName='main'">
                                    {{Lang.get('editor.tab_main')}}
                                </div>
                            </template>
                            <el-menu-item index="1-1" @click="activeTabName='place'">{{Lang.get('editor.tab_place')}}</el-menu-item>
                            <el-menu-item index="1-2" @click="activeTabName='category'">{{Lang.get('editor.tab_category')}}</el-menu-item>
                            <el-menu-item index="1-3" @click="activeTabName='description'">{{Lang.get('editor.tab_description')}}</el-menu-item>
                            <el-menu-item index="1-4" @click="activeTabName='itinerary'">{{Lang.get('editor.tab_itinerary')}}</el-menu-item>
                            <el-menu-item index="1-5" @click="activeTabName='dates'">{{Lang.get('editor.tab_dates')}}</el-menu-item>
                            <el-menu-item index="1-6" @click="activeTabName='images'">{{Lang.get('editor.tab_pictures')}}</el-menu-item>
                            <el-menu-item index="1-7" @click="activeTabName='tags'">{{Lang.get('editor.tab_tags')}}</el-menu-item>
                        </el-submenu>
                        <el-submenu index="2">
                            <template slot="title">{{Lang.get('idea.idea_settings')}}</template>
                            <el-menu-item index="2-1">Option 1</el-menu-item>
                            <el-menu-item index="2-2">Option 1</el-menu-item>
                            <el-menu-item index="2-3">Option 1</el-menu-item>
                        </el-submenu>
                        <div class="d-flex justify-content-center p-2">
                            <el-button :type="readyToPublish ? 'success' : 'danger'" class="w-100" round>
                                {{Lang.get('idea.publish')}}
                                <i v-if="readyToPublish" class="el-icon-check el-icon-right"></i>
                                <i v-if="!readyToPublish" class="el-icon-lock el-icon-right"></i>
                            </el-button>
                        </div>
                    </el-menu>
                </el-aside>

                <el-container>
                    <el-main>
                        <errors :errors="errors"></errors>
                        <div class="">
                            <div id="idea-info" v-if="dataLoaded && activeTabName === 'main'">
                                <div class="d-flex" style="justify-content: center;">
                                    <div class="text-center" v-if="item.attributes.title !== null">
                                        <h1>
                                            {{item.attributes.title}}
                                        </h1>
                                        <p class="text-first-uppercase" v-if="item.attributes.active">
                                            {{Lang.get('idea.idea_published_and_available_for_users')}}
                                        </p>
                                    </div>
                                    <div v-else class="text-center">
                                        <h1>{{Lang.get('idea.create_intro_title')}}</h1>
                                        <p>{{Lang.get('idea.create_intro_description')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-category" v-if="dataLoaded && activeTabName === 'category'">
                                <idea-category-editor
                                        v-model = "item.relationships.categories"
                                        :locale = "locale"
                                        @change="categoryChanged"
                                ></idea-category-editor>
                            </div>
                            <div id="tab-place" v-if="dataLoaded && activeTabName === 'place'">
                                <idea-place-editor
                                        v-if="item !== null"
                                        :locale = "locale"
                                        v-model = "item.relationships.places"
                                ></idea-place-editor>
                            </div>
                            <div id="tab-tags" v-if="dataLoaded && activeTabName === 'tags'">
                                <idea-tags-editor
                                        v-model="item.relationships.tags"
                                ></idea-tags-editor>
                                <idea-extended-tag-selector
                                        v-if="item"
                                        v-model="item.relationships.tags"
                                ></idea-extended-tag-selector>
                            </div>
                            <div id="tab-description" v-if="dataLoaded && activeTabName === 'description'">
                                <idea-description-editor v-model="item"></idea-description-editor>
                            </div>
                            <idea-itinerary-editor
                                    v-if="dataLoaded && activeTabName === 'itinerary'"
                                    v-model="item.relationships.itineraries"
                                    :hid="item.hid"
                            ></idea-itinerary-editor>
                            <idea-dates-and-prices-editor
                                    v-if="dataLoaded && activeTabName === 'dates'"
                                    v-model="item.relationships.dates"
                                    :currencies="currencies"
                                    :hid="item.hid"
                            ></idea-dates-and-prices-editor>
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
    import {mapGetters, mapActions, mapState} from 'vuex';
    import PhotoUploader from '../photo/PhotoUploader.vue';
    import IdeaExtendedTagSelector from './IdeaExtendedTagSelector.vue';
    import IdeaItineraryEditor from './IdeaItineraryEditor.vue';
    import IdeaDatesAndPricesEditor from './IdeaDatesAndPricesEditor.vue';
    import IdeaSelector from './IdeaSelector.vue';
    import LocaleSelector from '../LocaleSelector.vue';
    import ElementUI from 'element-ui';
    import IdeaTagsEditor from "./IdeaTagsEditor";
    import IdeaDescriptionEditor from "./IdeaDescriptionEditor";
    import IdeaCategoryEditor from "./IdeaCategoryEditor";
    import IdeaPlaceEditor from "./IdeaPlaceEditor";


    export default {

        name: "IdeaEditor",

        props: {
            propTitle : String,
            propItemId : Number,
            propLocale : String,
            propHid : String,
        },

        components: {
            IdeaPlaceEditor,
            IdeaCategoryEditor,
            IdeaDescriptionEditor,
            IdeaTagsEditor,
            PhotoUploader,
            LocaleSelector,
            IdeaExtendedTagSelector,
            IdeaDatesAndPricesEditor,
            IdeaSelector,
            IdeaItineraryEditor,
            ElementUI,
        },

        data(){
            return{
                type: 'ideas',

                money: {
                    decimal: ',',
                    thousands: '',
                    prefix: '',
                    suffix: '',
                    precision: 2,
                    masked: false
                },

                activeTabName: 'main',
                loading: false,
                dataLoaded: false,
                hasPageChanges: false,
            }
        },

        async mounted(){
            await this.fetchCurrencies();
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
            },

            ...mapGetters('Idea', ['readyToPublish']),
            ...mapGetters('Currency', ['currencies']),

        },

        methods: {
            ...mapActions('Currency', ['fetchCurrencies']),

            categoryChanged(){
                if(this.item.relationships.categories.length){
                    this.item.attributes.main_category_id = this.item.relationships.categories[0].id;
                }else{
                    this.item.attributes.main_category_id = null;
                }
            },

            handlePublish(){

            },

            async publish(){
                if(this.canPublish()){
                    const url = `/api/${window.systemInfo.apiVersion}/${this.type}/${this.hid}`;

                    try {
                        await axios.get( requesrUrl, { params: {
                                locale: this.locale,
                            }}
                        );
                    } catch (e) {
                        this.showDefaultError();
                    }
                }
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
