<template>
  <div v-if="aniversariantes">
    <v-card class="mx-auto" rounded>
      <v-card-title>
        <v-icon>cake</v-icon>
        <div class="ml-2">
          Aniversariantes do Mês
        </div>
      </v-card-title>
      <v-card-subtitle>
        Confira os {{aniversariantes.total}} aniversariantes do mês de <strong>{{ aniversariantes.mesAtual }}</strong>
      </v-card-subtitle>
      <v-list-item v-for="item in aniversariantes.detalhes" :key="item.user.id">
        <v-list-item-content>
          <v-chip text-color="white" color="primary">
            <v-avatar left>
              <v-img :src="item.user.photo_url"></v-img>
            </v-avatar> {{ item.data_nascimento | data}}
          </v-chip>
          <v-list-item-title class="headline mb-1">
            {{ item.user.name }}
          </v-list-item-title>
          <v-list-item-subtitle>{{ item.user.email }} | <span v-if="item.igreja">{{item.igreja.nome_igreja}}</span></v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-card-actions>
      </v-card-actions>
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
