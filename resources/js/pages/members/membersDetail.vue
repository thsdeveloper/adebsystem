<template>
  <v-container fluid>
    <v-row v-if="member">
      <v-col cols="12" lg="8">
        <v-card class="mx-auto">
          <v-img height="150" class="" src="/img/fachada_adeb.jpg" gradient="rgba(255,255,255, 0), rgba(0,0,0, 1)"></v-img>

          <div class="mold-imageProfile">
            <v-avatar size="100">
              <img :src="member.photo_url" :alt="member.name">
            </v-avatar>
          </div>
          <div class="caption mold-info white--text">
            <span>Cadastrado em: {{member.created_at}}</span>
            <span>Matrícula: {{member.matricula}}</span>
          </div>


          <v-card-title>
            <div class="full-width pb-4">
              <div>
                {{ member.name }}
              </div>
              <div class="body-2">
                {{ member.details.profession.name }} | {{ member.email }}
              </div>
            </div>

            <div>
              <v-btn text color="primary" outlined>
                Informações de contato
              </v-btn>
            </div>
          </v-card-title>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
  name: 'DetalheDoMebro',
  methods: {
    fetchUser() {
      var id = this.$route.params.id
      this.$store.dispatch('member/fetchMember', id)
    }
  },
  mounted() {
    this.fetchUser()
  },
  computed: {
    ...mapGetters({
      member: 'member/memberDetail',
    }),
  },
}
</script>

<style scoped>
.full-width {
  width: 100%;
}

.mold-imageProfile {
  position: absolute;
  top: 25px;
  left: 10px;
}
</style>
