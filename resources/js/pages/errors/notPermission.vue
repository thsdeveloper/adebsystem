<template>
  <v-container>
    <v-row>
      <v-col>
        <v-alert border="left" color="red" dark>
          Desculpe! Vocẽ não não tem permissão de acesso nesta página.
        </v-alert>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  export default {
    name: 'NotPermission'
  }
</script>
