<template>
    <div id="tags-editor">
        <h5 class="text-first-uppercase">{{Lang.get('editor.label_tags')}}</h5>
        <el-tag
                :key="tag"
                v-for="(tag, index) in tagsArray"
                closable
                :disable-transitions="false"
                @close="handleClose(index)">
            {{tag}}
        </el-tag>
        <el-input
                class="input-new-tag"
                v-if="inputVisible"
                v-model="inputValue"
                ref="saveTagInput"
                size="mini"
                @keyup.enter.native="handleInputConfirm"
                @blur="handleInputConfirm"
        >
        </el-input>
        <el-button v-else class="button-new-tag" size="small" @click="showInput">+ {{Lang.get('editor.label_new_tag')}}</el-button>
    </div>

</template>

<script>
    import Localized from '../../mixins/Localized.js';
    export default {
        name: "TagsEditor",
        mixins: [Localized],
        data() {
            return {
                inputVisible: false,
                inputValue: '',

                dataTags: [],
            };
        },

        props: {
            tags: Array,
        },

        model:{
            prop: 'tags',
            event: 'change',
        },

        mounted() {
            this.dataTags = this.tags;
        },

        watch:{
            tags(val){
                this.dataTags = val;
            },
        },

        methods: {
            handleClose(index) {
                this.dataTags.splice(index, 1);
                this.$emit('change', this.dataTags);
            },

            showInput() {
                this.inputVisible = true;
                this.$nextTick(_ => {
                    this.$refs.saveTagInput.$refs.input.focus();
                });
            },

            handleInputConfirm() {
                let inputValue = this.inputValue;
                if (inputValue) {
                    let newTag = {
                        type: 'tagging_tag',
                        id: null,
                        attributes: {
                            name: this.go.firstToUpperCase(inputValue),
                            slug: this.go.firstToUpperCase(inputValue),
                            tag_group_id: 4,
                        },
                        relationships: {},
                    };
                    this.dataTags.push(newTag);
                }
                this.$emit('change', this.dataTags);
                this.inputVisible = false;
                this.inputValue = '';
            }
        },

        computed: {
            tagsArray(){
                return this.dataTags.map(item => {
                    return item.attributes.name;
                });
            },
            go(){
                return window.go;
            },
        }
    }
</script>

<style scoped>
    .el-tag {
        margin-right: 0.5rem;
        margin-bottom: 0.25rem;
    }
    .button-new-tag {
        height: 32px;
        line-height: 30px;
        padding-top: 0;
        padding-bottom: 0;
        margin-bottom: 0.25rem;
        margin-right: 0.5rem;
    }
    .input-new-tag {
        width: 90px;
        vertical-align: top;
        margin-bottom: 0.25rem;
        margin-right: 0.5rem;
    }
</style>