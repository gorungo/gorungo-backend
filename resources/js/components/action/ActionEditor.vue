<template>
    <div>
        <div class="w-100">
            <div class="card">
                <div class="card-body">
                    <div class="row w-100">
                        <div class="col-sm-12 col-md-8">
                            <h2>{{this.actionTitle}}</h2>
                        </div>
                        <div class="col-sm-12 col-md-4 text-right">
                            <div v-if="loading" dusk="loading" class="spinner-border float-right" role="status" aria-hidden="true"></div>
                            <button v-else class="btn btn-primary float-right" dusk="savebtn" v-on:click.prevent="formSubmit()">Сохранить</button>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="d-flex justify-content-center">
                                <ul class="nav nav-pills">
                                    <li role="presentation" id="tab_main"class="active">
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


        <div v-if="dataLoaded" class="mt-4">
            <div class="container">
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
                            <place-selector
                                    v-if="item !== null"
                                    :locale = "locale"
                                    :places = "item.relationships.places"
                            ></place-selector>
                            <date-selector
                                    v-if="item !== null && item.relationships.dates !== undefined"
                                    :locale = "locale"
                                    v-model = "item.relationships.dates"
                            ></date-selector>
                            <hr/>
                            <h5>Описание действия</h5>
                            <div class="form-group">
                                <label for="frm_title">Заголовок<span title="Обязательное поле" class="required-star">*</span></label>
                                <input id="frm_title" name="title" class="form-control" placeholder="" type="text" maxlength="100" v-model="item.attributes.title" />
                            </div>
                            <div class="form-group">
                                <label for="frm_intro">Короткое описание<span title="Обязательное поле" class="required-star">*</span></label>
                                <textarea class="form-control" placeholder="" name="intro" id="frm_intro" rows="6" v-model="item.attributes.intro"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="frm_description">Полное описание<span title="Обязательное поле" class="required-star">*</span></label>
                                <textarea class="form-control" placeholder="" name="description" id="frm_description" rows="6" v-model="item.attributes.description"></textarea>
                            </div>

                            <div>
                                <span class="text-secondary">(<span class="required-star">*</span>) отмечены необходимые поля</span>
                            </div>
                            <hr/>
                            <div class="clearfix mt-4">
                                <div v-if="errors" class="form-group text-left">
                                    <div class="alert alert-danger">
                                        <ul>
                                            <li v-for="error in errors">{{error[0]}}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

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
    import DateSelector from '../DateSelector.vue';
    import PlaceSelector from '../place/PlaceSelector.vue';
    import LocaleSelector from '../LocaleSelector.vue';


    export default {

        name: "ActionEditor",
        props: ['propTitle', 'propUser', 'propCityId', 'propItemId', 'propLocale', 'propIdeaId'],

        mixins: [ Editable ],

        components: {
            PhotoUploader, DateSelector, PlaceSelector, LocaleSelector
        },

        data(){
            return{
                type: 'actions',

            }
        },

        computed: {


            actionTitle(){
                if(this.dataLoaded){
                    if(!this.item.id) {
                        return 'Новое действие'
                    }else{
                        return 'Редактирование действия';
                    }
                }
            },

            ideaId(){
                return this.propIdeaId;
            }

        },

        methods: {

            fetchRequestParams(){
                return {
                    locale: this.locale,
                    idea_id: this.ideaId,
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