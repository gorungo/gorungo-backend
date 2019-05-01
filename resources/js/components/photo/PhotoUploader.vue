<template>
    <div>
        <div class="card" :class="{dragging: isDragging}">
            <div class="card-body">
                <div v-if="itemId > 0">
                    <div class="picture-edit-wrap"
                         @dragover.prevent
                         @drop="onDrop"
                         @dragenter="onDragEnter"
                         @dragleave="onDragLeave"
                         >
                        <div class="picture_edit clearfix">
                            <div v-if="!files.length && !filesOrder.length" class="text-center">
                                <span class="icomoon" style="font-size: 100px; color: #c4e7f9;"></span>
                                <p>Перетащите cюда фотографии, либо нажмите кнопку "Добавить изображение"</p>
                            </div>
                            <div class="tmb-sml" v-for="(file, index) in files">
                                <div class="del-btn" v-on:click="deletePhoto(index)">
                                    <img src="/images/interface/icos/ico_del.png"/>
                                </div>
                                <div class="star-btn"  v-on:click="setMainPhoto(index)">
                                    <img src="/images/interface/icos/ico_star.png">
                                </div>
                                <div class="tmb-sml-in">
                                    <img :src="file.url" border=0 height="100%"/>
                                </div>
                            </div>
                            <div class="tmb-sml" v-for="(file, index) in imagesOrder">
                                <div class="tmb-sml-in">
                                    <img src="/images/interface/loaders/loader.gif" class="img-loader" height="50px"/>
                                    <img :src="file" class="img-is-loading" border=0 height="100%"/>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="">
                        <div v-if="loading" class="progress" style="height: 1px">
                            <div class="progress-bar" role="progressbar" :style="{ width: fileProgress + '%'}"></div>
                        </div>
                        <hr v-if="!loading">
                        <div class="file-upload bs">
                            <span class="icomoon" style="font-size: 18px;"> </span> Добавить изображение
                            <input type="file" name="image" id="file_uploader" multiple="" accept="image/*" @change="fileInputChange" />
                        </div>
                        <div v-if="files.length > 0" class="blue_info_block">Выберите фото и нажмите <img id="img_star" src="/images/interface/icos/ico_star.png">, чтобы сделать изображение главным</div>
                        <div class="row" v-if="loading">
                            <div class="col-sm-6">
                                <h5 class="text-center">Файлы в очереди ({{ filesOrder.length}})</h5>
                            </div>
                            <div class="col-sm-6">
                                <h5 class="text-center">Загруженные файлы ({{ filesFinish.length}})</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center">
                    <span class="icomoon" style="font-size: 100px; color: #c4e7f9;"></span>
                    <p>Возможность добавить фотографии появится после сохранения</p>
                </div>
            </div>
        </div>
        <img style="display: none;" src="/images/interface/loaders/loader.gif" class="img-loader" border=0 />
    </div>
</template>

<script>

    export default {

        name: "PhotoUploader",
        props: ['type', 'itemId'],


        data: function() {
            return {
                filesOrder: [],
                imagesOrder: [],
                filesFinish: [],
                fileProgress: 0,
                fileCurrent: '',
                files: [],
                loading: false,

                isDragging: false,
                dragCount: 0,
            }
        },

        mounted() {
            this.test();
            this.initialise();
        },

        computed: {

        },

        methods: {
            async fileInputChange(){

                let files = Array.from(event.target.files);

                this.filesOrder = files.slice();

                files.forEach(file => this.addImage(file));

                for( let item of files){
                    await this.uploadFile(item);
                }

            },

            async uploadFile(item){

                let form = new FormData();
                form.append('image', item);

                this.loading = true;

                await axios.post(this.getFilesRequestUrl(), form, {
                    onUploadProgress: (itemUpload)=>{

                        this.fileProgress = Math.round((itemUpload.loaded / itemUpload.total) * 100);
                        this.fileCurrent = item.name + ' ' + this.fileProgress;

                    }
                }).then(resp => {
                    if (resp.status === 200) {
                        this.fileProgress = 0;
                        this.fileCurrent = '';
                        this.filesFinish.push(item);
                        this.filesOrder.splice(item, 1);
                        this.imagesOrder.splice(item, 1);

                        this.files.push(resp.data.file);

                    }

                    this.loading = false;

                }).catch(error => {
                    this.loading = false;
                }).finally(()=>{
                    this.loading = false;
                })
            },

            getFilesList(){

                this.loading = true;

                axios.get( this.getFilesRequestUrl(), {
                    params:{}
                }).then(resp => {
                    if (resp.status === 200) {
                        this.files = resp.data.files;
                    }
                }).catch(error => {
                    console.log(error);
                }).finally(()=>{
                    this.loading = false;
                })
            },

            setMainPhoto(index){

                this.loading = true;

                axios.patch( this.setMainImgRequestUrl(this.files[index].id), {
                    params:{}
                }).then(resp => {

                    if(resp.data.type === 'ok'){
                        userui.showNotification('Главное изображение установлено', 'green');
                    }

                }).catch(error => {

                    console.log(error);

                }).finally(()=>{
                    this.loading = false;
                })
            },

            deletePhoto(index){

                this.loading = true;

                axios.delete( this.deleteImgRequestUrl(this.files[index].id), {
                    params:{}
                }).then(resp => {

                    if(resp.data.type === 'ok'){
                        userui.showNotification('Изображение удалено');
                        this.files.splice(index,1);
                    }else{
                        userui.showNotification('Ошибка при удалении', 'red');
                    }


                }).catch(error => {
                    console.log(error);

                }).finally(()=>{
                    this.loading = false;
                })
            },

            initialise(){
                if(this.itemId){
                    this.getFilesList();
                }
            },

            test(){
                console.log('photo_uploader mounted');
            },

            getFilesRequestUrl(){
                return '/api/' + window.systemInfo.apiVersion + '/' + this.type.toLowerCase() + '/' + this.itemId + '/photos';
            },

            setMainImgRequestUrl(imgId){
                return '/api/' + window.systemInfo.apiVersion + '/' + this.type.toLowerCase() + '/' + this.itemId + '/photos/' + imgId + '/set_main';
            },

            deleteImgRequestUrl(imgId){
                return '/api/' + window.systemInfo.apiVersion + '/' + this.type.toLowerCase() + '/' + this.itemId + '/photos/' + imgId;
            },

            // drag and drop
            onDragEnter(e){

                e.preventDefault();

                this.dragCount++;
                this.isDragging = true;
            },

            onDragLeave(e){

                e.preventDefault();

                this.dragCount--;
                if(this.dragCount < 1) this.isDragging = false;

            },

            async onDrop(e){
                e.preventDefault();
                e.stopPropagation();

                this.isDragging = false;

                const filesOrder = e.dataTransfer.files;

                let files = Array.from(filesOrder);

                files.forEach(file => this.addImage(file));

                for( let item of files){
                    await this.uploadFile(item);
                }
            },

            addImage(file){

                if(!file.type.match('image.*')){
                    console.log('${file.name} is not an image');
                    return;
                }

                this.filesOrder.push(file);

                const reader = new FileReader();
                reader.onload = (e) =>this.imagesOrder.push(e.target.result);

                reader.readAsDataURL(file);


            },
        }
    }
</script>

<style scoped>
    .panel.dragging{
        border: 1px solid #2095ff !important;
    }
</style>