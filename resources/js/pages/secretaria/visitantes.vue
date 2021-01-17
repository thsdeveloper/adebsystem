<template>
  <div>
    <v-card>
      <v-toolbar color="cyan" dark flat>
        <v-app-bar-nav-icon></v-app-bar-nav-icon>

        <v-toolbar-title>Registro de Visitantes</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
          <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <v-btn icon>
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>

        <template v-slot:extension>
          <v-tabs v-model="tab" align-with-title>
            <v-tabs-slider color="yellow"></v-tabs-slider>
            <v-tab v-for="item in items" :key="item">
              {{ item }}
            </v-tab>
          </v-tabs>
        </template>

      </v-toolbar>

      <v-tabs-items v-model="tab">
        <v-tab-item>
          <v-card flat>
            <v-card-text>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-row>
                  <v-col xs12 sm6 md4>
                    <v-text-field v-model="form.nome" label="Nome do visitante" :rules="nomeRules"
                                  required></v-text-field>
                  </v-col>
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
                </v-row>
              </v-form>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-data-table :headers="headers" :items="visitantes" class="elevation-1">
            <template slot="items" slot-scope="props">
              <td>{{ props.item.nome }}</td>
              <td>{{ props.item.email | verificaNull }}</td>
              <td>{{ props.item.created_at | moment("DD/MM/YYYY") }}</td>
              <td>
                <v-chip>
                  <v-avatar>
                    <img :src="props.item.user.photo_url" :alt="props.item.user.name">
                  </v-avatar>
                  {{ props.item.user.name }}
                </v-chip>
              </td>
              <td>
                <v-chip v-if="props.item.apresentado" color="primary" text-color="white">{{
                    props.item.apresentado |
                      apresentado
                  }}
                </v-chip>
                <v-chip v-else color="red" text-color="white">{{ props.item.apresentado | apresentado }}</v-chip>
              </td>
            </template>
          </v-data-table>
        </v-tab-item>
        <v-tab-item>
          <v-layout column>
            <v-flex xs12 sm6>
              <v-card v-for="vi in visitantes" :key="vi.id">
                <v-card-title primary-title>
                  <div>
                    <h1 class="display-1">{{ vi.nome }}</h1>
                    <div class="headline">{{ vi.observacao }}</div>

                    <div v-if="vi.evangelico">
                      <v-chip color="green" text-color="white">Já convertido</v-chip>
                    </div>
                    <div v-else>
                      <v-chip color="red" text-color="white">Não convertido</v-chip>
                    </div>

                    <div v-if="vi.procurando_igreja">
                      <v-chip color="orange" text-color="white">Está procurando uma igreja</v-chip>
                    </div>

                    <h1 class="body-2">Email: <b>{{ vi.email | verificaNull }}</b></h1>
                    <h1 class="body-2">Telefone <b>{{ vi.telefone | verificaNull }}</b></h1>

                  </div>
                </v-card-title>
              </v-card>

            </v-flex>
          </v-layout>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </div>
</template>
<script>
import {mapGetters} from "vuex";
import {Glide, GlideSlide} from 'vue-glide-js';
import 'vue-glide-js/dist/vue-glide.css';

export default {
  components: {
    [Glide.name]: Glide,
    [GlideSlide.name]: GlideSlide
  },
  middleware: ["auth", 'permission'],
  data() {
    return {
      tab: null,
      items: [
        'Cadastro', 'Visualização', 'Apresentação',
      ],
      text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',

      valid: false,
      bottomNav: 'cadastrar',
      maskPhone: '(##) # ####-####',

      headers: [
        {
          text: 'Nome do Visitante',
          align: 'left',
          value: 'nome',
        },
        {text: 'Email', align: 'left', value: 'email'},
        // { text: 'Telefone',  align: 'left', value: 'telefone' },
        // { text: 'Observações',  align: 'left', value: 'observacao' },
        {text: 'Data da Visita', align: 'left', value: 'created_at'},
        {text: 'Cadastrado por', align: 'left', value: 'user.name'},
        {text: 'Apresentado?', align: 'left', value: 'apresentado'}
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
    ...mapGetters({visitantes: "secretaria/visitantes"})
  },
  mounted() {
    this.buscarVisitantes();
  },
  filters: {
    // Filter definitions
    verificaNull(value) {
      if (value === null) {
        return 'Nenhuma informação'
      }
      return value
    },
    apresentado(value) {
      if (value) {
        return 'Apresentado!'
      }
      return 'Não apresentado!'
    }
  }
}
</script>
