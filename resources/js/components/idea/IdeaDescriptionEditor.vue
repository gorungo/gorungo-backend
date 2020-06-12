<template>
    <div id="idea-description-editor">
        <el-form label-position="top" :model="item" ref="descriptionForm" label-width="120px" class="demo-dynamic">
            <h4 class="text-first-uppercase mb-4">{{Lang.get('idea.idea_description')}}</h4>
            <el-form-item :label="Lang.get('editor.label_title')">
                <el-input
                        v-model="item.attributes.title"
                        maxlength="190" show-word-limit
                ></el-input>
            </el-form-item>
            <el-form-item :label="Lang.get('editor.label_intro')">
                <el-input
                        v-model="item.attributes.intro"
                        maxlength="250"
                        show-word-limit
                ></el-input>
            </el-form-item>
            <el-form-item :label="Lang.get('editor.label_description')">
                <el-input
                        type="textarea"
                        v-model="item.attributes.description"
                ></el-input>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    import Localized from '../../mixins/Localized';

    export default {
        name: "IdeaDescriptionEditor",

        props: {
            item: Object,
        },

        mixins: [Localized],

        model:{
            prop: 'item',
            event: 'change'

        },

        data(){
            return {

            }
        }
    }
</script>

<style scoped>

</style>