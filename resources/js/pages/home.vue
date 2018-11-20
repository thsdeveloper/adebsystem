<template>
    <v-layout>
        <v-flex>
            <v-textarea
                    append-icon="comment"
                    append-outer-icon="comment"
                    hint="Publique informações importantes para todos os membros"
                    name="input-7-1"
                    label="Escreva sua publicação!"
                    v-model="newPost"
                    auto-grow
                    autofocus
                    box
                    counter
                    height="100px">
            </v-textarea>
            <v-btn color="success" @click="createPost(newPost)">Publicar post</v-btn>

            <v-timeline>
                <transition-group tag="div" name="feed" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
                    <v-timeline-item v-for="(post, index) in posts" :key="post.id" color="primary" small>
                        <span slot="opposite">{{post.user.name}}</span>
                        <v-card class="elevation-1">
                            <v-card-title class="headline">
                                <v-avatar size="32px">
                                    <img :src="post.user.photo_url" :alt="post.user.name">
                                </v-avatar>
                            </v-card-title>
                            <v-card-text>
                                {{post.text}}
                            </v-card-text>
                            <v-card-actions>
                                <v-btn flat small color="primary">Curtir</v-btn>
                                <v-btn flat small color="primary">Comentar</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-timeline-item>
                </transition-group>
            </v-timeline>
        </v-flex>
    </v-layout>
</template>

<script>
    import { mapGetters } from 'vuex'
    export default {
        middleware: 'auth',
        metaInfo () {
            return { title: this.$t('home') }
        },
        data: () => ({
            newPost: '',
        }),
        computed:{
            ...mapGetters({posts: 'post/posts'}),
        },
        methods: {
            fetchPosts(){
                this.$store.dispatch('post/fetchPosts')
            },
            createPost(post){
                this.$store.dispatch('post/createPost', post);
                this.newPost = '';
            }
        },
        mounted(){
            this.fetchPosts()
        }
    }
</script>
