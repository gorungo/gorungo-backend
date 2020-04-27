export default {

    data(){
        return{
            type: 'filters',
            locale: 'ru',
            filters: null,
            activeFilters: null,
            filterName: null,
            loading: false,

            // нужно ли погружать фильтры
            needFetchFilters: true,
        }
    },

    mounted() {
        this.locale = Lang.locale;
        if(this.propFilters !== undefined && this.propFilters != null){
            this.filters = this.propFilters;
        }else{
            if(this.needFetchFilters)this.fetchFilterItems();
        }
    },

    watch:{
        activeFilters(val){
            if(val.length === 0 && this.filters.length){
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

            get: function () {
                let newUrl = new URL(decodeURI(window.location.href));
                return newUrl.searchParams.get(this.filterName);
            },

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
            return Lang.get('Select filter');
        }
    },

    methods: {

        activeFiltersFromUrl() {

            let filters = [];
            if (this.filters && this.filters.length) {
                for (let i = 0; i < this.filters.length; i++) {
                    if(typeof this.filters[i] === "object" && this.filters[i].attributes !== undefined){
                        if (this.filters[i].attributes.name !== '' && this.URLActiveFilter && this.URLActiveFilter.split('-').includes(this.filters[i].attributes.name)) {
                            filters.push(this.filters[i]);
                        }
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
            // remove all selected filters when select something else
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
                // remove filter if exists
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

        applyFilterHandler(){
            let filter = '';
            if(this.activeFilters && this.activeFilters.length){
                for(let i = 0; i < this.activeFilters.length; i++){
                    if(typeof this.activeFilters[i] === 'object'){
                        if(i !== 0){
                            filter = filter + '-' + this.activeFilters[i].attributes.name;
                        }else{
                            filter = this.activeFilters[i].attributes.name;
                        }
                    }else if(typeof this.activeFilters[i] === 'string'){
                        filter = this.activeFilters[i];
                    }
                }
            }
            this.URLActiveFilter = filter;
        },

        clearFilterHandler(){
            this.activeFilters = [];
            this.activeFilters.push(this.filters[0]);
            this.applyFilterHandler();
        }
    }

}