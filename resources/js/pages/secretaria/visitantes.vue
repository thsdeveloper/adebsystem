<template>
  <div>
    <v-toolbar color="indigo" dark flat>
      <!--      <v-app-bar-nav-icon></v-app-bar-nav-icon>-->

      <v-toolbar-title>Controle de Visitantes</v-toolbar-title>

      <v-spacer></v-spacer>

      <div v-if="visitantesSelecionados.length > 0">
        <v-btn text @click="apresentarVisitantes()">
          Apresentar
        </v-btn>
        <v-btn text @click="enviarNotificacaoVisitante()">
          Enviar Mensagens
        </v-btn>
      </div>
      <v-btn text href="/api/relatorio/visitantes" target="_blank">
        Gerar Relatório
      </v-btn>

      <!--      <v-btn icon>-->
      <!--        <v-icon>mdi-dots-vertical</v-icon>-->
      <!--      </v-btn>-->

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
                <v-col cols="12" xs="12" sm="12" md="4">
                  <v-text-field v-model="form.nome" outlined label="Nome do visitante" :rules="nomeRules"
                                required></v-text-field>
                </v-col>
                <v-col cols="12" xs="12" sm="12" md="4">
                  <v-text-field v-model="form.email" :rules="emailRules" outlined label="Email dos visitante"
                                hint="Email válido para envio de notificações"></v-text-field>
                </v-col>
                <v-col cols="12" xs="12" sm="12" md="4">
                  <v-text-field v-model="form.telefone" v-mask="maskPhone" outlined
                                label="Telefone de contato"></v-text-field>
                </v-col>
                <v-col xs="12" sm="6" md="4">
                  <v-switch
                    v-model="form.evangelico"
                    label="O visitante ja é evangélico?"
                  ></v-switch>
                </v-col>
                <v-col xs="12" sm="6" md="4">
                  <v-switch
                    v-model="form.procurando_igreja"
                    label="Procurando uma igreja para congregar?"
                  ></v-switch>
                </v-col>
                <v-col xs="12" sm="6" md="4">
                  <v-switch
                    v-model="form.autoriza_envio"
                    label="Autoriza o envio de mensagens de agradecimento?"
                  ></v-switch>
                </v-col>
                <v-col xs="12" sm="6" md="4">
                  <v-switch
                    v-model="form.autoriza_apresentacao"
                    label="Autoriza a apresentação em público?"
                  ></v-switch>
                </v-col>
                <v-col xs="12" sm="6" md="8" v-if="form.evangelico">
                  <v-text-field v-model="form.igreja" outlined
                                label="Qual igreja você frequenta?"></v-text-field>
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
        <v-data-table v-model="visitantesSelecionados" show-select :single-select="false" item-key="id"
                      :headers="headers" :items="visitantes" no-data-text="Nenhum visitante cadastrado!">

          <template v-slot:header.data-table-select="{ on , props }">
            <v-simple-checkbox color="purple" v-bind="props" v-on="on"/>
          </template>

          <template v-slot:item.data-table-select="{ isSelected, select }">
            <v-simple-checkbox :value="isSelected" @input="select($event)"></v-simple-checkbox>
          </template>
          
          <template v-slot:item.created_at="{ item }">
            {{item.created_at | datacerta}}
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

          <template v-slot:item.envio_mensagem="{ item }">
            <div v-if="item.autoriza_envio">
              <v-chip dark :color="(item.envio_mensagem ? 'success' : (item.envio_mensagem ? 'red' : 'dark' ))">
                <v-avatar left>
                  <v-icon>{{
                      item.envio_mensagem ? 'mdi-checkbox-marked-circle' : item.envio_mensagem ? 'red' : 'block'
                    }}
                  </v-icon>
                </v-avatar>
                {{ item.envio_mensagem | envioMensagem }}
              </v-chip>
            </div>
            <div v-else>
              <v-chip>
                Não autoriza envio
              </v-chip>
            </div>
          </template>

          <template v-slot:item.acoes="{ item }">
            <v-menu bottom left>
              <template v-slot:activator="{ on, attrs }">
                <v-btn icon v-bind="attrs" v-on="on">
                  <v-icon>more_vert</v-icon>
                </v-btn>
              </template>

              <v-list dense>
                <v-dialog v-model="dialog" width="500">
                  <template v-slot:activator="{ on, attrs }">
                    <v-list-item v-bind="attrs" v-on="on">
                      <v-list-item-title>Visualizar</v-list-item-title>
                    </v-list-item>
                  </template>

                  <v-card>
                    <v-card-title class="headline grey lighten-2">
                      {{ item.nome }}
                    </v-card-title>

                    <v-card-text>
                      <div class="p-4">
                        <p>Email: <strong>{{ item.email }}</strong></p>
                        <p>Telefone: <strong>{{ item.telefone }}</strong></p>
                        <p>Já é evangélico: <strong>{{ item.evangelico | simNao }}</strong></p>
                        <p>Procurando Igreja?: <strong>{{ item.procurando_igreja | simNao }}</strong></p>
                        <p>Autoriza envio de mensagens?: <strong>{{ item.autoriza_envio | simNao }}</strong></p>
                        <p>Autoriza apresentação?: <strong>{{ item.autoriza_apresentacao | simNao }}</strong></p>
                        <p>Observações?: <strong>{{ item.observacao }}</strong></p>
                      </div>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="primary" text @click="dialog = false">
                        Ok
                      </v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
                <v-list-item @click="excluirVisitante(item)">
                  <v-list-item-title>Excluir</v-list-item-title>
                </v-list-item>
                <v-list-item :href="'/api/carta-boas-vindas/'+item.id" target="_blank">
                  <v-list-item-title>Emitir Carta</v-list-item-title>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Aceitar Membro</v-list-item-title>
                </v-list-item>
                <v-list-item @click="enviarMensagemWhatsap(item)">
                  <v-list-item-title>Enviar mensagem WhatsApp</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
          </template>

        </v-data-table>
      </v-tab-item>
