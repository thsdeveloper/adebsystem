<template>
  <v-container fluid>
    <v-row>
      <v-col>
        <v-card color="purple" dark>
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title>487 Membros</v-card-title>
              <v-card-subtitle>Total de membros ativos cadastrados em nossa base de dados.</v-card-subtitle>
              <v-card-actions>
                <v-btn class="ml-2" small outlined to="members/all">
                  Ver Membros
                </v-btn>
              </v-card-actions>
            </div>
          </div>
        </v-card>
      </v-col>
      <v-col>
        <v-card color="cyan" dark>
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title>125 visitas nos últimos 30 dias</v-card-title>
              <v-card-subtitle>Total de visitantes nos últimos 30 dias. Aproveite para convidar mais pessoas.</v-card-subtitle>
              <v-card-actions>
                <v-btn class="ml-2" small outlined to="secretaria/visitantes">
                  Ver Visitantes
                </v-btn>
              </v-card-actions>
            </div>
          </div>
        </v-card>
      </v-col>
      <v-col>
        <v-card color="orange" dark>
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title>Agenda Oficial</v-card-title>
              <v-card-subtitle>Confira os últimos eventos oficiais em todos o ministério.</v-card-subtitle>
              <v-card-actions>
                <v-btn class="ml-2" small outlined to="calendar">
                  ver agenda
                </v-btn>
              </v-card-actions>
            </div>
          </div>
        </v-card>
      </v-col>
      <v-col>
        <v-card color="purple" dark>
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title>Setor / Igrejas</v-card-title>
              <v-card-subtitle>Tenha acesso fácil ao cadastro de igrejas e setores do ministério.</v-card-subtitle>
              <v-card-actions>
                <v-btn class="ml-2" small outlined to="setoresIgrejas/home">
                  Ver Setores e Igrejas
                </v-btn>
              </v-card-actions>
            </div>
          </div>
        </v-card>
      </v-col>
    </v-row>

    <v-row>
<!--      <post-time-line></post-time-line>-->
    </v-row>

  </v-container>
</template>

<script>

import PostTimeLine from "../components/PostTimeLine";

export default {
  components: {PostTimeLine},
  middleware: 'auth',
  metaInfo() {
    return {title: this.$t('home')}
  },
  data() {
    return {

    }
  },
  methods: {


  },
  created() {

  },
  mounted() {

  }
}
</script>
