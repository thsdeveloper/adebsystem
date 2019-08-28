<template>
  <div>
    <div v-if="bottomNav === 'cadastrar'">
      <v-card>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-layout row wrap>
                <v-flex xs12 sm12 md12>
                  <h1>Cadastro de Visitantes</h1>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="form.nome" label="Nome do visitante" :rules="nomeRules"
                                required></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="form.email" label="Email do visitante"
                                hint="Email válido para envio de notificações"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="form.telefone" label="Telefone de contato"></v-text-field>
                </v-flex>
                <v-flex md4>
                  <v-switch v-model="form.procurando_igreja"
                            label="Este visitante está procurando uma igreja para congregar?"></v-switch>
                </v-flex>
                <v-flex md4>
                  <v-switch v-model="form.evangelico" label="O visitante ja é evangélico?"></v-switch>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="form.igreja" label="De qual igreja o visitante pertence?"></v-text-field>
                </v-flex>
                <v-flex xs12 sm12 md12>
                  <v-textarea
                    v-model="form.observacao"
                    outlined
                    label="Observações sobre o visitante"
                    value=""></v-textarea>
                </v-flex>

                <v-flex xs12 sm6 md4>
                  <v-btn color="success" @click="salvaVisitante">Cadastrar</v-btn>
                </v-flex>
              </v-layout>
            </v-form>
          </v-container>
        </v-card-text>
      </v-card>
    </div>
    <div v-if="bottomNav === 'visualizar'">
      <v-data-table :headers="headers" :items="visitantes" class="elevation-1">
        <template slot="items" slot-scope="props">
          <td>{{ props.item.nome }}</td>
          <td>{{ props.item.email | verificaNull }}</td>
          <td >{{ props.item.telefone | verificaNull}}</td>
          <td>
            <v-tooltip left v-if="props.item.telefone != null">
              <v-icon slot="activator" dark color="primary">announcement</v-icon>
              <span>{{ props.item.observacao }}</span>
            </v-tooltip>
            <span v-else>Sem observações</span>
            </td>
          <td>{{ props.item.created_at | moment("DD/MM/YYYY")}}</td>
          <td>
            <v-chip>
              <v-avatar>
                <img :src="props.item.user.photo_url" :alt="props.item.user.name">
              </v-avatar>
              {{props.item.user.name}}
            </v-chip>
          </td>
          <td>
            <v-chip v-if="props.item.apresentado" color="primary" text-color="white">{{ props.item.apresentado | apresentado }}</v-chip>
            <v-chip v-else color="red" text-color="white">{{ props.item.apresentado | apresentado }}</v-chip>
          </td>
        </template>
      </v-data-table>
    </div>
    <div v-if="bottomNav === 'apresentar'">
      apresentar
    </div>


    <v-bottom-nav :active.sync="bottomNav" :value="true" absolute color="white">
      <v-btn color="teal" flat value="cadastrar">
        <span>Cadastrar</span>
        <v-icon>add_circle</v-icon>
      </v-btn>

      <v-btn color="teal" flat value="visualizar">
        <span>Visualizar</span>
        <v-icon>supervisor_account</v-icon>
      </v-btn>

      <v-btn color="teal" flat value="apresentar">
        <span>Apresentar</span>
        <v-icon>record_voice_over</v-icon>
      </v-btn>
    </v-bottom-nav>
  </div>
</template>
<script>
    import { mapGetters } from "vuex";
    export default {
        middleware: ["auth"],
        data() {
            return {
                valid: false,
                bottomNav: 'cadastrar',
                maskPhone: '(##) # ####-####',

                headers: [
                    {
                        text: 'Nome do Visitante',
                        align: 'left',
                        value: 'nome',
                    },
                    { text: 'Email',  align: 'left', value: 'email' },
                    { text: 'Telefone',  align: 'left', value: 'telefone' },
                    { text: 'Observações',  align: 'left', value: 'observacao' },
                    { text: 'Data de Visita',  align: 'left', value: 'created_at' },
                    { text: 'Cadastrado por',  align: 'left', value: 'user.name' },
                    { text: 'Apresentado?',  align: 'left', value: 'apresentado' }
                ],

                form: {
                    nome: null,
                    email: null,
                    telefone: null,
                    procurando_igreja: false,
                    evangelico: false,
                    igreja: null,
                    observacao: null,
                },

                nomeRules: [
                    v => !!v || 'Nome é obrigatório',
                ],
            }
        },
        methods: {
            salvaVisitante() {
                if (this.$refs.form.validate()) {
                    let loader = this.$loading.show();
                    this.$store.dispatch('secretaria/salvarVisitante', this.form).then(res => {
                        loader.hide();
                    });
                }
            },
            buscarVisitantes() {
                this.$store.dispatch("secretaria/buscarVisitantes");
            }
        },
        computed: {
            ...mapGetters({ visitantes: "secretaria/visitantes" })
        },
        mounted() {
            this.buscarVisitantes();
        },
        filters: {
            // Filter definitions
            verificaNull(value) {
                if(value === null){
                    return 'Nenhuma informação'
                }
                return value
            },
            apresentado(value){
                if(value){
                    return 'Apresentado!'
                }
                return 'Não apresentado!'
            }
        }
    }
</script>
<style scoped>

</style>
