<template>
    <v-layout>
        <v-flex>
            <v-card>
                Detalhes do membro
            </v-card>
        </v-flex>
    </v-layout>

</template>

<script>
    export default {
        name: "DetalheDoMebro",
        methods: {
            fetchUser(){
                console.log(this.$route.params.userId);
                this.$store.dispatch('user/fetchUser', {userId: this.$route.params.userId})
            }
        },
        mounted(){
            this.fetchUser();
        },
        beforeMount () {
            // console.log('IdUser', this.$route.params.userId)
        }
    }
</script>

<style scoped>

</style>
