<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-alert color="blue" type="success">Aguarde! Estamos trabalhando para oferecer recursos incríveis...</v-alert>
      </v-col>
    </v-row>
  </v-container>
<!--    <v-container>-->
<!--        <v-row>-->
<!--            <v-col cols="4">-->
<!--                <v-card class="mx-auto" dark color="#26c6da" shaped hover :to="{ name: 'secretaria.visitantes'}">-->
<!--                    <v-card-title>-->
<!--                        <v-icon large left>mdi-bank</v-icon>-->
<!--                        R$ 325.88 / Saldo Atual-->
<!--                    </v-card-title>-->
<!--                    <v-card-subtitle>Tenha o controle geral dos visitantes com relatórios sempre atualizados.-->
<!--                    </v-card-subtitle>-->
<!--                </v-card>-->
<!--            </v-col>-->
<!--            <v-col cols="4">-->
<!--                <v-card class="mx-auto" dark color="#4caf50" shaped hover :to="{ name: 'secretaria.cartaRecomendacao'}">-->
<!--                    <v-card-title>-->
<!--                        <v-icon large left>mdi-trending-up</v-icon>-->
<!--                        R$ 8.947,55 / Receita-->
<!--                    </v-card-title>-->
<!--                    <v-card-subtitle>Emissão de cartas, controle e relatórios com notificações e assinaturas.-->
<!--                    </v-card-subtitle>-->
<!--                </v-card>-->
<!--            </v-col>-->
<!--            <v-col cols="4">-->
<!--                <v-card class="mx-auto" dark color="#f44336" shaped hover :to="{ name: 'members.all'}">-->
<!--                    <v-card-title>-->
<!--                        <v-icon large left>mdi-trending-down</v-icon>-->
<!--                        R$ 18.947,55 / Despesas-->
<!--                    </v-card-title>-->
<!--                    <v-card-subtitle>Visualize, cadastre e gere relatorios completos sobre os membros.</v-card-subtitle>-->
<!--                </v-card>-->
<!--            </v-col>-->
<!--        </v-row>-->
<!--        <v-row>-->
<!--            <v-col>-->
<!--                <v-data-table-->
<!--                        v-model="selected"-->
<!--                        :headers="headers"-->
<!--                        :items="desserts"-->
<!--                        :single-select="singleSelect"-->
<!--                        item-key="name"-->
<!--                        show-select-->
<!--                        class="elevation-1"-->
<!--                >-->
<!--                    <template v-slot:top>-->
<!--                        <v-switch v-model="singleSelect" label="Single select" class="pa-3"></v-switch>-->
<!--                    </template>-->
<!--                </v-data-table>-->
<!--            </v-col>-->
<!--        </v-row>-->
<!--    </v-container>-->
</template>
<script>
  export default {
    middleware: ['auth', 'permission'],
    data () {
      return {
        singleSelect: false,
        selected: [],
        headers: [
          {
            text: 'Dessert (100g serving)',
            align: 'left',
            sortable: false,
            value: 'name',
          },
          { text: 'Calories', value: 'calories' },
          { text: 'Fat (g)', value: 'fat' },
          { text: 'Carbs (g)', value: 'carbs' },
          { text: 'Protein (g)', value: 'protein' },
          { text: 'Iron (%)', value: 'iron' },
        ],
        desserts: [
          {
            name: 'Frozen Yogurt',
            calories: 159,
            fat: 6.0,
            carbs: 24,
            protein: 4.0,
            iron: '1%',
          },
          {
            name: 'Ice cream sandwich',
            calories: 237,
            fat: 9.0,
            carbs: 37,
            protein: 4.3,
            iron: '1%',
          },
          {
            name: 'Eclair',
            calories: 262,
            fat: 16.0,
            carbs: 23,
            protein: 6.0,
            iron: '7%',
          },
          {
            name: 'Cupcake',
            calories: 305,
            fat: 3.7,
            carbs: 67,
            protein: 4.3,
            iron: '8%',
          },
          {
            name: 'Gingerbread',
            calories: 356,
            fat: 16.0,
            carbs: 49,
            protein: 3.9,
            iron: '16%',
          },
          {
            name: 'Jelly bean',
            calories: 375,
            fat: 0.0,
            carbs: 94,
            protein: 0.0,
            iron: '0%',
          },
          {
            name: 'Lollipop',
            calories: 392,
            fat: 0.2,
            carbs: 98,
            protein: 0,
            iron: '2%',
          },
          {
            name: 'Honeycomb',
            calories: 408,
            fat: 3.2,
            carbs: 87,
            protein: 6.5,
            iron: '45%',
          },
          {
            name: 'Donut',
            calories: 452,
            fat: 25.0,
            carbs: 51,
            protein: 4.9,
            iron: '22%',
          },
          {
            name: 'KitKat',
            calories: 518,
            fat: 26.0,
            carbs: 65,
            protein: 7,
            iron: '6%',
          },
        ],
      }
    },
  }
</script>
