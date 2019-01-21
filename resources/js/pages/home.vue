<template>
    <div>
        <v-layout>
            <v-flex md6>
                <v-layout wrap>
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
            fetchPosts(){
                this.$store.dispatch('toolbar/tabsVisible', {tabsVisible: false});
            },
        },
    }
</script>
<style scoped>

</style>
