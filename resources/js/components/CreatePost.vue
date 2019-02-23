<template>
    <v-dialog v-model="dialog" width="600">
        <v-btn slot="activator" dark fab fixed bottom right color="primary"><v-icon>add</v-icon></v-btn>

        <v-card>
            <v-card-title class="headline grey lighten-2" primary-title>
                E aí, quais são as novidades?
            </v-card-title>

            <v-card-text>
                <v-text-field label="Escreva sua publicação!" v-model="form.text" :autofocus="true"></v-text-field>
                <upload-btn :fileChangedCallback="fileChanged" flat color="fff">
                    <template slot="icon">
                        <v-icon>camera_alt</v-icon>
                    </template>
                </upload-btn>

                <div v-if="this.form.urlImage">
                    <v-layout row wrap>
                        <v-flex xs3 d-flex>
                            <v-card flat tile class="d-flex">
                                <v-img :src="this.form.urlImage"
                                       lazy-src="form.urlImage"
                                       aspect-ratio="1"
                                       class="grey lighten-2">
                                    <v-layout slot="placeholder" fill-height align-center justify-center ma-0>
                                        <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                    </v-layout>
                                </v-img>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </div>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" flat @click="dialog = false">Cancelar</v-btn>
                <v-btn color="primary" @click="createPost()" :disabled="!form.text || !form.urlImage">Postar</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import UploadButton from 'vuetify-upload-button';

    export default {
        name: "CreatePost",
        components: {
            'upload-btn': UploadButton
        },
        data: () => ({
            dialog: false,
            form:{
                text: '',
                urlImage: '',
            },
        }),
        created(){
            this.listenForChanges();
        },
        methods: {
            fileChanged(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.form.urlImage = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            createPost(){
                this.$store.dispatch('post/createPost', this.form);
                this.newPost = '';
                this.dialog = false;
            },
            listenForChanges(){
                Echo.channel('posts').listen('PostPublished', post => {
                    console.log('Got event...');
                    console.log(post);

                    if(! ('Notification' in window)) {
                        alert('Web Notification is not supported');
                        return;
                    }
                    Notification.requestPermission(permission => {
                        let notification = new Notification('Novo post criado!', {
                            body: post.text.text, // content for the alert
                            icon: "https://pusher.com/static_logos/320x320.png" // optional image url
                        });
                        // link to page on clicking the notification
                        notification.onclick = () => {
                            window.open(window.location.href);
                        };
                    });
                })
            }
        },
    }
</script>

<style scoped>

</style>
