<template>

</template>

<script>
    import {mapGetters, mapActions, mapState} from 'vuex';
    export default {
        name: "IdeasListModeration",

        computed: {
            ...mapGetters('Idea', ['ideasNotModerated']),
        },

        methods: {
            ...mapActions('Idea', ['approveIdea, refuseIdea']),
        }
    }
</script>

<style scoped>

</style>
