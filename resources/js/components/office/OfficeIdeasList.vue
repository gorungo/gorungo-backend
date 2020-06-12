<template>
    <div id="office-ideas-list">
        <div class="py-3 header_vs_btn d-flex justify-content-between">
            <h2 class="text-first-uppercase">{{Lang.get('texts.my_ideas')}}</h2>
            <a href="/ideas/create" class="btn btn-lg btn-outline-primary">{{Lang.get('idea.create')}}</a>
        </div>
        <el-card v-loading="loading" class="box-card mb-2" v-if="ideas.length > 0" v-for="(idea, index) in ideas" :key="idea.id">
            <div class="d-flex justify-content-between">
                <div class="description d-flex">
                    <el-image
                            style="width: 60px; height: 80px"
                            :src="idea.attributes.imageUrl"
                            fit="cover">
                    </el-image>
                    <div class="ml-3">
                        <div>
                            <h5>
                                {{ idea.attributes.title }}
                            </h5>
                        </div>
                        <div>
                            <span>
                                {{ idea.attributes.intro }}
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <a :href="idea.attributes.editUrl"><el-button type="primary" icon="el-icon-edit" plain circle></el-button></a>
                    <el-button type="danger" icon="el-icon-delete" plain circle></el-button>
                </div>
            </div>
        </el-card>
        <el-card class="box-card" v-if="ideas.length === 0">
            <h5 class="text-center">Нет идей</h5>
        </el-card>
    </div>
</template>

<script>
    import Localized from '../../mixins/Localized.js';
    import {IdeaAPI} from '../../mixins/API.js';
    import Authorized from '../../mixins/Authorized.js';
    import Notify from '../../mixins/Notify.js';
    import { Loading } from 'element-ui';

    export default {
        name: "OfficeIdeasList",

        mixins: [Authorized, Localized, Notify, IdeaAPI],

        components: {Loading},

        data(){
            return {
                ideas: [],
                loading: false,
            }
        },

        async mounted(){
            try {
                this.loading = true;
                const res = await this.getUserIdeas(this.activeUser);
                this.ideas = res.data;
            } catch (e){
                this.showNotification('Fuck', 'You broke an application');
            }
            this.loading = false;
        },


        methods: {

        },

    }
</script>

<style scoped>

</style>