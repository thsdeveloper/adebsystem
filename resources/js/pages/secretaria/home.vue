<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card class="mx-auto"  shaped hover :to="{ name: 'secretaria.visitantes'}">
          <v-card-title>Controle de Visitas</v-card-title>
          <v-card-subtitle>Tenha o controle geral dos visitantes com relatórios sempre atualizados.</v-card-subtitle>
        </v-card>
      </v-col>
      <v-col cols="12">
        <v-card class="mx-auto"  shaped hover :to="{ name: 'secretaria.cartaRecomendacao'}">
          <v-card-title>Carta de Recomendação</v-card-title>
          <v-card-subtitle>Emissão de cartas, controle e relatórios com notificações e assinaturas.</v-card-subtitle>
        </v-card>
      </v-col>
      <v-col cols="12">
        <v-card class="mx-auto" shaped hover :to="{ name: 'members.all'}">
          <v-card-title>Gerenciamento de Membros</v-card-title>
          <v-card-subtitle>Visualize, cadastre e gere relatorios completos sobre os membros.</v-card-subtitle>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
  export default {
    middleware: ['auth', 'permission'],
  }
</script>
<style scoped>

</style>
