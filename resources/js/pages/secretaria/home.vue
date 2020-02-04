<template>
  <v-container>
    <v-row>
      <v-col cols="4">
        <v-card class="mx-auto"  shaped hover :to="{ name: 'secretaria.visitantes'}">
          <v-card-title>Controle de Visitas</v-card-title>
          <v-card-subtitle>Tenha o controle geral dos visitantes com relatórios sempre atualizados.</v-card-subtitle>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card class="mx-auto"  shaped hover :to="{ name: 'secretaria.cartaRecomendacao'}">
          <v-card-title>Carta de Recomendação</v-card-title>
          <v-card-subtitle>Emissão de cartas, controle e relatórios com notificações e assinaturas.</v-card-subtitle>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card class="mx-auto" shaped hover :to="{ name: 'members.all'}">
          <v-card-title>Gerenciamento de Membros</v-card-title>
          <v-card-subtitle>Visualize, cadastre e gere relatorios completos sobre os membros.</v-card-subtitle>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-card class="mx-auto">
          <v-img
                  class="white--text align-end"
                  height="200px"
                  src="https://www.totvs.com/wp-content/uploads/2018/06/totvs-secretaria-digital.jpg"
          >
            <v-card-title>Top 10 Australian beaches</v-card-title>
          </v-img>

          <v-card-subtitle class="pb-0">Number 10</v-card-subtitle>

          <v-card-text class="text--primary">
            <div>Whitehaven Beach</div>

            <div>Whitsunday Island, Whitsunday Islands</div>
          </v-card-text>

          <v-card-actions>
            <v-btn
                    color="orange"
                    text
            >
              Share
            </v-btn>

            <v-btn
                    color="orange"
                    text
            >
              Explore
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col>
        ljikhjhk
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
