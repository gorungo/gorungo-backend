<template>
    <div id="office-ideas-list">
        <div class="py-3 header_vs_btn d-flex justify-content-between">
            <h2 class="text-first-uppercase">{{Lang.get('texts.my_ideas')}}</h2>
            <a href="/ideas/create" class="btn btn-lg btn-outline-primary">{{Lang.get('idea.create')}}</a>
        </div>
        <div v-if="userIdeas.length > 0" v-loading="loading">
            <list-item-line
                v-for="(idea, index) in userIdeas"
                :key="idea.hid"
                :item="idea"
                @edit="handleEdit"
                @delete="handleDelete"
            />
        </div>
        <el-card class="box-card" v-if="userIdeas.length === 0" v-loading="loading">
            <h5 class="text-center">Нет идей</h5>
        </el-card>
    </div>
</template>

<script>
    import Localized from '../../mixins/Localized.js';
    import Notify from '../../mixins/Notify.js';
    import { Loading } from 'element-ui';
    import ListItemLine from "../idea/ListItemLine";
    import {mapGetters, mapActions, mapState} from 'vuex';

    export default {
        name: "OfficeIdeasList",

        mixins: [Localized, Notify],

        components: {ListItemLine, Loading},

        data(){
            return {
                ideas: [],
                loading: false,
            }
        },

        async mounted(){
            try {
                if(this.userIdeas.length === 0){
                    this.loading = true;
                    await this.fetchUserIdeas();
                }
            } catch (e){
                console.log(e);
            }
            this.loading = false;
        },

        computed: {
            ...mapState('Idea', ['userIdeas']),
        },

        methods: {

            ...mapActions('Idea', ['fetchUserIdeas']),
            ...mapActions(['initialiseStore']),

            handleEdit(idea){
                window.location.href = idea.attributes.editUrl;
            },

            handleDelete(idea){

            }
        },

    }
</script>

<style scoped>

</style>
