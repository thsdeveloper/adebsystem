<template>
  <v-container>
    <v-row>
      <v-col cols="4">
        Carta de recomendaçao
        <v-btn depressed small color="primary" href="/api/carta-recomendacao/1">Download da carta</v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
  export default {
    middleware: ['auth', 'permission'],
    data () {
      return {
      }
    },
  }
</script>
<style scoped>

</style>
