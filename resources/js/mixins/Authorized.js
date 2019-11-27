export default {
    computed: {
        activeUser(){
            return window.activeUser !== undefined ? window.activeUser : null;
        }
    },
}