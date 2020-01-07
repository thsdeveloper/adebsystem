<template>
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
      <template v-for="item in menus">

        <v-row v-if="item.heading" :key="item.heading" align="center">
          <v-col cols="6">
            <v-subheader v-if="item.heading">{{ item.heading }}</v-subheader>
          </v-col>
          <v-col cols="6" class="text-center">
            <a href="#!" class="body-2 black--text">EDIT</a>
          </v-col>
        </v-row>

        <v-list-group
          v-else-if="item.children"
          :key="item.text"
          v-model="item.model"
          value="true"
          :prepend-icon="item.model ? item.icon : item['icon-alt']">
          <template v-slot:activator>
                <v-list-item-title>
                  {{ item.text }}
                </v-list-item-title>
          </template>
          <v-list-item
            v-for="(child, i) in item.children"
            :key="i"
            :to="child.route">
            <v-list-item-action v-if="child.icon">
              <v-icon>{{ child.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ child.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
        <v-list-item
          v-else
          :key="item.text"
          :to="item.route"
        >
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>
              {{ item.text }}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </template>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    name: 'NavigationDrawer',
    middleware: 'auth',
    data: () => ({
      items: [
        { icon: 'contacts', text: 'Contacts' },
        { icon: 'history', text: 'Frequently contacted' },
        { icon: 'content_copy', text: 'Duplicates' },
        {
          icon: 'keyboard_arrow_up',
          'icon-alt': 'keyboard_arrow_down',
          text: 'Labels',
          model: true,
          children: [
            { icon: 'add', text: 'Create label' },
          ],
        },
        {
          icon: 'keyboard_arrow_up',
          'icon-alt': 'keyboard_arrow_down',
          text: 'More',
          model: false,
          children: [
            { text: 'Import' },
            { text: 'Export' },
            { text: 'Print' },
            { text: 'Undo changes' },
            { text: 'Other contacts' },
          ],
        },
        { icon: 'settings', text: 'Settings' },
        { icon: 'chat_bubble', text: 'Send feedback' },
        { icon: 'help', text: 'Help' },
        { icon: 'phonelink', text: 'App downloads' },
        { icon: 'keyboard', text: 'Go to the old version' },
      ],
    }),
    computed: {
      ...mapGetters({ user: 'auth/user' }),
      menus () {
        return [
          { icon: 'dashboard', text: this.$t('dashboard'), route: '/home' },
          { icon: 'people', text: this.$t('members'), route: '/members' },
          { icon: 'location_city', text: 'Setores / Igrejas', route: '/setoresIgrejas'},
          { icon: 'assignment_ind', text: 'Secretaria', route: '/secretaria' },
          { icon: 'date_range', text: this.$t('general_agenda'), route: '/calendar' },
          {
            icon: 'keyboard_arrow_down',
            'icon-alt': 'group_work',
            text: this.$t('departments'),
            model: false,
            children: [
              { icon: 'keyboard_arrow_right', text: 'Escola Bíblica Dominical', route: '/departments/ebd' },
              {
                icon: 'keyboard_arrow_right',
                text: 'Evangelísmo / Missões',
                route: '/departments/missions'
              },
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
              { icon: 'lock', text: 'Acesso a conta', route: '/settings/acessos' },
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

  .lightbox {
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
