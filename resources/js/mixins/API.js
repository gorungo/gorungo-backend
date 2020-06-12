// Ideas API
export const IdeaAPI = {
    methods: {
        /**
         * Get all ideas of User
         */
        async getUserIdeas(user){
            if(user){
                const url = `/api/${window.systemInfo.apiVersion}/users/${user.id}/ideas`;
                return axios.get(url);
            }
            return [];
        }
    }
};

export const PlaceAPI = {
    methods: {

    }
};

export const CurrencyAPI = {
    methods: {
        async getCurrencies(){
            const url = '/api/' + window.systemInfo.apiVersion + '/currencies/active';
            return axios.get( url, { params: {
                    locale: this.locale,
                }}
            );
        }
    }
};