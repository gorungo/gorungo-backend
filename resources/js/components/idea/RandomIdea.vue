<template>
    <div>
        <div class="text-center mb-2" v-if="!loading">
            <h5>
                <span @click="showIdea" class="btn btn-lg btn-outline-success btn-random-idea text-success text-uppercase"><i class="fas fa-meteor"></i> {{Lang.get('idea.random_idea')}}</span>
            </h5>
        </div>
        <div>
            <!-- Modal -->
            <div class="modal fade" id="randomIdeaModal" tabindex="-1" role="dialog" aria-labelledby="randomIdeaModalTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="randomIdeaModalTitle">{{Lang.get('idea.idea_for_you')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" v-if="item">
                            <div class="card list-item mb-4">
                                <a :href="item.attributes.url">
                                    <div class="card-img__cover">
                                        <img class="card-img" :src="item.attributes.imageUrl" width="100%"/>
                                    </div>
                                </a>
                                <div class="card-body text-center">
                                    <a :href="item.attributes.url">
                                        <h4 class="card-title">{{item.attributes.title}}</h4>
                                    </a>
                                    <p class="card-text text-secondary">{{item.attributes.intro}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button @click="otherIdea" type="button" class="btn btn-outline-success text-uppercase"><i class="fas fa-sync"></i> {{Lang.get('idea.other_idea')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="loading" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">{{Lang.get('editor.loading')}}...</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "RandomIdea",

        data() {
            return {
                locale: 'en',
                type: 'ideas',
                loading: false,
                item: null,
            }
        },

        mounted() {
            this.locale = Lang.getLocale();
        },

        methods: {
            fetchRandomIdea() {
                if(!this.loading){
                    axios.get( this.fetchRandomIdeaRequestUrl(), {
                        params: {
                            locale: this.locale,
                        } } )
                        .then( (resp) => {

                            this.loading = true;
                            if (resp.status === 200) {
                                this.item = resp.data.data;
                            }

                        }).catch( (error) => {

                    }).finally( () => {
                        this.loading = false;
                    })
                }
            },

            fetchRandomIdeaRequestUrl(){
                return '/api/' + window.systemInfo.apiVersion + '/' + this.type + '/randomIdea' ;
            },

            showIdea(){
                this.fetchRandomIdea();
                $('#randomIdeaModal').modal('show');
            },

            otherIdea(){
                this.fetchRandomIdea();
            }
        },

        computed:{
            Lang(){
                return Lang;
            }
        }

    }
</script>

<style scoped>

    .modal-footer{
        justify-content: center;
    }

    .card-img__cover{
    }

    .card-img{
        object-fit: cover;
        max-height: 400px;
    }
    .btn-random-idea:hover{
        color: white !important;
    }

</style>