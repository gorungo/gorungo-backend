<template>
    <div>
        <div class="w-100">
            <div class="card">
                <div class="card-body">
                    <div class="row w-100">
                        <div class="col-sm-12 col-md-8">
                            <h2>{{this.documentTitle}}</h2>
                        </div>
                        <div class="col-sm-12 col-md-4 text-right">
                            <button :disabled="loading" class="btn btn-primary float-right" dusk="savebtn" v-on:click.prevent="formSubmit()">
                                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span v-if="loading" class="sr-only">{{Lang.get('editor.loading')}}...</span>
                                <span v-else>{{Lang.get('editor.save_button')}}</span>
                            </button>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="d-flex justify-content-center">
                                <ul class="nav nav-pills">
                                    <li role="presentation" id="tab_main" class="active">
                                        <a class="nav-link active" id="edit-main-block-tab" data-toggle="tab" href="#edit-main-block" role="tab" aria-controls="profile" aria-selected="true"><span class="glyphicon glyphicon-pencil"> </span>Основное</a>
                                    </li>
                                    <li role="presentation" id="tab_photo">
                                        <a class="nav-link" id="edit-images-block-tab" data-toggle="tab" href="#edit-images-block" role="tab" aria-controls="profile" aria-selected="false"><span class="glyphicon glyphicon-picture"> </span>Изображения</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="dataLoaded && !loading" class="mt-4">
            <div class="container">
                <errors :errors="errors"></errors>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="edit-main-block" role="tabpanel" aria-labelledby="edit-main-block-tab">
                        <form id="frm_form" name="frm_form" method="post" autocomplete="off">
                            <input type="hidden" name="city_id" :value="this.cityId"/>

                            <h5>Активность</h5>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row panel">
                                        <div class="col-sm-6">
                                            <div class="row form-group">
                                                <div class="col-sm-4 col-6">
                                                    <input type="radio" class="radio" name="active" id="active_0"
                                                           value="0" v-model="item.attributes.active"/>
                                                    <label dusk="active_0" for="active_0" style="margin-right: 12px;"> Черновик</label>
                                                </div>
                                                <div class="col-sm-4 col-6">
                                                    <input type="radio" class="radio" name="active" id="active_1"
                                                           value="1"  v-model="item.attributes.active"/>
                                                    <label dsk="active_1" for="active_1"> Опубликовать</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr/>
                            <category-selector
                                    v-if="item !== null"
                                    v-model = "item.relationships.categories"
                                    @change="categoryChanged"
                            ></category-selector>
                            <hr/>
                            <h5>Описание идеи</h5>
                            <div class="form-group">
                                <label for="frm_title">Заголовок<span title="Обязательное поле" class="required-star">*</span></label>
                                <input id="frm_title" name="title" class="form-control" placeholder="" type="text" maxlength="100" v-model="item.attributes.title" />
                            </div>
                            <div class="form-group">
                                <label for="frm_intro">Короткое описание<span title="Обязательное поле" class="required-star">*</span></label>
                                <textarea class="form-control" placeholder="" name="intro" id="frm_intro" rows="6" v-model="item.attributes.intro"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Полное описание<span title="Обязательное поле" class="required-star">*</span></label>
                                <ckeditor :editor="editor" :config="editorConfig" v-model="item.attributes.description" id="frm_description"></ckeditor>
                            </div>

                            <div>
                                <span class="text-secondary">(<span class="required-star">*</span>) отмечены необходимые поля</span>
                            </div>
                            <hr/>
                            <extended-tag-selector v-if="item" v-model="item.relationships.tags"></extended-tag-selector>

                        </form>
                    </div>
                    <div class="tab-pane fade" id="edit-images-block" role="tabpanel" aria-labelledby="edit-images-block-tab">
                        <photo-uploader
                                :type="this.item.type"
                                :item-id="item.id"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // MIXINGS
    import Editable from '../../mixins/Editable.js';

    import PhotoUploader from '../photo/PhotoUploader.vue';
    import LocaleSelector from '../LocaleSelector.vue';
    import ExtendedTagSelector from '../ExtendedTagSelector.vue';
    import CategorySelector from '../CategorySelector.vue';


    export default {

        name: "IdeaEditor",
        props: ['propTitle', 'propUser', 'propCityId', 'propItemId', 'propLocale'],

        mixins: [ Editable ],

        components: {
            PhotoUploader, LocaleSelector, CategorySelector, ExtendedTagSelector
        },

        data(){
            return{
                type: 'ideas',
            }
        },

        computed: {
            documentTitle: function(){
                if(this.dataLoaded){
                    if(!this.item.id) {
                        return 'Новая идея'
                    }else{
                        return 'Редактирование идеи';
                    }
                }
            },

        },

        methods: {

            categoryChanged(){
                if(this.item.relationships.categories.length){
                    this.item.attributes.main_category_id = this.item.relationships.categories[0].id;
                }else{
                    this.item.attributes.main_category_id = null;
                }
            },

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
</style>