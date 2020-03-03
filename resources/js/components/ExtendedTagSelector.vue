<template>
    <div id="extended-tag-block" v-if="extendedTags && extendedTags.length > 0">
        <div>
            <h5 class="text-first-uppercase">{{Lang.get('editor.label_for_season')}}</h5>
            <span v-for="(tag, index) in allSeasonTags">
            <input type="checkbox"
                   :id="'tag-seasons-' + index"
                   :key="'tag-seasons-' + tag.id"
                   :value="tag" v-model="selectedTags"
            />
        <label :for="'tag-seasons-' + index" style="margin-right: 0.5rem;">{{tag.attributes.name}}</label>
        </span>
        </div>
        <div>
            <h5 class="text-first-uppercase">{{Lang.get('editor.label_for_time')}}</h5>
            <span v-for="(tag, index) in allDayTimeTags">
            <input type="checkbox"
                   :id="'tag-daytime-' + index"
                   :key="'tag-daytime-' + tag.id"
                   :value="tag" v-model="selectedTags"
            />
        <label :for="'tag-daytime-' + index" style="margin-right: 0.5rem;">{{tag.attributes.name}}</label>
        </span>
        </div>
    </div>
</template>

<script>
    import Localized from '../mixins/Localized.js';
    export default {
        name: "ExtendedTagSelector",
        props: ['tags'],

        mixins: [Localized],

        model: {
            prop: 'tags',
            event: 'change',
        },

        data(){
            return {
                type: 'main_tags',

                dataLoaded:false,
                loading: false,
                extendedTags: null,
                selectedTags: [],
            }
        },

        created(){
            this.getAllExtendedTags();
            this.selectedTags = this.tags;
        },

        watch:{
            selectedTags(val){
                this.$emit('change', this.selectedTags);
            }
        },

        computed: {
            allSeasonTags(){
                if(this.extendedTags.length === 0) return [];
                return this.extendedTags.filter(tag => {
                    return tag.attributes.tag_group_id === 1;
                });
            },
            allDayTimeTags(){
                if(this.extendedTags.length === 0) return [];
                return this.extendedTags.filter(tag => {
                    return tag.attributes.tag_group_id === 3;
                });
            },
        },

        methods:{
            getAllExtendedTags(){

                if(this.loading) return;
                axios.get( this.fetchUrl(), { params:{
                        locale: this.locale,
                    } } )
                    .then( (resp) => {
                        if (resp.status === 200) {
                            this.dataLoaded = true;
                            this.extendedTags = resp.data;
                        }

                    }).catch( (error) => {

                    if (error.response === undefined) {
                        userui.showNoInternetNotification();
                    }

                    this.loading = false;

                }).finally( () => {
                    this.loading = false;
                })
            },

            fetchUrl: function(){
                return '/api/' + window.systemInfo.apiVersion + '/tags/allMain'  ;
            },
        },

    }
</script>

<style scoped>

</style>