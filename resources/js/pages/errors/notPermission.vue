<template>
  <v-container>
    <v-row>
      <v-col>
        <img src="https://www.gstatic.com/identity/boq/accountsettingsmobile/signin_scene_316x112_9ab8cadd6080f72111aead1bedd3a9fd.png"/>
      </v-col>
    </v-row>
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
