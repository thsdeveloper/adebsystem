<template>
  <div>
      <v-img src="/img/icones/not-found.png" height="180px" contain></v-img>
      <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
          <p class="display-1">{{ $t('page_not_found') }}!</p>
      </v-flex>
      <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
          <p class="subheading">O URL solicitado não foi encontrado neste servidor. Isso é tudo que sabemos.</p>
      </v-flex>
      <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
          <v-btn rounded color="primary" :to="{ name: 'home' }" dark>{{ $t('go_home') }}</v-btn>
      </v-flex>
  </div>
</template>

<script>
export default {
    components: {
    },
  name: 'NotFound'
}
</script>
