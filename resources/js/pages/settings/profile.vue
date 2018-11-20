<template>
    <div>
        <v-card>
            <v-img class="white--text" height="100px" src="https://cdn.vuetifyjs.com/images/cards/docks.jpg">
                <v-container fill-height fluid>
                    <v-layout fill-height>
                        <v-flex xs12 align-end flexbox>
                            <span class="headline">Olá, {{form.name}}</span>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-img>
            <v-card-title>
                <div>
                    <vcl-facebook :width="600"></vcl-facebook>
                    <card :title="$t('your_info')">
                        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
                            <alert-success :form="form" :message="$t('info_updated')"/>

                                <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
                                    <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
                                    <has-error :form="form" field="name"/>
                                <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
                                    <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
                                    <has-error :form="form" field="email" />

                            <!-- Submit Button -->
                                    <v-button :loading="form.busy" type="success">{{ $t('update') }}</v-button>
                        </form>
                    </card>
                </div>
            </v-card-title>
            <v-card-actions>
                <v-btn flat color="orange">Share</v-btn>
                <v-btn flat color="orange">Explore</v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
    import Form from 'vform'
    import { mapGetters } from 'vuex'
    import { VclFacebook, VclInstagram, VueContentLoading } from 'vue-content-loading';

    export default {
        components: {
            VclFacebook,
            VclInstagram,
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
            })
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
