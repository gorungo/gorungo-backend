<template>
    <div id="extended-tag-block" v-if="extendedTags && extendedTags.tagsSeasonsGroup">
        <div>
            <h5 class="text-first-uppercase">{{Lang.get('editor.label_for_season')}}</h5>
            <span v-for="(tag, index) in extendedTags.tagsSeasonsGroup">
            <input type="checkbox"
                   :id="'tag-seasons-' + index"
                   :key="'tag-seasons-' + tag.id"
                   :value="extendedTags.tagsSeasonsGroup[index]" v-model="tags.tagsSeasonsGroup"
            />
        <label :for="'tag-seasons-' + index" style="margin-right: 0.5rem;">{{tag.attributes.name}}</label>
        </span>
        </div>
        <div>
            <h5 class="text-first-uppercase">{{Lang.get('editor.label_for_time')}}</h5>
            <span v-for="(tag, index) in extendedTags.tagsDayTimeGroup">
            <input type="checkbox"
                   :id="'tag-daytime-' + index"
                   :key="'tag-daytime-' + tag.id"
                   :value="extendedTags.tagsDayTimeGroup[index]" v-model="tags.tagsDayTimeGroup"
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
                type: 'extended_tags',

                dataLoaded:false,
                loading: false,
                extendedTags: null,
                selectedTags: {
                    tagsSeasonsGroup:[],
                    tagsAgeGroup:[],
                    tagsDayTimeGroup:[],
                },
            }
        },

        created(){
            this.getAllExtendedTags();
        },

        watch:{
            selectedTags(val){
                this.$emit('change', this.tags);
            }
        },

        methods:{
            getAllExtendedTags(){

                if(this.loading) return;
                console.log('dsfdf');
                axios.get( this.fetchUrl(), { params:{
                        locale: this.locale,
                        title: '',
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
                return '/api/' + window.systemInfo.apiVersion + '/ideas/' + this.type  ;
            },
        },

    }
</script>

<style scoped>

</style>