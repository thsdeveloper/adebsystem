<template>
    <div>
        <v-navigation-drawer :clipped="$vuetify.breakpoint.lgAndUp" v-model="$store.state.auth.drawer" fixed app>
            <v-img :aspect-ratio="16/9" src="/img/fachada_adeb.jpg" class="imagem-cover">
                <v-layout pa-2 column fill-height class="lightbox white--text">
                    <v-spacer></v-spacer>
                    <v-flex shrink>
                        <v-avatar size="40px" class="avatar-img">
                            <img :src="user.photo_url" :alt="user.name">
                        </v-avatar>
                        <div class="subheading">{{user.name}}</div>
                        <div class="body-1">{{user.email}}</div>
                    </v-flex>
                </v-layout>
                <div class="fill-height repeating-gradient"></div>
            </v-img>
            <v-list dense>
                <!--{{tabs}}-->
                <template v-for="item in menus">
                    <v-layout v-if="item.heading" :key="item.heading" row align-center>
                        <v-flex xs6>
                            <v-subheader v-if="item.heading">
                                {{ item.heading }}
                            </v-subheader>
                        </v-flex>
                        <v-flex xs6 class="text-xs-center">
                            <a href="#!" class="body-2 black--text">EDIT</a>
                        </v-flex>
                    </v-layout>
                    <v-list-group v-else-if="item.children" v-model="item.model" :key="item.text"
                                  :prepend-icon="item.model ? item.icon : item['icon-alt']" append-icon="">
                        <v-list-tile slot="activator">
                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ item.text }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                        <v-list-tile v-for="(child, i) in item.children" :key="i" :to="child.route">
                            <v-list-tile-action v-if="child.icon">
                                <v-icon>{{ child.icon }}</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ child.text }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list-group>
                    <v-list-tile v-else :key="item.text" :to="item.route">
                        <v-list-tile-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                {{ item.text }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </template>
            </v-list>
        </v-navigation-drawer>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        name: "NavigationDrawer",
        middleware: 'auth',
        data: () => ({

        }),
        computed: {
            ...mapGetters({user: 'auth/user'}),
            menus () {
                return [
                    { icon: 'dashboard', text: this.$t('dashboard'), route: '/home' },
                    { icon: 'people', text: this.$t('members'), route: '/members' },
                    { icon: 'assignment_ind', text: 'Secretaria', route: '/secretaria/visitantes' },
                    { icon: 'date_range', text: this.$t('general_agenda'), route: '/calendar' },
                    {
                        icon: 'keyboard_arrow_down', 'icon-alt': 'group_work', text: this.$t('departments'), model: false,
                        children: [
                            { icon: 'keyboard_arrow_right', text: 'Escola Bíblica Dominical', route: '/departments/ebd' },
                            { icon: 'keyboard_arrow_right', text: 'Evangelísmo / Missões', route: '/departments/missions' },
                            { icon: 'keyboard_arrow_right', text: 'Ministério de Louvor', route: '/departments/louvor' },
                            { icon: 'keyboard_arrow_right', text: 'Família / Casais', route: '/departments/familia' },
                            { icon: 'keyboard_arrow_right', text: 'UCADEB', route: '/departments/' },
                            { icon: 'keyboard_arrow_right', text: 'UNAADEB', route: '/departments/' },
                            { icon: 'keyboard_arrow_right', text: 'UMADEB', route: '/departments/' },
                            { icon: 'keyboard_arrow_right', text: 'UFADEB', route: '/departments/' },
                            { icon: 'keyboard_arrow_right', text: 'UDVADEB', route: '/departments/' },
                        ]
                    },
                    {
                        icon: 'keyboard_arrow_down', 'icon-alt': 'monetization_on', text: 'Financeiro', model: false,
                        children: [
                            { icon: 'poll', text: 'Resumo', route: '/finances' },
                            { icon: 'trending_up', text: 'Receitas', route: '/finances/income' },
                            { icon: 'trending_down', text: 'Despesas', route: '/finances/outlays' },
                            { icon: 'insert_drive_file', text: 'Relatórios', route: '/finances/reports' },
                        ]
                    },
                    {
                        icon: 'keyboard_arrow_down', 'icon-alt': 'settings', text: 'Configurações', model: false,
                        children: [
                            { icon: 'person', text: 'Minha conta', route: '/settings/profile' },
                            { icon: 'location_city', text: 'Igreja', route: '/settings/igreja-sede' },
                            { icon: 'credit_card', text: 'Faturas / Cobranças', route: '/settings/invoice' },
                            { icon: 'verified_user', text: 'Segurança da conta', route: '/settings/password' },
                        ]
                    },
                    { icon: 'help', text: 'Central de ajuda', route: '/settings/help' },
                ]
            }
        }
    }
</script>

<style scoped>
    .v-navigation-drawer {
        transition: none !important;
    }
    .lightbox{
        -webkit-box-shadow: 0 0 20px inset rgba(0, 0, 0, 0.2);
        box-shadow: 0 0 20px inset rgba(0, 0, 0, 0.24);
        background-image: linear-gradient(to top, rgb(0, 0, 0) 0%, transparent 112px);
    }
    .v-avatar.avatar-img {
        float: left;
        margin-right: 12px;
        margin-top: 3px;
    }
</style>
