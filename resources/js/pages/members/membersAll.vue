<template>
  <v-container fluid>
    <v-row>
      <v-col>
        <v-text-field v-model="form.nome" autofocus dense label="Pesquise por nome"
                      placeholder="Pesquisar por nome"
                      v-on:keyup.enter="getMembrosApi" clearable @click:clear="getMembrosApi()" outlined></v-text-field>
      </v-col>
      <v-col>
        <v-text-field v-model="form.email" autofocus dense label="Pesquise por email"
                      placeholder="Pesquisar por email"
                      v-on:keyup.enter="getMembrosApi" clearable @click:clear="getMembrosApi()" outlined></v-text-field>
      </v-col>
      <v-col>
        <v-text-field v-model="form.cpf" autofocus dense label="Pesquise por CPF"
                      placeholder="Pesquisar por CPF"
                      v-on:keyup.enter="getMembrosApi" clearable @click:clear="getMembrosApi()" outlined></v-text-field>
      </v-col>
      <v-col>
        <v-select dense v-model="form.nome_setor" :items="setores" outlined clearable
                  label="Escolha o Setor" item-text="codigo_setor"
                  item-value="nome_setor">
        </v-select>
      </v-col>
      <v-col>
        <v-select dense v-model="form.nome_departamento" :items="departments" outlined clearable
                  label="Departamento" item-text="name"
                  item-value="name">
        </v-select>
      </v-col>
      <v-col>
        <v-select dense v-model="form.nome_funcao_igreja" :items="trusts" outlined clearable
                  label="Cargos/Função" item-text="name"
                  item-value="name">
        </v-select>
      </v-col>
<!--      <v-col>-->
<!--&lt;!&ndash;        <v-autocomplete dense v-model="form.nome_igreja" :items="igrejas" outlined&ndash;&gt;-->
<!--&lt;!&ndash;                        label="Escolha a Igreja" item-text="nome_igreja" item-value="nome_igreja"&ndash;&gt;-->
<!--&lt;!&ndash;                        hint="Selecione a igreja do membro"&ndash;&gt;-->
<!--&lt;!&ndash;                        no-data-text="Não encontramos esta igreja">&ndash;&gt;-->
<!--&lt;!&ndash;        </v-autocomplete>&ndash;&gt;-->
<!--      </v-col>-->
<!--      <v-col>-->
<!--        <v-select dense v-model="form.situacao_id" :items="situacoesmembros" label="Situação do membro" outlined-->
<!--                  item-text="nome" item-value="id" required></v-select>-->
<!--      </v-col>-->
      <v-col>
        <v-btn color="primary" block @click="getMembrosApi()">Buscar membros</v-btn>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-data-table
          :headers="headers"
          :items="membros"
          :search="form.nomeMembro"
          :options.sync="options"
          :server-items-length="totalMembros"
          :loading="loading"
          loading-text="Aguarde! Carregando..."
          no-data-text="Nenhum membro encontrato"
          class="elevation-1">


          <template v-slot:item.photo_url="{ item }">
            <v-avatar size="30px">
              <img :src="item.photo_url" alt="Imagem de Perfil">
            </v-avatar>
          </template>
          
          <template v-slot:item.created_at="{ item }">
            {{item.created_at | datacerta}}
          </template>

          <template v-slot:item.acoes="{ item }">
            <v-menu bottom left>
              <template v-slot:activator="{ on }">
                <v-btn icon v-on="on">
                  <v-icon>more_vert</v-icon>
                </v-btn>
              </template>
              <v-list dense>
                <v-list-item :to="'detail/'+item.id">
                  <v-list-item-title>Visualizar perfil</v-list-item-title>
                </v-list-item>
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
import {mapGetters} from 'vuex'
import swal from 'sweetalert2'
import moment from 'moment'

export default {
  middleware: ['auth', 'permission'],
  data() {
    return {
      dialog: false,
      totalMembros: 0,
      membros: [],
      loading: false,
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
        {text: 'Data de Cadastro', value: 'created_at'},
        {text: 'Ações', value: 'acoes', sortable: false},
      ],
      form: {
        nome: null,
        email: null,
        cpf: null,
        nome_setor: null,
        nome_igreja: null,
        nome_departamento: null,
        nome_funcao_igreja: null,
      }
    }
  },
  watch: {
    options: {
      handler() {
        this.getMembrosApi().then(data => {
          console.log('Obj Options: Recebido no handler', data)
          this.membros = data.items
          this.totalMembros = data.total
        })
      },
      deep: true,
    },
  },

  mounted() {
    //Assim que o componente estiver montado, busca todos os membros com paginação;
    this.getMembrosApi().then(data => {
      console.log('Recebido no mounted do getMembrosApi', data)
      this.membros = data.items
      this.totalMembros = data.total
    })
    this.buscaRecursos()
  },
  methods: {
    async getMembrosApi() {
      this.loading = true
      return new Promise((resolve, reject) => {
        const {sortBy, sortDesc, page, itemsPerPage} = this.options

        this.$store.dispatch('member/buscarMembros',
          {
            page: page,
            itemsPerPage: itemsPerPage,
            sortBy: sortBy,
            sortDesc: sortDesc,
            form: this.form
          }
        ).then(data => {

          console.info('Resultado da action', data);
          let items = data.data
          let total = data.total
          this.membros = data.data
          this.loading = false

          resolve({items, total})
        })
      })
    },
    desativarMembro(membro) {
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
    buscaRecursos() {
      let loader = this.$loading.show();
      this.$store.dispatch('setor/fetchSetores');
      this.$store.dispatch('member/buscarSituacoesMembro');
      this.$store.dispatch('department/fetchDepartments')
      this.$store.dispatch('member/fetchTrusts')
      loader.hide();
    },
    buscaIgreja() {
      let loader = this.$loading.show();
      this.$store.dispatch('igreja/buscarIgrejasPorSetor', this.form.nome_setor).then(res => {
        loader.hide()
      })
    },
    editarMembro(item) {
      this.$router.push({name: 'members.editar', params: {id: item.id}})
    }
  },
  computed: {
    ...mapGetters({
      setores: 'setor/setores',
      igrejas: 'igreja/igrejas',
      situacoesmembros: 'member/situacoesmembros',
      departments: 'department/departments',
      trusts: 'member/trusts',
    }),
  },
  filters: {
     datacerta(data){
      if (data) {
        return moment(data).format('DD/MM/YYYY HH:mm')
      }
    }
  }
}
</script>
