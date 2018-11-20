<template>
    <v-toolbar :clipped-left="$vuetify.breakpoint.lgAndUp" color="blue accent-4" dark app fixed>
        <v-toolbar-title style="width: 300px">
            <v-toolbar-side-icon @click.native.stop="toggleDrawer"></v-toolbar-side-icon>
            <span class="hidden-sm-and-down">AdebSystem</span>
        </v-toolbar-title>
        <v-text-field flat solo-inverted hide-details prepend-inner-icon="search" :label="$t('what_are_you_looking_for')" class="hidden-sm-and-down" />
        <v-spacer />
        <locale-dropdown/>
        <v-btn icon @click="ativarSnackbar">
            <v-icon>apps</v-icon>
        </v-btn>
        <v-btn icon @click="ativarSnackbar">
            <v-icon>notifications</v-icon>
        </v-btn>
        <v-menu offset-y left>
            <v-btn icon large slot="activator">
                <v-avatar size="32px">
                    <img :src="user.photo_url" :alt="user.name">
                </v-avatar>
            </v-btn>
            <v-list dense>
                <v-list-tile to="/settings">
                    <v-list-tile-action>
                        <v-icon>settings</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>
                            {{$t('settings')}}
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile @click.prevent="logout">
                    <v-list-tile-action>
                        <v-icon>exit_to_app</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>
                           {{$t('logout')}}
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-menu>
        <v-snackbar v-model="snackbar" color="success" bottom>
            Aguarde! Estamos providenciando isso!
            <v-btn dark flat @click="snackbar = false">
                Fechar
            </v-btn>
        </v-snackbar>
    </v-toolbar>
</template>

<script>
    import { mapGetters, mapMutations } from 'vuex'
    import LocaleDropdown from './LocaleDropdown'

    export default {
        components: {
            LocaleDropdown
        },

        data: () => ({
            appName: window.config.appName,
            snackbar: false,
        }),

        computed: {
            ...mapGetters({user: 'auth/user'})
        },

        methods: {
            async toggleDrawer(){
                await this.$store.dispatch('auth/toggleDrawer');
            },
            async logout () {
                // Log out the user.
                await this.$store.dispatch('auth/logout');

                // Redirect to login.
                this.$router.push({ name: 'login' })
            },
            ativarSnackbar(){
                this.snackbar = true;
            },
        }
    }
</script>

<style scoped>
    .profile-photo {
        width: 2rem;
        height: 2rem;
        margin: -.375rem 0;
    }
</style>
