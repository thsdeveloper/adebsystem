<template>
  <div>
    <v-layout row wrap>
      <v-flex md12>
        <v-card>
          <v-text-field
            v-model="search"
            append-icon="search"
            label="Pesquise por nome"
            single-line
            hide-details
          ></v-text-field>
        </v-card>
      </v-flex>
      <v-flex v-if="users">
        <v-data-table
          :headers="headers"
          :items="users.data"
          :search="search"
          :pagination.sync="pagination"
          :total-items="totalDesserts"
          :loading="loading"
          :select-all="false"
          item-key="id"
          no-data-text="Nada encontradi por aqui"
          no-results-text="Nenhum resul"
          class="elevation-1"
        >
          <template slot="items" slot-scope="props">
            <td>
              <v-avatar color="grey lighten-4">
                <img :src="props.item.photo_url" :alt="props.item.name" />
              </v-avatar>
            </td>
            <td>{{ props.item.name }}</td>
            <td class="text-xs-right">{{ props.item.email }}</td>
            <td class="text-xs-right">{{ props.item.status }}</td>
            <td class="text-xs-right">{{ props.item.tipo_cadastro }}</td>
            <td class="text-xs-right">{{ props.item.details.cpf }}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
    <v-layout row justify-center>
      <v-btn dark fab fixed bottom right color="primary" to="created">
        <v-icon>add</v-icon>
      </v-btn>
    </v-layout>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "MembersAll",
  middleware: ['auth', 'permission'],
  data() {
    return {
      search: "",
      totalDesserts: 0,
      loading: false,
      pagination: {},
      headers: [
        { text: "Foto", sortable: false, value: "foto" },
        { text: "Nome", value: "name" },
        { text: "Email", sortable: false, value: "email" },
        { text: "Status", sortable: false, value: "Status" },
        {
          text: "Tipo de Cadastro",
          align: "left",
          sortable: false,
          value: "tipo-cadastro"
        },
        { text: "CPF", value: "protein" }
      ]
    };
  },
  methods: {
    buscaMember(user) {
      this.$store.dispatch("member/fetchMember", user.id);
    },
    fetchUsers() {
      this.$store.dispatch("auth/fetchUsers");
    }
  },
  computed: {
    ...mapGetters({ users: "auth/users" })
  },
  mounted() {
    this.fetchUsers();
  },
  created() {},
  metaInfo() {
    return { title: this.$t("members_manager") };
  }
};
</script>
<style scoped>
.v-btn--floating .v-icon {
  height: auto;
  width: auto;
}
</style>
