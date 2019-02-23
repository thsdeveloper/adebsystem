<template>
    <div>
        <v-layout row wrap>
            <v-flex xs12 ms12 md6>
                <v-card color="blue-grey darken-2" class="white--text">
                    <v-card-title primary-title>
                        <div>
                            <div class="headline">5 Membros cadastrados</div>
                            <span>Listen to your favorite artists and albums whenever and wherever, online and offline.</span>
                        </div>
                    </v-card-title>
                    <v-card-actions>
                        <v-btn flat dark>Ver membros</v-btn>
                    </v-card-actions>
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
