<template>
  <v-app id="back">
    <v-content>
      <v-container fluid>
        <v-row justify="center" align="center">
          <v-col md="4">
            <child animate-in="bounceInRight"></child>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>
<script>
    import LinksNavigationWelcomeApp from "../components/LinksNavigationWelcomeApp";

    export default {
        name: 'WelcomeApp',
        components: {LinksNavigationWelcomeApp}
    }
</script>
<style lang="scss">
  div#back {
    background: linear-gradient(-135deg, #8649d6c7 0%, #2791d2b8 100%), url('/img/fachada_adeb.jpg');
    background-size: cover;
  }
</style>
