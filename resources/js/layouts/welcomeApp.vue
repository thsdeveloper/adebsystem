<template>
  <v-app id="back">
    <v-main>
      <v-container fluid class="fill-height">
        <v-row justify="center" align="center">
          <v-col md="10">
            <child animate-in="bounceInRight"></child>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
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
