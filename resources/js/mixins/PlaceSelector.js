export default {

    data(){
        return{
            foundPlaces: [],
        }
    },

    methods:{
        getPlacesByTitle:
            _.debounce(function(title){

                    this.foundPlaces = [];

                    axios.get( this.placesByTitleRequestUrl(), { params:{
                            locale: this.locale,
                            title: title,
                        } } )
                        .then( (resp) => {
                            if (resp.status === 200) {
                                this.dataLoaded = true;
                                this.foundPlaces = resp.data.data;
                            }

                        }).catch( (error) => {

                        if (error.response === undefined) {
                            userui.showNoInternetNotification();
                        }

                    }).finally( () => {
                        this.loading = false;
                    })


            }, 500),

        placesByTitleRequestUrl: function(){
            return '/api/' + window.systemInfo.apiVersion + '/' + this.type + '/getByTitle' ;
        },
    }

}