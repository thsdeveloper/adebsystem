<template>
<div>
    <v-navigation-drawer :clipped="$vuetify.breakpoint.lgAndUp" v-model="drawer" fixed app>
        <v-list dense>
            <template v-for="item in items">
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
    export default {
        name: "NavigationDrawer",
        data: () => ({
            drawer: true,
            items: [
                { icon: 'dashboard', text: 'Dashboard', route: '/home' },
                { icon: 'people', text: 'Membros', route: '/members' },
                {
                    icon: 'keyboard_arrow_down', 'icon-alt': 'group_work', text: 'Departamentos', model: false,
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
                        { icon: 'person', text: 'Usuário', route: '/settings/profile' },
                        { icon: 'location_city', text: 'Igreja', route: '/settings/church' },
                        { icon: 'credit_card', text: 'Faturas / Cobranças', route: '/settings/invoice' },
                        { icon: 'contact_support', text: 'Central de ajuda', route: '/settings/help' },
                        { icon: 'verified_user', text: 'Segurança da conta', route: '/settings/password' },
                    ]
                },
            ]
        }),
    }
</script>

<style scoped>

</style>
