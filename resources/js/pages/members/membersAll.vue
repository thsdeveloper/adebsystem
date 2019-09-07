<template>
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
      </v-data-table>

      <v-btn dark fab fixed bottom right color="primary" to="created">
        <v-icon>add</v-icon>
      </v-btn>
    </v-col>

  </v-row>
</template>

<script>
    export default {
        data() {
            return {
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
                    {text: 'Status do Cadastro', value: 'situacao_membro.nome'},
                    {text: 'Tipo de Cadastro', value: 'details.tipo_cadastro.nome'},
                ],
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
        },
    }
</script>
