export default {

    data(){
        return{

        }
    },

    mounted() {
        this.locale = Lang.locale;
    },

    computed: {
        Lang() {
            return window.Lang;
        },

    }

}