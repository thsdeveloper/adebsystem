<template>
    <div>
        <v-card class="elevation-12">
            <v-form @submit.prevent="login" @keydown="form.onKeydown($event)">
                <v-toolbar dark color="primary">
                    <v-toolbar-title>AdebSystem 1.0</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>

                    <v-flex>
                        <v-text-field v-model="form.login"
                                      :class="{ 'is-invalid': form.errors.has('login') }"
                                      name="login"
                                      :label="$t('Email ou CPF')"
                                      type="text"
                                      autofocus>
                        </v-text-field>
                        <has-error :form="form" field="email"/>
                    </v-flex>

                    <v-flex>
                        <v-text-field
                                v-model="form.password"
                                :class="{ 'is-invalid': form.errors.has('password') }"
                                name="password"
                                :label="$t('password')"
                                type="password">
                        </v-text-field>
                        <has-error :form="form" field="password"/>
                    </v-flex>

                    <!-- Remember Me -->
                    <v-switch v-model="remember" name="remember" label="Lembrar dados de acesso"
                              messages="Marque este opção para lembrar os dados de acesso.">
                    </v-switch>

                    <!-- GitHub Login Button -->
                    <login-with-github/>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text :to="{ name: 'password.request' }">{{ $t('forgot_password') }}</v-btn>
                    <v-btn color="primary" type="submit" :loading="form.busy">{{ $t('login') }}</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </div>
</template>

<script>
    import Form from 'vform'
    import LoginWithGithub from '~/components/LoginWithGithub'

    export default {
        layout: 'welcomeApp',
        middleware: 'guest',

        components: {
            LoginWithGithub
        },

        // metaInfo () {
        //     return { title: this.$t('login') }
        // },

        data: () => ({
            form: new Form({
                login: '',
                password: ''
            }),
            remember: false
        }),

        methods: {
            async login () {
                // Submit the form.
                const { data } = await this.form.post('/api/login');

                // Save the token.
                this.$store.dispatch('auth/saveToken', {
                    token: data.token,
                    remember: this.remember
                });

                // Fetch the user.
                await this.$store.dispatch('auth/fetchUser');

                // Busca as permissões do usuario logado
                await this.$store.dispatch('auth/permissions');

                // Redirect home.
                this.$router.push({ name: 'home' })
            }
        },
    }
</script>
