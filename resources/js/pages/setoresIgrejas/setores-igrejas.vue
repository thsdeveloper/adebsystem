<template>
  <div>
    <v-tabs v-model="tab" background-color="transparent" color="pink" grow>
      <v-tab>Igrejas</v-tab>
      <v-tab>Setores</v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-card flat color="basil">
          <v-card-text>
            <v-data-table :headers="headersIgreja" :items="igrejas" :items-per-page="5" class="elevation-1">

              <template v-slot:item.acoes="{ item }">
                <v-menu bottom left>
                  <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on">
                      <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                  </template>
                  <v-list dense>
                    <v-list-item :to="'detail/'+item.id">
                      <v-list-item-title>Visualizar</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="">
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
                          class="elevation-1"></v-data-table>
          </v-card-text>
        </v-card>
      </v-tab-item>

    </v-tabs-items>

    <v-fab-transition>
      <v-btn :key="activeFab.icon" :color="activeFab.color" dark fab fixed bottom right @click="dialogCadastrarIgreja = true">
        <v-icon>{{ activeFab.icon }}</v-icon>
      </v-btn>
    </v-fab-transition>

<!--    Cadastro de Igrejas-->
    <v-dialog v-model="dialogCadastrarIgreja" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialogCadastrarIgreja = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Cadastro de igreja</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn dark text @click="dialogCadastrarIgreja = false">Salvar</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-list three-line subheader>
          <v-subheader>User Controls</v-subheader>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>Content filtering</v-list-item-title>
              <v-list-item-subtitle>Set the content filtering level to restrict apps that can be downloaded</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>Password</v-list-item-title>
              <v-list-item-subtitle>Require password for purchase or use password to restrict purchase</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-list three-line subheader>
          <v-subheader>General</v-subheader>
          <v-list-item>
            <v-list-item-action>
              <v-checkbox v-model="notifications"></v-checkbox>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Notifications</v-list-item-title>
              <v-list-item-subtitle>Notify me about updates to apps or games that I downloaded</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-action>
              <v-checkbox v-model="sound"></v-checkbox>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Sound</v-list-item-title>
              <v-list-item-subtitle>Auto-update apps at any time. Data charges may apply</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-action>
              <v-checkbox v-model="widgets"></v-checkbox>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Auto-add widgets</v-list-item-title>
              <v-list-item-subtitle>Automatically add home screen widgets</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-card>
    </v-dialog>

  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    middleware: ['auth', 'permission'],
    name: 'church',
    data () {
      return {
        tab: null,
        dialogCadastrarIgreja: false,
        headersIgreja: [
          {
            text: 'Nome da Igreja',
            align: 'left',
            sortable: false,
            value: 'nome_igreja',
          },
          { text: 'Setor', value: 'setor.codigo_setor' },
          { text: 'Pastor', value: 'pastor.name' },
          { text: 'Co-Pastor', value: 'co_pastor.name' },
          { text: 'Ações', value: 'acoes', sortable: false },
        ],
        headersSetor: [
          {
            text: 'Código do Setor',
            align: 'left',
            sortable: false,
            value: 'codigo_setor',
          },
          { text: 'Setor', value: 'nome_setor' },
          { text: 'Pastor Coordenador', value: 'pastor_coordenador.name' },
        ],
      }
    },
    methods: {
      buscaSetores () {
        this.$store.dispatch('setor/fetchSetores')
      },
      buscarIgrejas () {
        this.$store.dispatch('igreja/buscarIgrejas')
      },
    },
    computed: {
      ...mapGetters({
        setores: 'setor/setores',
        igrejas: 'igreja/igrejas',
      }),
      activeFab () {
        switch (this.tab) {
          case 0:
            return { color: 'success', icon: 'add' }
          case 1:
            return { color: 'red', icon: 'add' }
          default:
            return {}
        }
      },
    },
    mounted () {
      this.buscaSetores()
      this.buscarIgrejas()
    },
  }
</script>

<style scoped>

</style>
