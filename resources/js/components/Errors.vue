<template>
    <div v-if="errors" class="form-group text-left">
        <div class="alert alert-danger">
            <ul>
                <li v-for="error in errors">{{error[0]}}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Errors",
        props: ['errors'],

        model: {
            prop: 'errors',
            event: 'update',
        }
    }
</script>
