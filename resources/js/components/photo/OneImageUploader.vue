<template>
    <div>
        <div class="file_uploader mt-2" v-loading="loading">
            <div class="file_upload bs btn btn-outline-primary" :class="filesOrder.length ? 'file-uploaded' : ''" v-if="uploadAvailable && !loading">
                <span><i class="el-icon-upload2 mr-2"></i>{{uploadButtonTitle}}</span>
                <input type="file" name="image" accept="image/*" @change="onUploadClick" class="image-upload-input" />
            </div>
            <div v-if="(!uploadAvailable || actionUrl === '') && !loading" class="file_upload">
                {{Lang.get('editor.label_can_add_image_after_saving')}}
            </div>
            <div v-if="loading" class="file_upload">
                <div class="spinner-border" role="status">
                    <span class="sr-only">{{Lang.get('editor.loading')}}...</span>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import Localized from '../../mixins/Localized';
    export default {
        name: "OneImageUploader",

        mixins: [Localized],

        props: {
            propFullTmbImgPath: Object,
            actionUrl: String,
            buttonTitle: String,
            // use image clipper before upload
            clipper: Boolean,
            uploadAvailable: Boolean,
        },

        model: {
            prop: 'fullTmbImgPath',
            event: 'change',
        },

        data() {
            return {
                fullTmbImgPath: {},

                fileProgress: 0,
                filesOrder: [],
                fileCurrent: '',
                files: [],

                loading: false,
                maxFileSize: 5000000,

            }
        },

        mounted(){
            this.fullTmbImgPath = this.propFullTmbImgPath;
        },

        computed: {
            uploadButtonTitle(){
                if(this.buttonTitle !== undefined && this.buttonTitle != null && this.buttonTitle !== '' ) return this.buttonTitle;
                return Lang.get('texts.upload');
            }
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

                if(this.checkFileSize(file)) {
                    return;
                }

                let form = new FormData();
                form.append('image', file);

                this.loading = true;

                await axios.post(this.actionUrl, form, {
                    onUploadProgress: (itemUpload)=>{

                        this.fileProgress = Math.round((itemUpload.loaded / itemUpload.total) * 100);
                        this.fileCurrent = file.name + ' ' + this.fileProgress;

                    }
                }).then(resp => {
                    if (resp.status === 200 || resp.status === 201) {
                        this.fileProgress = 0;
                        this.fullTmbImgPath = resp.data.file;

                        this.$emit('change', this.fullTmbImgPath);
                        this.$emit('uploaded', this.fullTmbImgPath)
                    }

                    this.loading = false;

                }).catch(error => {
                    this.loading = false;
                    this.$emit('error');
                }).finally(()=>{
                    this.loading = false;
                })
            },
            addImage(file){
                if(!file.type.match('image.*')){
                    return;
                }

                this.filesOrder.push(file);

                const reader = new FileReader();
                reader.onload = (e) =>this.filesOrder.push(e.target.result);

                reader.readAsDataURL(file);

            },

            onUploadClick(){
                this.fileInputChange();
            },

            checkFileSize(file) {
                if(file.size > this.maxFileSize) {
                    this.$message.error(Lang.get('editor.max_file_size_limit') + ' ' + this.maxFileSize / 100000 + Lang.get('editor.megabyte')+'.');
                    return true;
                }
                return false;
            },
        },



    }
</script>

<style scoped>
    .file_upload {
        position: relative;
        width: 100%;
        text-align: center;
        overflow: hidden;
        cursor: pointer;
    }
    .file_upload:hover {
        background: blue;

    }
    .file_upload input[type=file] {
        /* Позиционируем правый верхний край
           input поверх нашего контейнера.
           Правый верхний потому как именно там
           у нас кнопка. */
        position: absolute;
        top: 0; right: 0;

        /* Делаем input побольше, чтобы он точно
           перекрыл контейнер. */
        font-size: 200px;

        /* Делаем input невидимым. По-другому нельзя,
           иначе браузер не будет на него реагировать. */
        opacity: 0;
        filter: alpha(opacity=0);

        /*  Украшательства: */
        cursor: pointer;
    }
</style>
