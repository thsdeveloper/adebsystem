<template>
  <div>
    <v-toolbar color="indigo" dark flat>
      <v-app-bar-nav-icon></v-app-bar-nav-icon>

      <v-toolbar-title>Registro de Visitantes</v-toolbar-title>

      <v-spacer></v-spacer>

      <div v-if="visitantesSelecionados.length > 0">
        <v-btn text @click="apresentarVisitantes()">
          Apresentar
        </v-btn>
        <v-btn text @click="enviarNotificacaoVisitante()">
           Enviar Mensagens
        </v-btn>
        <v-btn text @click="enviarNotificacaoVisitante()">
          Imprimir Cartas
        </v-btn>
      </div>

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
                <v-col xs="12" sm="6" md="4">
                  <v-text-field v-model="form.nome" outlined label="Nome do visitante" :rules="nomeRules"
                                required></v-text-field>
                </v-col>
                <v-col xs="12" sm="6" md="4">
                  <v-text-field v-model="form.email" :rules="emailRules" outlined label="Email do visitante"
                                hint="Email válido para envio de notificações"></v-text-field>
                </v-col>
                <v-col xs="12" sm="6" md="4">
                  <v-text-field v-model="form.telefone" v-mask="maskPhone" outlined
                                label="Telefone de contato"></v-text-field>
                </v-col>
                <v-col md="4">
                  <v-switch
                    v-model="form.evangelico"
                    label="O visitante ja é evangélico?"
                  ></v-switch>
                </v-col>
                <v-col md="4">
                  <v-switch
                    v-model="form.procurando_igreja"
                    label="Procurando uma igreja para congregar?"
                  ></v-switch>
                </v-col>
                <v-col cols="12" xs="12" sm="12" md="12">
                  <v-switch
                    v-model="form.autoriza_envio"
                    label="Autoriza o envio de mensagem?"
                  ></v-switch>
                  <v-switch
                    v-model="form.autoriza_apresentacao"
                    label="Autoriza a apresentação?"
                  ></v-switch>
                </v-col>
                <v-col cols="12">
                  <v-text-field v-model="form.igreja" outlined
                                label="De qual igreja o visitante pertence?"></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-textarea
                    v-model="form.observacao"
                    outlined
                    label="Observações sobre o visitante"
                    value=""></v-textarea>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-data-table  v-model="visitantesSelecionados" show-select :single-select="false" item-key="id"
                      :headers="headers" :items="visitantes" no-data-text="Nenhum visitante cadastrado!">

          <template v-slot:header.data-table-select="{ on , props }">
            <v-simple-checkbox color="purple" v-bind="props" v-on="on"/>
          </template>

          <template v-slot:item.data-table-select="{ isSelected, select }">
            <v-simple-checkbox :value="isSelected" @input="select($event)"></v-simple-checkbox>
          </template>


          <template v-slot:item.apresentado="{ item }">
            <div v-if="item.autoriza_apresentacao">
              <v-chip dark :color="(item.apresentado ? 'success' : (item.apresentado ? 'red' : 'dark' ))">
                <v-avatar left>
                  <v-icon>{{ item.apresentado ? 'mdi-checkbox-marked-circle' : (item.apresentado ? 'red' : 'block') }}
                  </v-icon>
                </v-avatar>


                {{ item.apresentado | apresentado }}
              </v-chip>
            </div>
            <div v-else>
              <v-chip>
                Não autoriza apresentação
              </v-chip>
            </div>


          </template>
        </v-data-table>
      </v-tab-item>
    </v-tabs-items>
    <v-btn dark fab fixed bottom right color="success" large @click="salvaVisitante()">
      <v-icon>save</v-icon>
    </v-btn>
  </div>
</template>
<script>
import {mapGetters} from "vuex";
import swal from "sweetalert2";
import * as types from "../../store/mutation-types";

export default {
  middleware: ["auth", 'permission'],
  metaInfo() {
    return {title: 'Cadastro de Visitantes'}
  },
  data() {
    return {
      tab: null,
      visitantesSelecionados: [],
      items: [
        'Cadastro', 'Lista de Visitantes',
      ],

      form: {
        nome: null,
        email: null,
        telefone: null,
        procurando_igreja: false,
        evangelico: false,
        igreja: null,
        observacao: null,
        autoriza_envio: false,
        autoriza_apresentacao: false
      },

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
        {text: 'Telefone', align: 'left', value: 'telefone'},
        {text: 'Data da Visita', align: 'left', value: 'created_at'},
        {text: 'Cadastrado por', align: 'left', value: 'user.name'},
        {text: 'Apresentado?', align: 'left', value: 'apresentado'},
      ],

      nomeRules: [
        v => !!v || 'Nome é obrigatório',
      ],
      emailRules: [
        v => !v || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail deve ser válido'
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
    },
    apresentarVisitantes() {
      swal({
        type: 'warning',
        showCancelButton: true,
        title: 'Apresentar visitantes?',
        confirmButtonText: 'Sim, apresentar!',
        cancelButtonText: 'Não, cancelar!',
        text: 'Alterando o status dos visitantes para "apresentado" como forma e identificação de cada pessoa nas apresentações.',
      }).then((result) => {
        if (result.value) {
          let loader = this.$loading.show();
          this.$store.dispatch('secretaria/apresentarVisitantes', this.visitantesSelecionados).then(res => {
            this.buscarVisitantes();
            loader.hide();
          });
        } else {
          console.info('Operação Cancelada');
        }
      });
    },
    enviarNotificacaoVisitante(){
      swal({
        type: 'warning',
        showCancelButton: true,
        title: 'Enviar mensagens de Email e SMS?',
        confirmButtonText: 'Sim, enviar!',
        cancelButtonText: 'Não, cancelar!',
        text: 'Os visitantes com autorização de envio de mensagens receberá e-mail e SMS.',
      }).then((result) => {
        if (result.value) {
          let loader = this.$loading.show();
          this.$store.dispatch('secretaria/enviarMensagensVisitantes', this.visitantesSelecionados).then(res => {
            this.buscarVisitantes();
            loader.hide();
          });
        } else {
          console.info('Operação Cancelada');
        }
      });
    }
  },
  computed: {
    ...mapGetters({
      visitantes: 'secretaria/visitantes',
      visitante: 'secretaria/visitante'
    })
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
