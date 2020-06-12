export default {
    methods: {
        showNotification(title, message, type = 'success') {
            let notificationPosition = 'bottom-left';
            let offset = 0;

            this.$notify({
                title: title,
                message: message,
                type: type,
                position: notificationPosition,
                offset: offset,
            });
        },

        showNoConnectionNotification() {
            this.showNotification('', 'There was an error', 'error');
        },

        showDefaultError(){
            this.showNotification(Lang.get('editor.tab_main'), 'Произошла ошибка', 'error');
        },
    },

    computed: {
        Lang() {
            return window.Lang;
        },

    }
}