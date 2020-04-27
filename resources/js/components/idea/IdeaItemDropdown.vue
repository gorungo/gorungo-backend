<template>
    <div>
        <el-dropdown :hide-on-click="false">
              <span class="el-dropdown-link">
                <i class="el-icon-arrow-down el-icon--right"></i>
              </span>
            <el-dropdown-menu slot="dropdown">
                <el-dropdown-item divided v-if="canEdit">
                    <a :href="editUrl">{{Lang.get('editor.edit')}}</a>
                </el-dropdown-item>
                <el-dropdown-item v-if="canAppeal">{{Lang.get('idea.make_appeal')}}</el-dropdown-item>
            </el-dropdown-menu>
        </el-dropdown>
    </div>
</template>

<script>
    import Localized from '../../mixins/Localized.js';

    export default {
        name: "IdeaItemDropdown",

        mixins: [Localized],

        props: {
            hid: {
                type: String,
                required: true,
            },
            canEdit: {
                type: Boolean,
                default: false,
            },
            editUrl: {
                type: String,
                default: null,
            }
        },

        data(){
            return {

            }
        },

        computed: {
            url(){

            },

            canAppeal(){
                return false;
            }
        },

        methods: {
            showAppealWindow(){

            },
        }
    }
</script>

<style scoped>

</style>