<!--      <v-tab-item>-->
<!--        <relatorio-visitantes/>-->
<!--      </v-tab-item>-->
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
import RelatorioVisitantes from "../../components/RelatorioVisitantes";
import moment from 'moment'

export default {
  components: {RelatorioVisitantes},
  middleware: ["auth", 'permission'],
  metaInfo() {
    return {title: 'Cadastro de Visitantes'}
  },
  data() {
    return {
      dialog: false,
      tab: null,
      visitantesSelecionados: [],
      items: [
        'Cadastro', 'Lista de Visitantes'
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
        autoriza_apresentacao: false,
        envio_mensagem: false,
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
        // {text: 'Cadastrado por', align: 'left', value: 'user.name'},
        {text: 'Apresentado?', align: 'left', value: 'apresentado'},
        {text: 'Envio E-mail/SMS', align: 'left', value: 'envio_mensagem'},
        {text: 'Ações', align: 'left', value: 'acoes'},
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
    enviarNotificacaoVisitante() {
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
    },
    enviarMensagemWhatsap(visitante) {
      swal({
        type: 'warning',
        showCancelButton: true,
        title: 'Enviar mensagem para WhatsApp?',
        confirmButtonText: 'Sim, enviar!',
        cancelButtonText: 'Não, cancelar!',
        text: 'O visitante receberá uma mensagem pelo whatsapp.',
      }).then((result) => {
        if (result.value) {
          let loader = this.$loading.show();
          this.$store.dispatch('secretaria/enviarWhatsappVisitante', visitante).then(res => {
            this.buscarVisitantes();
            loader.hide();
          });
        } else {
          console.info('Operação Cancelada');
        }
      });
    },
    excluirVisitante(visitante) {
      swal({
        type: 'warning',
        showCancelButton: true,
        title: 'Excluir o visitante da base de dados?',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Não, cancelar!',
        text: 'O visitante será excluído e este ação não poderá ser desfeita.',
      }).then((result) => {
        if (result.value) {
          let loader = this.$loading.show();
          this.$store.dispatch('secretaria/excluirVisitante', visitante).then(res => {
            this.buscarVisitantes();
            loader.hide();
          });
        } else {
          console.info('Operação de excluir Cancelada');
        }
      });
    }
    // imprimirCartasVisitantes(id){
    //   swal({
    //     type: 'warning',
    //     showCancelButton: true,
    //     title: 'Emitir Carta de Boas Vindas?',
    //     confirmButtonText: 'Sim',
    //     cancelButtonText: 'Não, cancelar!',
    //     text: 'Você fará um download de um arquivo .pdf para imprimir as cartas.',
    //   }).then((result) => {
    //     if (result.value) {
    //       let loader = this.$loading.show();
    //       this.$store.dispatch('secretaria/emitirCartasVisitantes', id).then(res => {
    //         this.buscarVisitantes();
    //         loader.hide();
    //       });
    //     } else {
    //       console.info('Operação de emitir carta foi cancelada');
    //     }
    //   });
    // }
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
   datacerta(data){
      if (data) {
        return moment(data).format('DD/MM/YYYY HH:mm')
      }
    },
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
    },
    envioMensagem(value) {
      if (value) {
        return 'Enviado'
      }
      return 'Pendente'
    },
    simNao(value) {
      if (value) {
        return 'Sim'
      }
      return 'Não'
    }
  }
}
</script>
