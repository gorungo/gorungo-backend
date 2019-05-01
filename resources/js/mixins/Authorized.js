export default {

    props: ['activeUser'],

    data(){
        return{
            user: null,
        }
    },

    mounted: function () {
        this.user = this.activeUser;
    },

}