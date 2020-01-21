<template>
    <v-container>
        <v-row>
            <v-col cols="4">
                <v-card class="mx-auto" dark color="#26c6da" shaped hover :to="{ name: 'secretaria.visitantes'}">
                    <v-card-title>
                        <v-icon large left>mdi-bank</v-icon>
                        R$ 325.88 / Saldo Atual
                    </v-card-title>
                    <v-card-subtitle>Tenha o controle geral dos visitantes com relatórios sempre atualizados.
                    </v-card-subtitle>
                </v-card>
            </v-col>
            <v-col cols="4">
                <v-card class="mx-auto" dark color="#4caf50" shaped hover :to="{ name: 'secretaria.cartaRecomendacao'}">
                    <v-card-title>
                        <v-icon large left>mdi-trending-up</v-icon>
                        R$ 8.947,55 / Receita
                    </v-card-title>
                    <v-card-subtitle>Emissão de cartas, controle e relatórios com notificações e assinaturas.
                    </v-card-subtitle>
                </v-card>
            </v-col>
            <v-col cols="4">
                <v-card class="mx-auto" dark color="#f44336" shaped hover :to="{ name: 'members.all'}">
                    <v-card-title>
                        <v-icon large left>mdi-trending-down</v-icon>
                        R$ 18.947,55 / Despesas
                    </v-card-title>
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
