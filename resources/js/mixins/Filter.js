export default {

    data(){
        return{
            type: 'filters',
            locale: 'ru',
            filters: null,
            activeFilters: null,
            filterName: 'season',
            loading: false,
        }
    },

    mounted() {
        this.locale = Lang.locale;
        if(this.propFilters !== undefined && this.propFilters != null){
            this.filters = this.propFilters;
        }else{
            this.fetchFilterItems();
        }
    },

    watch:{
        activeFilters(val){
            if(val.length === 0){
                // if nothing selected
                this.activeFilters.push(this.filters[0]);
            }
        }
    },

    computed: {
        Lang() {
            return window.Lang;
        },

        URLActiveFilter: {
            // геттер:
            get: function () {
                let newUrl = new URL(decodeURI(window.location.href));
                return newUrl.searchParams.get(this.filterName);
            },
            // сеттер:
            set: function (newValue) {
                if(newValue){
                    let newUrl = new URL(window.location.href);
                    newUrl.searchParams.set( this.filterName, newValue );
                    window.location.href = encodeURI(newUrl);
                }else{
                    let newUrl = new URL(window.location.href);
                    newUrl.searchParams.delete(this.filterName);
                    window.location.href = encodeURI(newUrl);
                }

            },
        },

        buttonTitle(){
            let title = '';
            if(this.activeFilters && this.activeFilters.length){
                for(let i = 0; i < this.activeFilters.length; i++){
                    if(i !== 0){
                        title = title + ', ' + this.activeFilters[i].attributes.title;
                    }else{
                        title = this.activeFilters[i].attributes.title;
                    }

                }
            }else{
                title = this.defaultButtonTitle;
            }

            return title;
        },

        defaultButtonTitle(){
            return Lang.get('menu.select_season');
        }
    },

    methods: {

        activeFiltersFromUrl() {

            let filters = [];
            if (this.filters && this.filters.length) {
                for (let i = 0; i < this.filters.length; i++) {
                    if (this.filters[i].attributes.name !== '' && this.URLActiveFilter && this.URLActiveFilter.split('-').includes(this.filters[i].attributes.name)) {
                        filters.push(this.filters[i]);
                    }
                }
            }

            return filters;

        },

        fetchFilterItems(){
            axios.get(
                this.getFilterItemsRequestUrl(), { params: {
                        name: this.filterName,
                        locale: this.locale,
                    }}
            ).then((resp) => {
                if (resp.status === 200 || resp.status === 201){
                    this.filters = resp.data;
                    this.activeFilters = this.activeFiltersFromUrl();
                    this.$emit('data-loaded');
                }
            }).catch(

            ).finally(

            );
        },

        getFilterItemsRequestUrl(){
            return '/api/' + window.systemInfo.apiVersion + '/' + this.type + '/' + this.filterName +'/activeItems' ;
        },

        filterChanged(filter){
            // remove all selected filter when select something else
            if(filter.attributes.name === ''){
                // all filters clicked
                if(this.activeFilters.includes(filter)){
                    // if filter set as active
                    if(this.activeFilters.length > 1){
                        // clear all filters and add all filter
                        this.activeFilters = [];
                        this.activeFilters.push(filter);
                    }
                }else{

                }
            }else{
                // remove all filter if exists
                let allIndex = null;
                for(let i = 0; i < this.activeFilters.length; i++){
                    if(this.activeFilters[i].attributes.name === ''){
                        allIndex = i;
                        break;
                    }
                }
                if(allIndex !== null){
                    this.activeFilters.splice(allIndex, 1);
                }
            }
        },

        applyFilter(){
            let filter = '';
            if(this.activeFilters && this.activeFilters.length){
                for(let i = 0; i < this.activeFilters.length; i++){
                    if(i !== 0){
                        filter = filter + '-' + this.activeFilters[i].attributes.name;
                    }else{
                        filter = this.activeFilters[i].attributes.name;
                    }

                }
            }else{
                filter = this.defaultButtonTitle;
            }
            this.URLActiveFilter = filter;
        }
    }

}