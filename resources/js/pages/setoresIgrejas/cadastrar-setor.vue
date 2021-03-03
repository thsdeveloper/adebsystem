<template>
    <v-container fluid>
        <v-form ref="form" v-model="valid">
            <v-card>
                <v-card-title>
                    <v-icon left>mdi-cube</v-icon>
                    Cadastro de setor
                </v-card-title>
                <v-card-subtitle>
                    Cadastre o setor com as devidas informações para uma boa análise de relatórios
                </v-card-subtitle>

                <v-card-text class="mt-5">
                    <v-row>
                        <v-col md="4">
                            <v-text-field v-model="form.nome_setor" :rules="rules.campoObrigatorio"
                                          :counter="150" label="Nome do Setor" outlined
                                          required/>
                        </v-col>
                        <v-col md="4">
                            <v-text-field v-model="form.codigo_setor" :rules="rules.campoObrigatorio"
                                          :counter="3" label="Código do Setor" outlined type="number"
                                          required/>
                        </v-col>
                        <v-col md="4">
                            <v-select v-model="form.pr_cord_setor_user_id" :items="pastores" outlined
                                      label="Pastor Coordenador" item-text="name"
                                      :rules="rules.campoObrigatorio"
                                      item-value="id"/>
                        </v-col>
                    </v-row>
                    <v-divider/>
                    <session-enderecos mapa/>
                </v-card-text>
            </v-card>
        </v-form>

        <v-btn color="success" fab dark fixed bottom right large @click="cadastrarSetor">
            <v-icon>save</v-icon>
        </v-btn>

    </v-container>
</template>
<script>
  import { mapGetters } from 'vuex'
  import SessionEnderecos from '../../components/SessionEndereco'

  export default {
    name: 'CadastroSetor',
    components: { SessionEnderecos },
    middleware: ['auth', 'permission'],
    data: () => ({
      valid: false,

      form: {
        pr_cord_setor_user_id: null,
        codigo_setor: null,
        nome_setor: null,
      },

      rules: {
        campoObrigatorio: [
          v => !!v || 'Este campo é obrigatório',
        ],
      },

    }),

    computed: {
      ...mapGetters({
        pastores: 'user/pastores',
        endereco: 'endereco/enderecoViaCep',
        latLng: 'endereco/latLng',
      }),
    },

    methods: {
      cadastrarSetor(){
        if (this.$refs.form.validate()) {
          let loader = this.$loading.show()
          this.$store.dispatch('setor/cadastrarSetor', {
            setor: this.form,
            endereco: this.endereco,
            latLng: this.latLng
          }).finally(() => {
            loader.hide()
            this.$toasted.show('Setor criado com sucesso!');
            this.$router.push({ name: 'setoresIgrejas.home'});
          })
        }
      },
      buscaPastores () {
        this.$store.dispatch('user/buscaPastores')
      },
    },
    mounted () {
      this.buscaPastores()
    }
  }
</script>
