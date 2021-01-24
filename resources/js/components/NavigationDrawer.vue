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

    }),
    computed: {
      ...mapGetters({ user: 'auth/user' }),
      menus () {
        return [
          { icon: 'dashboard', text: this.$t('dashboard'), route: '/home' },
          { icon: 'people', text: this.$t('members'), route: '/members' },
          { icon: 'location_city', text: 'Setores / Igrejas', route: '/setoresIgrejas'},
          {
            icon: 'assignment_ind', 'icon-alt': 'assignment_ind', text: 'Secretaria', route: '/secretaria', model: false,
            children: [
              { icon: 'supervisor_account', text: 'Controle de Visitantes', route: '/secretaria/visitantes' },
              { icon: 'drafts', text: 'Cartas de Recomendação', route: '/secretaria/cartaRecomendacao' },
            ]
          },
          { icon: 'monetization_on', text: 'Financeiro', route: '/financeiro' },
          { icon: 'date_range', text: this.$t('general_agenda'), route: '/calendar' },
          {
            icon: 'keyboard_arrow_down', 'icon-alt': 'settings', text: 'Configurações', model: false,
            children: [
              { icon: 'person', text: 'Minha conta', route: '/settings/profile' },
              { icon: 'lock', text: 'Acesso a conta', route: '/settings/acessos' },
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
