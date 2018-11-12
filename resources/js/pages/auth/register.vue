<template>
    <v-card class="elevation-12">
        <v-form @submit.prevent="register" @keydown="form.onKeydown($event)">
            <v-toolbar dark color="primary">
                <v-toolbar-title>{{$t('register')}}</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>

                <v-flex>
                    <v-text-field v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" name="name" :label="$t('name')" type="text" autofocus></v-text-field>
                    <has-error :form="form" field="name"/>
                </v-flex>

                <v-flex>
                    <v-text-field v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" name="email" :label="$t('email')" type="email"></v-text-field>
                    <has-error :form="form" field="email"/>
                </v-flex>

                <v-flex>
                    <v-text-field v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" name="password" :label="$t('password')" type="password"></v-text-field>
                    <has-error :form="form" field="password"/>
                </v-flex>

                <v-flex>
                    <v-text-field v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" name="password_confirmation" :label="$t('password_confirmation')" type="password"></v-text-field>
                    <has-error :form="form" field="password_confirmation"/>
                </v-flex>


                <!-- GitHub Login Button -->
                <login-with-github/>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" flat :to="{ name: 'password.request' }">{{ $t('forgot_password') }}</v-btn>
                <v-btn color="primary" type="submit" :loading="form.busy">{{ $t('register') }}</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script>
    import Form from 'vform'
    import LoginWithGithub from '~/components/LoginWithGithub'

    export default {
        middleware: 'guest',
        layout: 'welcomeApp',

        components: {
            LoginWithGithub
        },

        metaInfo () {
            return { title: this.$t('register') }
        },

        data: () => ({
            form: new Form({
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            })
        }),

        methods: {
            async register () {
                // Register the user.
                const { data } = await this.form.post('/api/register')

                // Log in the user.
                const { data: { token } } = await this.form.post('/api/login')

                // Save the token.
                this.$store.dispatch('auth/saveToken', { token })

                // Update the user.
                await this.$store.dispatch('auth/updateUser', { user: data })

                // Redirect home.
                this.$router.push({ name: 'home' })
            }
        }
    }
</script>
