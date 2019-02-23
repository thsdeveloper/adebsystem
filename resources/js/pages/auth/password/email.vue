<template>
    <v-card class="elevation-12">
        <v-form @submit.prevent="send" @keydown="form.onKeydown($event)">
            <v-toolbar dark color="primary">
                <v-toolbar-title>{{$t('reset_password')}}</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>
                <alert-success :form="form" :message="status"/>

                <v-flex>
                    <v-text-field v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" name="email" :label="$t('email')" type="email"></v-text-field>
                    <has-error :form="form" field="email"/>
                </v-flex>

                <!-- GitHub Login Button -->
                <login-with-github/>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <!--<v-btn color="primary" flat :to="{ name: 'password.request' }">{{ $t('forgot_password') }}</v-btn>-->
                <v-btn color="primary" type="submit" :loading="form.busy">{{ $t('send_password_reset_link') }}</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script>
    import Form from 'vform'

    export default {
        middleware: 'guest',
        layout: 'welcomeApp',

        metaInfo () {
            return { title: this.$t('reset_password') }
        },

        data: () => ({
            status: '',
            form: new Form({
                email: ''
            })
        }),

        methods: {
            async send () {
                const { data } = await this.form.post('/api/password/email')

                this.status = data.status

                this.form.reset()
            }
        }
    }
</script>
