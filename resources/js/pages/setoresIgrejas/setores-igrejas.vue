<template>
  <div>
    <v-toolbar color="indigo" dark flat>
      <v-app-bar-nav-icon></v-app-bar-nav-icon>
      <v-toolbar-title>Gerenciamento de Setores/Igrejas</v-toolbar-title>
      <v-spacer></v-spacer>
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
    <div>
      <v-tabs-items v-model="tab">
        <v-tab-item>
          <v-card color="basil">
            <v-card-text>
              <v-data-table :search="search" :headers="headersIgreja" :items="igrejas" :items-per-page="5"
                            item-key="id"
                            class="elevation-1"
                            no-data-text="Nenhuma igreja cadastrada...">

                <template v-slot:item.acoes="{ item }">
                  <v-menu bottom left>
                    <template v-slot:activator="{ on }">
                      <v-btn icon v-on="on">
                        <v-icon>mdi-dots-vertical</v-icon>
                      </v-btn>
                    </template>
                    <v-list dense>
                      <v-list-item :to="'visualizar-igreja/'+item.id">
                        <v-list-item-title>Visualizar</v-list-item-title>
                      </v-list-item>
                      <v-list-item @click="editarIgreja(item)">
                        <v-list-item-title>Editar</v-list-item-title>
                      </v-list-item>
                      <v-list-item @click="excluirIgreja(item)">
                        <v-list-item-title>Excluir</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </template>

              </v-data-table>
            </v-card-text>
          </v-card>
        </v-tab-item>

        <v-tab-item>
          <v-card flat color="basil">
            <v-card-text>
              <v-data-table :headers="headersSetor" :items="setores" :items-per-page="5"
                            class="elevation-1" no-data-text="Nenhum setor cadastrado..."/>
            </v-card-text>
          </v-card>
        </v-tab-item>

      </v-tabs-items>

      <v-fab-transition>
        <v-btn :key="activeFab.icon" :color="activeFab.color" dark fab large fixed bottom right :to="activeFab.url">
          <v-icon>{{ activeFab.icon }}</v-icon>
        </v-btn>
      </v-fab-transition>
    </div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'
import Swal from 'sweetalert2'

export default {
  middleware: ['auth', 'permission'],
  name: 'setoresIgrejas',
  data() {
    return {
      tab: null,
      items: [
        'Setores', 'Igrejas',
      ],
      dialogCadastrarIgreja: false,
      search: '',
      headersIgreja: [
        {
          text: 'Nome da Igreja',
          align: 'left',
          sortable: false,
          value: 'nome_igreja',
        },
        {text: 'Setor', value: 'setor.codigo_setor'},
        {text: 'Pastor', value: 'pastor.name'},
        {text: 'Co-Pastor', value: 'co_pastor.name'},
        {text: 'Ações', value: 'acoes', sortable: false},
      ],
      headersSetor: [
        {
          text: 'Código do Setor',
          align: 'left',
          sortable: false,
          value: 'codigo_setor',
        },
        {text: 'Setor', value: 'nome_setor'},
        {text: 'Pastor Coordenador', value: 'pastor_coordenador.name'},
      ],
    }
  },
  methods: {
    editarIgreja(item) {
      Swal.fire({
        title: 'Error!',
        text: 'Do you want to continue',
        icon: 'error',
        confirmButtonText: 'Cool'
      })
    },
    excluirIgreja(item) {
      Swal.fire({
        icon: 'warning',
        title: 'Excluir igreja?',
        text: 'Deseja realmente excluir definitivamente a igreja ' + item.nome_igreja + ' ?',
        showCancelButton: true,
        confirmButtonText: 'Excluir',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.value) {
          this.$store.dispatch('igreja/excluir', item.id).finally(() => {
            this.$toasted.show('Igreja excluída com sucesso!')
          })
        }
      })
    },
    buscaSetores() {
      this.$store.dispatch('setor/fetchSetores')
    },
    buscarIgrejas() {
      this.$store.dispatch('igreja/buscarIgrejas')
    },
  },
  computed: {
    ...mapGetters({
      setores: 'setor/setores',
      igrejas: 'igreja/igrejas',
    }),
    activeFab() {
      switch (this.tab) {
        case 0:
          return {color: 'success', icon: 'add', url: 'cadastrar-igreja'}
        case 1:
          return {color: 'red', icon: 'add', url: 'cadastrar-setor'}
        default:
          return {}
      }
    },
  },
  mounted() {
    this.buscaSetores()
    this.buscarIgrejas()
  },
}
</script>

<style scoped>

</style>
