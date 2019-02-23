<template>
    <div>
        <v-flex v-for="(post, index) in posts" :key="post.id" color="primary">
            <v-card class="elevation-1">
                <v-card-title class="title-card-posts">
                    <v-avatar size="32px">
                        <img :src="post.user.photo_url" :alt="post.user.name">
                    </v-avatar>
                    <div class="body-2">{{post.user.name}}</div>
                    s                                <v-btn flat icon color="grey lighten-1" absolute right>
                    <v-icon>more_vert</v-icon>
                </v-btn>
                </v-card-title>
                <v-card-text>
                    {{post.text}}
                </v-card-text>
                <v-img :src="'/storage/'+post.media[0].id+'/'+post.media[0].file_name" aspect-ratio="1.7"></v-img>
                <v-card-actions>
                    <!--<v-spacer></v-spacer>-->
                    <v-btn flat small color="primary">Curtir</v-btn>
                    <v-btn flat small color="primary">Comentar</v-btn>
                    <v-tooltip bottom>
                        <v-btn flat icon slot="activator" color="primary" ><v-icon small>share</v-icon></v-btn>
                        <span>Compartilhar essa publicação</span>
                    </v-tooltip>
                </v-card-actions>
            </v-card>
            <create-post/>
        </v-flex>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import CreatePost from "../components/CreatePost";
    import VButton from "./Button";

    export default {
        name: "PostTimeLine",
        components: {VButton, CreatePost},
        data(){
            return{

            }
        },
        computed:{
            ...mapGetters({posts: 'post/posts'}),
        },
        methods: {
            fetchPosts(){
                this.$store.dispatch('post/fetchPosts')
            },
        },
        mounted(){
            this.fetchPosts()
        },
    }
</script>

<style scoped>
    .v-card__title.title-card-posts .v-avatar {
        margin-right: 10px;
    }
</style>
