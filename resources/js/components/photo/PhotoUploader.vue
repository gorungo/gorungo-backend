<template>
    <div id="images-loader" class="images-loader">
        <div class="pb-4" :class="{dragging: isDragging}">
            <div v-if="itemId">
                <h4 class="text-capitalize mb-4">{{Lang.get('editor.label_pictures')}}</h4>
                <div class="picture-edit-wrap"
                     @dragover.prevent
                     @drop="onDrop"
                     @dragenter="onDragEnter"
                     @dragleave="onDragLeave"
                     >
                    <div class="picture_edit clearfix">
                        <div v-if="!files.length && !filesOrder.length" class="text-center">
                            <i class="fas fa-camera" style="font-size: 100px; color: #c4e7f9;"></i>
                            <p class="text-capitalize">{{Lang.get('editor.label_drag_images_or_press_upload')}}</p>
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
                        <i class="fas fa-upload"></i> {{Lang.get('editor.label_load_image')}}
                        <input type="file" name="image" id="file_uploader" multiple="" accept="image/*" @change="fileInputChange" />
                    </div>
                    <div v-if="files.length > 0" class="blue_info_block">{{Lang.get('editor.label_select_image_and_press_star_to_make_main')}} <img id="img_star" src="/images/interface/icos/ico_star.png"></div>
                </div>
            </div>
            <div v-else class="clearfix d-flex" style="justify-content: center;">
                <el-col :span="12">
                    <el-card class="box-card text-center" shadow="never">
                        <h3 class="text-first-uppercase">{{go.firstToUpperCase(Lang.get('editor.label_idea_images'))}}</h3>
                        <p class="text-first-uppercase">{{go.firstToUpperCase(Lang.get('editor.label_can_add_image_after_saving'))}}</p>
                    </el-card>
                </el-col>
            </div>
        </div>
        <img style="display: none;" src="/images/interface/loaders/loader.gif" class="img-loader" border=0 />
    </div>
</template>

<script>
    import Localized from '../../mixins/Localized';
    export default {

        name: "PhotoUploader",
        props: {
            type: String,
            itemId: Number,
            hid: String,
        },
        mixins: [Localized],


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

                maxFileSize: 10000000,
            }
        },

        mounted() {
            this.test();
            this.initialise();
        },

        computed: {
            go(){
                return window.go;
            },
        },

        methods: {
            async fileInputChange(){

                let files = Array.from(event.target.files);
                this.filesOrder = files.slice();

                files.forEach(file => this.addImage(file));

                for( let file of files){
                    await this.uploadFile(file);
                }

            },

            async uploadFile(file){

                if(!this.checkFileSize(file)) {
                    this.fileProgress = 0;
                    this.fileCurrent = '';
                    this.filesFinish.push(file);
                    this.filesOrder.splice(file, 1);
                    this.imagesOrder.splice(file, 1);
                    return false;
                }

                let form = new FormData();
                form.append('image', file);

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
                        this.filesFinish.push(file);
                        this.filesOrder.splice(file, 1);
                        this.imagesOrder.splice(file, 1);

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
                        userui.showNotification('?????????????? ?????????????????????? ??????????????????????', 'green');
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
                        userui.showNotification('?????????????????????? ??????????????');
                        this.files.splice(index,1);
                    }else{
                        userui.showNotification('???????????? ?????? ????????????????', 'red');
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

            checkFileSize(file) {
                if(file.size > this.maxFileSize) {
                    return false;
                }
                return true;
            },

            showMaxFileSizeLimitMessage(){
                this.$message.error(Lang.get('editor.max_file_size_limit') + ' ' + this.maxFileSize / 100000 + ' ' + Lang.get('editor.megabyte')+'.');
            },

            addImage(file){

                if(!this.checkFileSize(file)) {
                    this.showMaxFileSizeLimitMessage();
                    return false;
                }

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

<style scoped lang="scss">
    .panel.dragging{
        border: 1px solid #2095ff !important;
    }

    .images-loader {

        .tmb-sml .del-btn {
            right: 5px;
            top: 5px;
            padding-top: 10px;
            width: 32px;
            height: 44px;
            position: absolute;
            display: none;
            background: #000000;
            border-radius: 10px;
        }

        .tmb-sml:hover .del-btn {
            position: absolute;
            display: block;
            opacity: 0.5;
        }

        .tmb-sml:hover .del-btn:hover {
            position: absolute;
            display: block;
            opacity: 1;
        }

        .tmb-sml .star-btn {
            left: 5px;
            top: 5px;
            padding-top: 10px;
            width: 32px;
            height: 44px;
            position: absolute;
            display: none;
            background: #1cd500;
            border-radius: 10px;
        }

        .tmb-sml:hover .star-btn {
            position: absolute;
            display: block;
            opacity: 0.5;
        }

        .tmb-sml:hover .star-btn:hover {
            position: absolute;
            display: block;
            opacity: 1;
        }

        .tmb-sml-in img.img-loader {
            height: 30px;
            position: absolute;
            top: 40px;
            left: 40px;
            z-index: 1;
        }

        .tmb-sml-in img.img-is-loading {
            opacity: 0.2;
        }

        .picture-edit {
            overflow: hidden;
        }

        .tmb-big {
            height: 200px;
            margin: 0;
            text-align: center;
        }

        .tmb-sml {
            float: left;
            display: block;
            width: 120px;
            height: 120px;
            margin: 3px;
            border: 1px solid #f8f8f8;
            position: relative;
            text-align: center;
            background-color: #f8f8f8;
        }

        .tmb-sml-in img {
            height: 118px;
            width: 118px;
            object-fit: cover;
        }

        .tmb-sml:hover {
            border: 1px solid #0099ff;
        }

        .file-upload {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            width: 60%;
            background: white;
            border-radius: 2px !important;
            border: 1px solid #2095ff;
            -webkit-border-radius: 24px;
            -moz-border-radius: 24px;
            text-indent: 0;
            color: #2095ff;
            font-size: 14px;
            height: 40px;
            line-height: 40px;
            text-decoration: none;
            margin: 0 auto;
            text-align: center;
            white-space: nowrap;

        }

        .file-upload:hover {
            border: 1px solid #2095ff;

        }

        .file-upload input[type=file] {
            /* ?????????????????????????? ???????????? ?????????????? ????????
           input ???????????? ???????????? ????????????????????.
           ???????????? ?????????????? ???????????? ?????? ???????????? ??????
           ?? ?????? ????????????. */
            position: absolute;
            top: 0;
            right: 0;

            /* ???????????? input ????????????????, ?????????? ???? ??????????
           ???????????????? ??????????????????. */
            font-size: 200px;

            /* ???????????? input ??????????????????. ????-?????????????? ????????????,
           ?????????? ?????????????? ???? ?????????? ???? ???????? ??????????????????????. */
            opacity: 0;
            filter: alpha(opacity=0);

            /*  ????????????????????????????: */
            cursor: pointer;
        }
    }
</style>