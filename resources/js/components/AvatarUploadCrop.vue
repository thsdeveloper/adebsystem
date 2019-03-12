<template>
    <div>
        <v-flex xs12 class="text-xs-center text-sm-center text-md-center text-lg-center">
            <v-avatar :size="96" color="grey lighten-4" @click="myCroppa.chooseFile()">
                <img :src="user.photo_url" :alt="user.name">
            </v-avatar>
        </v-flex>
        <v-dialog v-model="dialog" max-width="290">
            <v-card>
                <v-card-title class="headline">Atualizar imagem</v-card-title>

                <v-card-text>
                    <croppa disable-click-to-choose :width="250" :height="250" v-model="myCroppa"
                            :prevent-white-space="true"
                            @file-choose="escolheu"></croppa>
                    <div class="size">Output size: {{dataUrl}}</div>
                    <img :src="dataUrl">
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn color="green darken-1" flat="flat" @click="dialog = false">
                        Cancelar
                    </v-btn>
                    <v-btn color="green darken-1" flat="flat" @click="salvarImagem">
                        Atualizar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import 'vue-croppa/dist/vue-croppa.css';
    import Croppa from 'vue-croppa';
    import { mapGetters } from 'vuex';
    export default {
        name: "AvatarUploadCrop",
        components: {
            croppa: Croppa.component
        },
        data: () => ({
            myCroppa: {},
            dialog: false,
            dataUrl: null,
        }),
        methods: {
            escolheu(file){
                this.dialog = true;
            },
            salvarImagem(){
                this.dataUrl = this.myCroppa.generateDataUrl('image/jpeg', 0.8);
                if(this.dataUrl !== null){
                    this.$store.dispatch('member/fetchCities', this.dataUrl);
                }
            }

        },
        computed:{
            ...mapGetters({user: 'auth/user'})
        },
    }
</script>

<style scoped>

</style>
