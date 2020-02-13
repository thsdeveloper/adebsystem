<template>
    <v-container>
        <v-form ref="form" v-model="valid">
            <v-card>
                <v-card-title class="">
                    <v-icon left>mdi-church</v-icon>
                    Cadastro de igreja
                </v-card-title>
                <v-card-subtitle>
                    Cadastre sua igreja com as devidas informações para uma boa análise de relatórios
                </v-card-subtitle>

                <v-card-text class="mt-5">
                    <v-row>
                        <v-col md="4">
                            <v-text-field v-model="form.nome_igreja"
                                          :counter="150" label="Nome da Igreja" outlined
                                          required/>
                        </v-col>
                        <v-col md="4">
                            <v-select v-model="form.setor_id" :items="setores" outlined
                                      label="Escolha o Setor" item-text="codigo_setor"
                                      @change="buscarTesoureiros"
                                      item-value="id"/>
                        </v-col>
                        <v-col md="4">
                            <v-select v-model="form.pr_user_id" :items="pastores"
                                      outlined
                                      label="Pastor da igreja" item-text="name"
                                      item-value="id"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col md="4">
                            <v-select v-model="form.co_pr_user_id" :items="pastores"
                                      outlined
                                      label="Co-Pastor da igreja" item-text="name"
                                      item-value="id"/>
                        </v-col>
                    </v-row>
                    <v-divider/>

                    <session-enderecos/>

                </v-card-text>
            </v-card>
        </v-form>

        <v-btn color="success" fab dark fixed bottom right large @click="cadastrarIgreja">
            <v-icon>save</v-icon>
        </v-btn>

    </v-container>
</template>
<script>
  import { mapGetters } from 'vuex'
  import GoogleMapLoader from '../../components/GoogleMapLoader'
  import SessionEnderecos from '../../components/SessionEndereco'

  export default {
    name: 'CadastroIgreja',
    components: { SessionEnderecos, GoogleMapLoader },
    middleware: ['auth', 'permission'],
    data: () => ({
      valid: false,
      maskCep: '#####-###',
      numeroEnd: '######',

      form: {
        nome_igreja: null,
        setor_id: null,
        pr_user_id: null,
        co_pr_user_id: null,
      },

      rules: {
        campoObrigatorio: [
          v => !!v || 'Este campo é obrigatório',
        ],
      },
    }),
    computed: {
      ...mapGetters({
        setores: 'setor/setores',
        igrejas: 'igreja/igrejas',
        pastores: 'user/pastores',
        endereco: 'endereco/enderecoViaCep',
        latLng: 'endereco/latLng',
      }),
    },
    methods: {
      cadastrarIgreja () {
        if (this.$refs.form.validate()) {
          let loader = this.$loading.show()
          this.$store.dispatch('igreja/cadastrarIgreja', {
            igreja: this.form,
            endereco: this.endereco,
            latLng: this.latLng
          }).finally(() => {
            loader.hide()
            this.$router.push({ name: 'setoresIgrejas.home' });
            this.$toasted.show('Igreja cadastrada com sucesso!');
          })
        }

      },
      buscaPastores () {
        this.$store.dispatch('user/buscaPastores');
      },
      buscarTesoureiros () {
        this.$store.dispatch('member/buscarTesoureiros', this.form.setor_id);
      },
    },
    mounted () {
      this.buscaPastores();
    }
  }
</script>
