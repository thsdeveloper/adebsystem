<template>
    <v-container fluid>
        <!--    <v-row>-->
        <!--      <v-col>-->
        <!--        <v-text-field v-model="form.nomeMembro" label="Nome membro" placeholder="Pesquisar por nome" outlined></v-text-field>-->
        <!--      </v-col>-->
        <!--      <v-col>-->
        <!--        <v-select dense v-model="form.setor_id" :items="setores" outlined-->
        <!--                  label="Escolha o Setor" item-text="codigo_setor"-->
        <!--                  @change="buscaIgreja" item-value="id">-->
        <!--        </v-select>-->
        <!--      </v-col>-->
        <!--      <v-col>-->
        <!--        <v-autocomplete dense v-model="form.igreja_id" :items="igrejas" outlined-->
        <!--                        label="Escolha a Igreja" item-text="nome_igreja" item-value="id"-->
        <!--                        hint="Selecione a igreja do membro"-->
        <!--                        no-data-text="Não encontramos esta igreja">-->
        <!--        </v-autocomplete>-->
        <!--      </v-col>-->
        <!--      <v-col>-->
        <!--        <v-select dense v-model="form.situacao_id" :items="situacoesmembros" label="Situação do membro" outlined-->
        <!--                  item-text="nome" item-value="id" required></v-select>-->
        <!--      </v-col>-->
        <!--      <v-col>-->
        <!--        <v-btn text outlined color="primary" block @click="getUsersApi()">Buscar membros</v-btn>-->
        <!--      </v-col>-->
        <!--    </v-row>-->
        <v-row>
            <v-col>

                <v-data-table
                        :headers="headers"
                        :items="membros"
                        :search="search"
                        :options.sync="options"
                        :server-items-length="totalMembros"
                        :loading="loading"
                        loading-text="Loading... Please wait"
                        class="elevation-1">


                    <template v-slot:item.photo_url="{ item }">
                        <v-avatar size="30px">
<!--                          {{item.photo_url}}-->
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
<!--                                <v-list-item @click="">-->
<!--                                    <v-list-item-title>Emitir carta de recomendação</v-list-item-title>-->
<!--                                </v-list-item>-->
                                <v-list-item @click="">
                                    <v-list-item-title @click="editarMembro(item)">Editar</v-list-item-title>
                                </v-list-item>
                                <v-list-item @click="desativarMembro(item)">
                                    <v-list-item-title>Desativar</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </template>
                </v-data-table>
                <v-btn dark fab fixed bottom right color="primary" large to="created">
                    <v-icon>add</v-icon>
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
  import { mapGetters } from 'vuex'
  import swal from 'sweetalert2'

  export default {
    middleware: ['auth', 'permission'],
    data () {
      return {
        dialog: false,
        totalMembros: 0,
        membros: [],
        loading: false,
        search: '',
        options: {},
        headers: [
          {
            text: 'Foto',
            align: 'left',
            sortable: false,
            value: 'photo_url',
          },
          { text: 'Matrícula', value: 'matricula' },
          { text: 'Nome', value: 'name' },
          { text: 'Setor', value: 'details.igreja.setor.nome_setor' },
          { text: 'Congregação', value: 'details.igreja.nome_igreja' },
          { text: 'Situação', value: 'situacao_membro.nome' },
          { text: 'Tipo de Cadastro', value: 'details.tipo_cadastro.nome' },
          { text: 'Ações', value: 'acoes', sortable: false },
        ],
        form: {
          nomeMembro: null,
          setor_id: null,
          igreja_id: null,
          situacao_id: null,
        }
      }
    },

    watch: {
      options: {
        handler () {
          this.getUsersApi().then(data => {
            console.log('Obj Options: Recebido no handler', data)
            this.membros = data.items
            this.totalMembros = data.total
          })
        },
        deep: true,
      },
    },

    mounted () {
      //Assim que o componente estiver montado, busca todos os membros com paginação do laravel
      this.getUsersApi().then(data => {
        console.log('Recebido no mounted do getUsersApi', data)
        this.membros = data.items
        this.totalMembros = data.total
      })

      this.buscaRecursos()
    },
    methods: {
      getUsersApi () {
        this.loading = true
        return new Promise((resolve, reject) => {
          const { sortBy, descending, page, itemsPerPage } = this.options

          this.$store.dispatch('auth/fetchUsers', { page: page, itemsPerPage: itemsPerPage }).then(data => {
            console.log('auth/fetchUsers', data)
            let items = data.data
            const total = data.total
            this.loading = false
            resolve({ items, total })
          })
        })
      },
      desativarMembro (membro) {
        swal({
          type: 'question',
          title: 'Deseja excluir o cadastro do membro?',
          text: 'Excluindo este membro suas informações serão mantidas no banco de dados, mas porém não será possível visualizar dados sobre o membro.',
          showCancelButton: true,
          confirmButtonText: 'Sim, excluir!',
          cancelButtonText: 'Não, cancelar!',
        }).then((result) => {
          if (result.value) {
            let loader = this.$loading.show();
            this.$store.dispatch('member/desativarMembro', membro.id).then(res => {
              this.membros.splice(membro, 1);
              let toast = this.$toasted.show('Membro excluído com sucesso!');
              loader.hide();
              this.dialog = false;
            })

          }
        })

      },
      //Busca informações de: setores, situação do membros
      buscaRecursos () {
        let loader = this.$loading.show();
        this.$store.dispatch('setor/fetchSetores');
        this.$store.dispatch('member/buscarSituacoesMembro');
        loader.hide();
      },
      buscaIgreja () {
        let loader = this.$loading.show();
        this.$store.dispatch('igreja/buscarIgrejasPorSetor', this.form.setor_id).then(res => {
          loader.hide()
        })
      },
      editarMembro(item){
        this.$router.push({ name: 'members.editar', params: {id: item.id}})
      }
    },
    computed: {
      ...mapGetters({
        setores: 'setor/setores',
        igrejas: 'igreja/igrejas',
        situacoesmembros: 'member/situacoesmembros',
      }),
    },
  }
</script>
