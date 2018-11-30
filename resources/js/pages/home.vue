<template>
    <div>
        <v-layout>
            <v-flex md6>
                <v-layout wrap>
                    <v-flex v-for="(post, index) in posts" :key="post.id" color="primary" small xs12 sm12 md12>
                        <v-card class="elevation-1">
                            <v-card-title class="title-card-posts">
                                <v-avatar size="32px">
                                    <img :src="post.user.photo_url" :alt="post.user.name">
                                </v-avatar>
                                <div class="subheading">{{post.user.name}}</div>
                            </v-card-title>
                            <v-card-text>
                                {{post.text}}
                            </v-card-text>
                            <v-img :src="'/storage/'+post.media[0].id+'/'+post.media[0].file_name" aspect-ratio="1.7"></v-img>
                            <v-card-actions>
                                <v-btn flat small color="primary">Curtir</v-btn>
                                <v-btn flat small color="primary">Comentar</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <create-post/>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import CreatePost from "../components/CreatePost";
    export default {
        components: {CreatePost},
        middleware: 'auth',
        metaInfo () {
            return { title: this.$t('home') }
        },
        computed:{
            ...mapGetters({posts: 'post/posts'}),
        },
        methods: {
            fetchPosts(){
                this.$store.dispatch('toolbar/tabsVisible', {tabsVisible: false});
                this.$store.dispatch('post/fetchPosts')
            },
        },
        mounted(){
            this.fetchPosts()
        },
        created: function () {

        }

    }
</script>
<style scoped>
    .v-card__title.title-card-posts .v-avatar {
        margin-right: 10px;
    }
</style>
