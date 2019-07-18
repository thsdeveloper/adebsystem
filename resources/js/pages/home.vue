<template>
    <div>
        <v-layout row wrap>
            <v-flex xs12 ms12 md6>
                <v-card color="blue-grey darken-2" class="white--text">
                    <v-card-title primary-title>
                        <div>
                            <div class="headline">Bem vindo ao AdebSystem 1.0</div>
                            <span>Os recursos deste sistema está em fase de implementação. Somente o módulo de cadastro de membro está em funcionamento</span>
                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout>
            <v-flex>
                <v-layout>
                    <post-time-line/>
                </v-layout>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>

    import PostTimeLine from "../components/PostTimeLine";
    export default {
        components: {PostTimeLine},
        middleware: 'auth',
        metaInfo () {
            return { title: this.$t('home') }
        },
        methods: {

        },
    }
</script>
<style scoped>

</style>
