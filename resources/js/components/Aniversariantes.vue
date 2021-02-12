<template>
  <div v-if="aniversariantes">
    <v-card class="mx-auto" rounded>
      <v-card-title>
        <v-icon>cake</v-icon>
        <div class="ml-2">
          Aniversariantes do Mês
        </div>
      </v-card-title>
      <v-card-subtitle v-if="aniversariantes.total > 0">
        Confira os {{ aniversariantes.total }} aniversariantes do mês de <strong>{{ aniversariantes.mesAtual }}</strong>
      </v-card-subtitle>
      <v-divider></v-divider>

      <v-list-item v-if="aniversariantes.total > 0" v-for="item in aniversariantes.detalhes" :key="item.user.id">
        <v-list-item-avatar>
          <v-img :src="item.user.photo_url"></v-img>
        </v-list-item-avatar>


        <v-list-item-content>
          <v-list-item-title class="subtitle-1 mb-1">
            <v-chip small><strong>{{ item.data_nascimento | data }}</strong></v-chip> {{ item.user.name }}
          </v-list-item-title>
          <v-list-item-subtitle>{{ item.user.email }} | <span
            v-if="item.igreja">{{ item.igreja.nome_igreja }}</span></v-list-item-subtitle>
        </v-list-item-content>

      </v-list-item>


      <v-card-text>
        <div v-if="aniversariantes.total === 0">
          <v-alert color="grey lighten-1" type="warning">Nenhum aniversariante neste mês</v-alert>
        </div>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'
import moment from 'moment'

export default {
  name: "Aniversariantes",
  methods: {},
  computed: {
    ...mapGetters({
      aniversariantes: 'member/aniversariantes'
    }),
  },
  beforeMount() {
    this.$store.dispatch('member/buscarAniversariantes')
  },
  filters: {
    data(val) {
      if (val) {
        moment.locale('pt-BR');
        return moment(val).format('DD/MMMM')
      }
    }
  }
}
</script>

<style scoped>

</style>
