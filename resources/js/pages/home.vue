<template>
    <div>
        <v-layout row wrap>
            <v-flex xs12>
                <v-textarea
                        append-icon="camera_alt"
                        hint="Publique informações importantes para todos os membros"
                        name="input-7-1"
                        label="Escreva sua publicação!"
                        v-model="newPost"

                        autofocus
                        box
                        @click:appends="clickIcon"
                        counter>
                </v-textarea>
                <v-btn color="success" @click="createPost(newPost)">Publicar post</v-btn>
            </v-flex>
        </v-layout>
        <v-layout>
            <v-flex>
                <v-layout wrap>
                    <v-flex v-for="(post, index) in posts" :key="post.id" color="primary" small xs6>
                        <v-card class="elevation-1">
                            <v-card-title class="">
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
    </div>
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
            clickIcon(){
                alert('Clicou aqui!')
            },
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
