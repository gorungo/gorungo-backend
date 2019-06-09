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
                <errors :errors="errors"></errors>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="edit-main-block" role="tabpanel" aria-labelledby="edit-main-block-tab">
                        <div class="row">
                            <div class="col-sm-7">
                                <form id="frm_form" name="frm_form" method="post" autocomplete="off">
                                    <place-type-selector v-model="item.relationships.placeType" :all-place-types="item.meta.allPlaceTypes"></place-type-selector>
                                    <hr>
                                    <h5>Описание</h5>
                                    <div class="form-group">
                                        <label for="frm_title">Заголовок<span title="Обязательное поле" class="required-star">*</span></label>
                                        <input id="frm_title" name="title" class="form-control" placeholder="" type="text" maxlength="100" v-model="item.attributes.title" />
                                    </div>
                                    <div class="form-group">
                                        <label for="frm_intro">Короткое описание<span title="Обязательное поле" class="required-star">*</span></label>
                                        <input id="frm_intro" name="intro" class="form-control" placeholder="" type="text" maxlength="100" v-model="item.attributes.intro" />
                                    </div>
                                    <div class="form-group">
                                        <label for="frm_description">Описание<span title="Обязательное поле" class="required-star">*</span></label>
                                        <textarea class="form-control" placeholder="Расскажите что-нибудь о месте" name="description" id="frm_description" rows="6" v-model="item.attributes.description"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-5">
                                <div v-if="item.relationships.address">
                                    <h5>Адрес</h5>
                                    <div class="form-group">
                                        <label for="frm_postal_code">Почтовый код<span title="Обязательное поле" class="required-star">*</span></label>
                                        <input id="frm_postal_code" name="postal_code" class="form-control" placeholder="" type="text" maxlength="100" v-model="item.relationships.address.attributes.postal_code" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="frm_country">Страна<span title="Обязательное поле" class="required-star">*</span></label>
                                        <input id="frm_country" name="country" class="form-control" placeholder="Например, Россия" type="text" maxlength="100" v-model="item.relationships.address.attributes.country" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="frm_region">Регион</label>
                                        <input id="frm_region" name="region" class="form-control" placeholder="Например, Приморский край" type="text" maxlength="100" v-model="item.relationships.address.attributes.region" />
                                    </div>
                                    <div class="form-group">
                                        <label for="frm_city">Город или населенный пункт</label>
                                        <input id="frm_city" name="city" class="form-control" placeholder="Например, Владивосток" type="text" maxlength="100" v-model="item.relationships.address.attributes.city" />
                                    </div>
                                    <div class="form-group">
                                        <label for="frm_address">Адрес</label>
                                        <input id="frm_address" name="address" class="form-control" placeholder="Например, ул. Горная, 4 кв. 3" type="text" maxlength="100" v-model="item.relationships.address.attributes.address" />
                                    </div>
                                </div>
                                <div>
                                    <hr>
                                    <h5>Координаты места</h5>
                                    <div class="form-row">
                                        <div class="col">
                                            <label for="frm_coordinates_lat">Широта<span title="Обязательное поле" class="required-star">*</span></label>
                                            <input id="frm_coordinates_lat" name="coordinates_lat" class="form-control" placeholder="" type="text" maxlength="100" v-model="item.attributes.coordinates.coordinates[0]" />
                                        </div>
                                        <div class="col">
                                            <label for="frm_coordinates_lat">Долгота<span title="Обязательное поле" class="required-star">*</span></label>
                                            <input id="frm_coordinates_lng" name="coordinates_lng" class="form-control" placeholder="" type="text" maxlength="100" v-model="item.attributes.coordinates.coordinates[1]" />
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                                <span class="text-secondary">(<span class="required-star">*</span>) отмечены необходимые поля</span>
                            </div>
                        </div>
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
    import YandexMap from "../YandexMap";
    import PlaceTypeSelector from "./PlaceTypeSelector";

    export default {

        name: "PlaceEditor",
        props: ['propTitle', 'propUser', 'propCityId', 'propItemId', 'propLocale'],

        mixins: [ Editable ],

        components: {
            PlaceTypeSelector,
            YandexMap,
            PhotoUploader
        },

        data(){
            return{
                type: 'places',

            }
        },

        computed: {

            actionTitle: function(){
                if(this.dataLoaded){
                    if(!this.item.id) {
                        return 'Новое место'
                    }else{
                        return 'Редактирование места';
                    }
                }
            },

        },

        methods: {

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