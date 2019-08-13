<template>
    <div id="profile-editor">
        <div class="w-100">
            <div class="card">
                <div class="card-body">
                    <div class="row w-100">
                        <div class="col-sm-12 col-md-8">
                            <h2>{{this.actionTitle}}</h2>
                        </div>
                        <div class="col-sm-12 col-md-4 text-right">
                            <div v-if="loading" dusk="loading" class="spinner-border float-right" role="status" aria-hidden="true"></div>
                            <button v-else class="btn btn-primary float-right" dusk="savebtn" v-on:click.prevent="saveForm()">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center my-4">
                <div class="col-11">
                    <div class="mt-4">
                        <div class="row">
                            <div class="col-4">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-profile-tab" @click="setActiveTab('profile')" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">Профиль</a>
                                    <a class="nav-link" id="v-pills-password-tab" @click="setActiveTab('password')" data-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-password" aria-selected="false">Пароль</a>
                                </div>
                            </div>
                            <div class="col-8 card card-body">
                                <errors :errors="errors"></errors>
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                        <div v-if="item">
                                            <div class="form-group row">
                                                <div class="col-md-4 col-form-label text-md-right">
                                                    <div id="profile-photo">
                                                        <img :src="item.attributes.imageUrl"  style="height:2.5rem;"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div>Фото профиля</div>
                                                    <div class="file-upload bs">
                                                        <a>сменить</a>
                                                        <input type="file" name="image" id="file_uploader" accept="image/*" @change="fileInputChange" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label text-md-right">Имя</label>
                                                <div class="col-md-8">
                                                    <input id="name" type="text" class="form-control" name="name" v-model="item.attributes.name" required autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label text-md-right">Имя пользователя</label>
                                                <div class="col-md-8">
                                                    <input id="username" type="text" class="form-control" name="username" v-model="item.relationships.user.attributes.name" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="site" class="col-md-4 col-form-label text-md-right">Эл. адрес</label>
                                                <div class="col-md-8">
                                                    <input id="email" type="text" class="form-control" v-model="item.relationships.user.attributes.email" name="email">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="site" class="col-md-4 col-form-label text-md-right">Сайт</label>
                                                <div class="col-md-8">
                                                    <input id="site" type="text" class="form-control" v-model="item.attributes.site" name="site">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="site" class="col-md-4 col-form-label text-md-right">Телефон</label>
                                                <div class="col-md-8">
                                                    <input id="phone" type="text" class="form-control" v-model="item.attributes.phone" name="site">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="description" class="col-md-4 col-form-label text-md-right">Описание</label>
                                                <div class="col-md-8">
                                                    <input id="description" maxlength="200" type="text" class="form-control" v-model="item.attributes.description" name="description">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="sex" class="col-md-4 col-form-label text-md-right">Пол</label>
                                                <div class="col-md-8">
                                                    <select id="sex" class="form-control" name="sex" v-model="item.attributes.sex"  required>
                                                        <option value="0">Не выбрано</option>
                                                        <option value="1">Мужской</option>
                                                        <option value="2">Женский</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">Старый пароль</label>

                                            <div class="col-md-6">
                                                <input id="password-old" v-model="password.old" type="password" class="form-control" name="password" required>
                                            </div>
                                        </div>
<hr>
                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">Новый пароль</label>

                                            <div class="col-md-6">
                                                <input id="password" v-model="password.new" type="password" class="form-control" name="password" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтвердите новый пароль</label>

                                            <div class="col-md-6">
                                                <input id="password-confirm" v-model="password.new_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    import PlaceSelector from '../PlaceSelector.vue';
    import LocaleSelector from '../LocaleSelector.vue';


    export default {

        name: "ProfileEditor",
        props: ['propTitle', 'propUser', 'propCityId', 'propItemId', 'propLocale', 'propIdeaId'],

        mixins: [ Editable ],

        components: {
            PhotoUploader, DateSelector, PlaceSelector, LocaleSelector
        },

        data(){
            return{
                type: 'profiles',
                fileProgress: 0,
                filesOrder: [],
                fileCurrent: '',
                files: [],

                tab: 'profile',

                password: {
                    old: '',
                    new: '',
                    new_confirmation: '',
                },
            }
        },

        computed: {

            actionTitle(){
                if(this.dataLoaded){
                    if(!this.item.id) {
                        return 'Профиля пользователя'
                    }else{
                        return 'Профиля пользователя';
                    }
                }
            },
        },

        methods: {

            fetchRequestParams(){
                return {
                    locale: this.locale,
                    idea_id: this.ideaId,
                }
            },
            async fileInputChange(){

                let files = Array.from(event.target.files);

                this.filesOrder = files.slice();

                files.forEach(file => this.addImage(file));

                for( let file of files){
                    await this.uploadFile(file);
                }

            },

            async uploadFile(file){

                let form = new FormData();
                form.append('image', file);

                this.loading = true;

                await axios.post(this.getFilesRequestUrl(), form, {
                    onUploadProgress: (itemUpload)=>{

                        this.fileProgress = Math.round((itemUpload.loaded / itemUpload.total) * 100);
                        this.fileCurrent = file.name + ' ' + this.fileProgress;

                    }
                }).then(resp => {
                    if (resp.status === 200 || resp.status === 201) {
                        this.fileProgress = 0;
                        this.item.attributes.imageUrl = resp.data.file;
                    }

                    this.loading = false;

                }).catch(error => {
                    this.loading = false;
                }).finally(()=>{
                    this.loading = false;
                })
            },
            addImage(file){

                if(!file.type.match('image.*')){
                    console.log(`${file.name} is not an image`);
                    return;
                }

                this.filesOrder.push(file);

                const reader = new FileReader();
                reader.onload = (e) =>this.imagesOrder.push(e.target.result);

                reader.readAsDataURL(file);

            },

            savePassword(){
                axios({

                    method: 'PATCH',
                    url: this.savePasswordRequestUrl(),
                    data: {password: this.password},

                }).then( (resp) => {

                    this.loading = true;
                    this.errors = null;

                    this.password.old = '';
                    this.password.new = '';
                    this.password.new_confirmation = '';

                    if (resp.status === 200 || resp.status === 201) {

                        if(resp.data.type){
                            userui.showNotification(resp.data.message ? resp.data.message : 'Успешно сохранено', 'green');
                        }else{
                            userui.showNoInternetNotification();
                        }

                    }

                }).catch( (error) => {

                    if(error.response){
                        if(error.response.data.errors){
                            this.errors = error.response.data.errors;
                        }
                    }

                    if (error.response === undefined) {
                        userui.showNoInternetNotification();
                    }

                    this.loading = false;

                }).finally( () => {
                    this.loading = false;
                })
            },

            getFilesRequestUrl(){
                return '/api/' + window.systemInfo.apiVersion + '/' + this.type.toLowerCase() + '/' + this.itemId + '/photos';
            },
            savePasswordRequestUrl(){
                return '/api/' + window.systemInfo.apiVersion + '/users/' + this.item.relationships.user.id + '/setNewPassword' ;
            },

            saveForm(){
                switch(this.tab){
                    case 'profile':
                        this.formSubmit();
                        break;
                    case 'password':
                        this.password.email = this.item.relationships.user.attributes.email;
                        this.savePassword();
                        break;
                }
            },

            setActiveTab(tab){
                this.tab = tab;
                this.errors = null;
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
</style>