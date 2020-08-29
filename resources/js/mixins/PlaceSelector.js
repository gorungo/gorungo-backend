
export default {

    data(){
        return{
            foundPlaces: [],
        }
    },

    methods:{
        async getAsyncRegionOrCityByTitle(){
            try {
                return await axios.get( this.getRegionOrCityByTitleFetchUrl, {
                        params: {
                            locale: this.locale,
                            title: title,
                        }
                    }
                );
            } catch (e) {

            }

        },
        getRegionOrCityByTitle:
            _.debounce(function(title){

                    this.foundPlaces = [];

                    axios.get( this.getRegionOrCityByTitleFetchUrl, { params:{
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

        getPlacesByTitle:
            _.debounce(function(title){

                this.foundPlaces = [];

                axios.get( this.placesByTitleFetchUrl, { params:{
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

        async fetchLastPlaces(){
            try {
                //todo
                //const lastPlaces = await axios.get(this.lastPlacesFetchUrl);
                //return lastPlaces;

            } catch (e) {
                console.error(e.message);
            }
        },

    },

    computed: {
        placesByTitleFetchUrl: function(){
            return '/api/' + window.systemInfo.apiVersion + '/' + this.type + '/getByTitle' ;
        },
        getRegionOrCityByTitleFetchUrl: function(){
            return '/api/' + window.systemInfo.apiVersion + '/' + this.type + '/getByTitle' ;
        },
        lastPlacesFetchUrl(){
            return '/api/' + window.systemInfo.apiVersion + '/places/lastSearchedPlaces' ;
        },
    }

}
