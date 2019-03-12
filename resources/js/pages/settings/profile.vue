<template>
    <div>

        <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
<!--            <v-avatar :size="96" color="grey lighten-4">-->
<!--                <img :src="user.photo_url" :alt="user.name">-->
<!--                &lt;!&ndash;<img src="https://vuetifyjs.com/apple-touch-icon-180x180.png" alt="avatar">&ndash;&gt;-->
<!--            </v-avatar>-->
            <avatar-upload-crop/>
        </v-flex>
        <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
            <p class="display-1">{{$t('hello')}}, {{form.name}}</p>
        </v-flex>
        <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
            <p class="subheading">Gerencie suas informações, privacidade e segurança para que o AdebSystem atenda suas necessidades</p>
        </v-flex>
        <v-layout row wrap>
        <v-flex xs12 sm12 md6 d-flex child-flex>
            <v-card>
                <v-layout row>
                    <v-flex xs7>
                        <v-card-title primary-title>
                            <div>
                                <div class="headline">Revise suas configurações de privacidade</div>
                                <div>Faça o Check-up de privacidade, um guia passo a passo que ajuda você a escolher suas configurações de privacidade</div>
                            </div>
                        </v-card-title>
                    </v-flex>
                    <v-flex align-self-center>
                        <v-img src="https://www.gstatic.com/identity/boq/accountsettingsmobile/privacycheckup_initial_192x192_dbd02aee16e8b81162402f71f0960a84.png" height="125px" contain></v-img>
                    </v-flex>
                </v-layout>
                <v-divider light></v-divider>
                <v-card-actions class="pa-3">
                    <v-dialog v-model="dialogUpdateInfo" persistent max-width="600px">
                        <v-btn slot="activator" flat>{{ $t('update') }}</v-btn>
                        <v-card>
                            <form @submit.prevent="update" @keydown="form.onKeydown($event)">
                                <v-card-title>
                                    <span class="headline">Informações pessoais</span>
                                    <p class="subheading">Informações básicas, como seu nome e foto, usadas nos serviços do AdebSystem</p>
                                </v-card-title>
                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-layout wrap>
                                            <alert-success :form="form" :message="$t('info_updated')"/>
                                            <v-flex xs12 sm12 md12>
                                                <v-text-field :label="$t('name')" required v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" name="name"></v-text-field>
                                                <has-error :form="form" field="name"/>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12>
                                                <v-text-field :label="$t('email')" required v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" name="email"></v-text-field>
                                                <has-error :form="form" field="name"/>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                    <small>*Só você pode ver suas configurações. O AdebSystem tem o compromisso de proteger sua privacidade e segurança. </small>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" flat @click="dialogUpdateInfo = false">{{ $t('close') }}</v-btn>
                                    <v-btn color="blue darken-1" flat type="submit">{{ $t('update') }}</v-btn>
                                </v-card-actions>
                            </form>
                        </v-card>
                    </v-dialog>
                </v-card-actions>
            </v-card>
        </v-flex>
        <v-flex xs12 sm12 md6 d-flex child-flex>
            <v-card>
                <v-layout row>
                    <v-flex xs7>
                        <v-card-title primary-title>
                            <div>
                                <div class="headline">Mantemos sua conta protegida</div>
                                <div>A Verificação de segurança fornece recomendações personalizadas para proteger sua conta</div>
                            </div>
                        </v-card-title>
                    </v-flex>
                    <v-flex align-self-center>
                        <v-img src="https://www.gstatic.com/identity/boq/accountsettingsmobile/securitycheckup_green_192x192_e145b25a9fc9355958e01c3b1357b7c2.png" height="125px" contain></v-img>
                    </v-flex>
                </v-layout>
                <v-card-actions class="pa-3">
                    <v-btn slot="activator" flat to="/settings/password">{{ $t('change_password') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
        </v-layout>
    </div>
</template>

<script>
    import Form from 'vform'
    import { mapGetters } from 'vuex'
    import { VclFacebook, VclInstagram, VueContentLoading } from 'vue-content-loading';
    import AvatarUploadCrop from "../../components/AvatarUploadCrop";

    export default {
        components: {
            AvatarUploadCrop,
            VueContentLoading
        },
        scrollToTop: false,

        metaInfo () {
            return { title: this.$t('settings') }
        },

        data: () => ({
            form: new Form({
                name: '',
                email: ''
            }),

            dialogUpdateInfo: false,
        }),

        computed:{
            ...mapGetters({user: 'auth/user'})
        },

        created () {
            // Fill the form with user data.
            this.form.keys().forEach(key => {
                this.form[key] = this.user[key]
            })
        },
        mounted () {

        },

        methods: {
            async update () {
                const { data } = await this.form.patch('/api/settings/profile');

                this.$store.dispatch('auth/updateUser', { user: data })
            }
        }
    }
</script>
