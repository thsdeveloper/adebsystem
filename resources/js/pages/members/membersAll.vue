<template>
<v-container>
  <v-row>
    <v-col>
      <v-select v-model="form.setor_id" :items="setores" solo
                label="Escolha o Setor" item-text="codigo_setor"
                @change="buscaIgreja" item-value="id"></v-select>
    </v-col>
    <v-col>
      <v-autocomplete v-model="form.igreja_id" :items="igrejas" solo
                      label="Escolha a Igreja" item-text="nome_igreja" item-value="id"
                      hint="Selecione a igreja do membro"
                      no-data-text="Não encontramos esta igreja">
      </v-autocomplete>
    </v-col>
    <v-col>
      <v-select v-model="form.status_id" :items="situacoesmembros" solo label="Situação do membro"
                item-text="nome" item-value="id" required></v-select>
    </v-col>
  </v-row>
  <v-row>
    <v-col>

      <v-data-table
        :headers="headers"
        :items="desserts"
        :search="search"
        :options.sync="options"
        :server-items-length="totalDesserts"
        :loading="loading"
        class="elevation-1">
        <template v-slot:item.photo_url="{ item }">
          <v-avatar size="30px">
            <img :src="item.photo_url" alt="Imagem de Perfil">
          </v-avatar>
        </template>

        <template v-slot:item.acoes="{ item }">
          <v-menu bottom left>
            <template v-slot:activator="{ on }">
              <v-btn icon v-on="on">
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>
            <v-list dense>
              <v-list-item :to="'detail/'+item.id">
                <v-list-item-title>Visualizar perfil</v-list-item-title>
              </v-list-item>
              <v-list-item @click="">
                <v-list-item-title>Emitir carta de recomendação</v-list-item-title>
              </v-list-item>
              <v-list-item @click="">
                <v-list-item-title>Editar</v-list-item-title>
              </v-list-item>
              <v-list-item @click="desativarMembro(item)">
                <v-list-item-title>Desativar</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </template>
      </v-data-table>

      <v-dialog v-model="dialog" max-width="290" v-if="membroSelecionado != null">
        <v-card>
          <v-card-title class="headline">Desativar o membro {{membroSelecionado.name}}?</v-card-title>
          <v-card-text>
            Desativando este membro não será possível obter informações detalhadas como relatórios e perfil. Após a desativação
            somente o administrador do sistema poderá ativar novamente.
          </v-card-text>
          <v-card-actions>
            <div class="flex-grow-1"></div>
            <v-btn color="green darken-1" text @click="dialog = false">
              Cancelar
            </v-btn>
            <v-btn color="green darken-1" text @click="desativar">
              Desativar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>


      <v-btn dark fab fixed bottom right color="primary" to="created">
        <v-icon>add</v-icon>
      </v-btn>
    </v-col>

  </v-row>
</v-container>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        data() {
            return {
                dialog: false,
                membroSelecionado: null,
                totalDesserts: 0,
                desserts: [],
                loading: true,
                search: '',
                options: {},
                headers: [
                    {
                        text: 'Foto',
                        align: 'left',
                        sortable: false,
                        value: 'photo_url',
                    },
                    {text: 'Matrícula', value: 'matricula'},
                    {text: 'Nome', value: 'name'},
                    {text: 'Setor', value: 'details.igreja.setor.nome_setor'},
                    {text: 'Congregação', value: 'details.igreja.nome_igreja'},
                    {text: 'Situação', value: 'situacao_membro.nome'},
                    {text: 'Tipo de Cadastro', value: 'details.tipo_cadastro.nome'},
                    {text: 'Ações', value: 'acoes', sortable: false},
                ],
                form: {
                    setor_id: null,
                    igreja_id: null,
                }
            }
        },
        watch: {
            options: {
                handler() {
                    this.getDataFromApi().then(data => {
                        console.log('Recebido no handler', data);
                        this.desserts = data.items;
                        this.totalDesserts = data.total;
                    })
                },
                deep: true,
            },
        },
        mounted() {
            this.getDataFromApi().then(data => {
                console.log('Recebido no mounted', data);
                this.desserts = data.items;
                this.totalDesserts = data.total;
            })
        },
        methods: {
            getDataFromApi() {
                this.loading = true;
                return new Promise((resolve, reject) => {
                    const {sortBy, descending, page, itemsPerPage} = this.options;
                    console.log('Options:', this.options);

                    this.$store.dispatch('auth/fetchUsers', {page: page, itemsPerPage: itemsPerPage}).then(data => {
                        console.log('auth/fetchUsers', data);
                        let items = data.data;
                        const total = data.total;
                        this.loading = false;
                        resolve({items, total})
                    });
                })
            },
            desativarMembro(membro){
                this.membroSelecionado = membro;
                if(this.membroSelecionado != null){
                    this.dialog = true;
                }
            },
            desativar(){
                let loader = this.$loading.show();
                this.$store.dispatch('member/desativarMembro', this.membroSelecionado.id).then(res => {
                    this.desserts.splice(this.membroSelecionado, 1);
                    let toast = this.$toasted.show("Membro desativado!", {
                        theme: "bubble",
                        position: "top-right",
                        duration : 5000
                    });
                    loader.hide();
                    this.dialog = false;
                });
            },
            buscaRecursos() {
                let loader = this.$loading.show();
                this.$store.dispatch('setor/fetchSetores');
                this.$store.dispatch('member/buscarSituacoesMembro');
                loader.hide();
            },
            buscaIgreja() {
                let loader = this.$loading.show();
                this.$store.dispatch('igreja/buscarIgrejasPorSetor', this.form.setor_id).then(res => {
                    loader.hide();
                });
            },
        },
        computed: {
            ...mapGetters({
                setores: 'setor/setores',
                igrejas: 'igreja/igrejas',
                situacoesmembros: 'member/situacoesmembros',
            }),
        },
        mounted() {
            this.buscaRecursos();
        },
    }
</script>
