<template>
    <v-layout>
        <v-flex>
            <v-card>
                Detalhes do membro
                {{member}}
            </v-card>
        </v-flex>
    </v-layout>

</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        name: "DetalheDoMebro",
        methods: {
            fetchUser(){
                // console.log(this.$route.params.userId);
                // this.$store.dispatch('member/fetchMember', this.$route.params.userId)
            }
        },
        mounted(){
            this.fetchUser();
        },
        computed: {
            ...mapGetters({
                member: 'member/memberDetail',
            }),
        },
        beforeMount () {
            // console.log('IdUser', this.$route.params.userId)
        }
    }
</script>

<style scoped>

</style>
