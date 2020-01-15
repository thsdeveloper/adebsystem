<template>
  <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" color="blue accent-4" dark app fixed>
    <v-toolbar-title style="width: 300px">
      <v-app-bar-nav-icon @click.native.stop="toggleDrawer"></v-app-bar-nav-icon>
      <span class="hidden-sm-and-down">AdebSystem</span>
    </v-toolbar-title>
    <v-text-field flat solo-inverted hide-details prepend-inner-icon="search" :label="$t('what_are_you_looking_for')"
                  class="hidden-sm-and-down"/>
<!--    <ais-instant-search-->
<!--      :search-client="searchClient"-->
<!--      index-name="demo_ecommerce"-->
<!--    >-->
<!--    </ais-instant-search>-->
    <v-spacer/>
    <v-btn icon>
      <v-icon>apps</v-icon>
    </v-btn>
    <notification/>
    <v-menu offset-y left>
      <template v-slot:activator="{ on }">
        <v-btn icon large v-on="on">
          <v-avatar size="32px">
            <img :src="user.photo_url" :alt="user.name">
          </v-avatar>
        </v-btn>
      </template>
      <v-list dense>
        <v-list-item to="/settings">
          <v-list-item-title>Minha conta</v-list-item-title>
        </v-list-item>
        <v-list-item @click.prevent="logout">
          <v-list-item-title>Sair</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-app-bar>
</template>

<script>
  import { mapGetters } from 'vuex'
  import Notification from './Notification'

  export default {
    components: {
      Notification,
    },

        data: () => ({
            tabs: false,
            appName: window.config.appName,
        }),

    computed: {
      ...mapGetters({
        user: 'auth/user',
        menusTabs: 'toolbar/menusTabs'
      }),
    },
    methods: {
      async toggleDrawer () {
        await this.$store.dispatch('auth/toggleDrawer')
      },
      async logout () {
        // Log out the user.
        await this.$store.dispatch('auth/logout')

        // Redirect to login.
        this.$router.push({ name: 'login' })
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
