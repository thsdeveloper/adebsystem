<template>
    <v-snackbar
            top
            v-model="snackbar.visible"
            :timeout="snackbar.timeout"
            :multi-line="snackbar.multiline === true">

        {{ snackbar.text }}

        <v-btn flat dark @click="closeSnackbar">Fechar</v-btn>

    </v-snackbar>
</template>

<script>
    export default {
        computed: {
            snackbar() {
                return this.$store.state.snackbar
            }
        },
        methods: {
         closeSnackbar(){
             this.$store.dispatch('snackbar/closeSnackbar');
         },
        }
    }
</script>

<style scoped>

</style>
