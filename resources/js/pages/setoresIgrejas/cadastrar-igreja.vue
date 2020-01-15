<template>
    <v-container>
        <v-row>
            <v-col>
                <titulo-pagina title="Cadastro de Igrejas"
                               description="As igrejas serão cadastras com informações pernitentes ao seu setor ministerial"/>
            </v-col>
        </v-row>
        <v-card class="mx-auto">
            <v-form ref="form" v-model="valid" lazy-validation>
                <v-container>
                    <v-row>
                        <v-col md="4">
                            <v-text-field v-model="form.nome_igreja" :rules="rules.campoObrigatorio"
                                          :counter="150" label="Nome da Igreja"
                                          required/>
                        </v-col>
                        <v-col md="4">
                            <v-select v-model="form.setor_id" :items="setores"
                                      label="Escolha o Setor" item-text="codigo_setor"
                                      :rules="rules.campoObrigatorio"
                                      item-value="id"/>
                        </v-col>
                        <v-col md="4">
                            <v-select v-model="form.pr_user_id" :items="pastores"
                                      :rules="rules.campoObrigatorio"
                                      label="Pastor da igreja" item-text="name"
                                      item-value="id"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col md="4">
                            <v-select v-model="form.co_pr_user_id" :items="pastores"
                                      :rules="rules.campoObrigatorio"
                                      label="Co-Pastor da igreja" item-text="name"
                                      item-value="id"/>
                        </v-col>
                    </v-row>
                    <v-divider/>
                    <v-row>
                        <v-col>
                            <v-text-field v-model="form.endereco.cep" v-mask="maskCep" label="CEP"
                                          @change="buscaCEP"/>
                        </v-col>
                        <v-col>
                            <v-select v-model="form.endereco.state_id" :items="estados"
                                      :rules="rules.campoObrigatorio"
                                      label="Estado"
                                      item-text="name"
                                      item-value="uf" hint="Selecione o estado do usuário"
                                      @change="buscarCidade"
                                      no-data-text="Não encontramos este estado!"/>
                        </v-col>
                        <v-col>
                            <v-autocomplete v-model="form.endereco.city_id" :items="cidades"
                                            :rules="rules.campoObrigatorio"
                                            label="Cidade" item-text="name"
                                            item-value="name" deletable-chips
                                            hint="Selecione a cidade do usuário"
                                            no-data-text="Não encontramos a cidade!"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-text-field v-model="form.endereco.neighborhood"
                                          :rules="rules.campoObrigatorio"
                                          label="Bairro"/>
                        </v-col>
                        <v-col>
                            <v-text-field v-model="form.endereco.address"
                                          :rules="rules.campoObrigatorio"
                                          label="Endereço"/>
                        </v-col>
                        <v-col>
                            <v-text-field v-model="form.endereco.number" v-mask="numeroEnd"
                                          label="Número"
                                          :rules="rules.campoObrigatorio"
                                          placeholder="Ex. 38"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <GmapMap :center="{ lat: -15.7825066, lng: -47.7501889}"
                                     :zoom="10" map-type-id="roadmap"
                                     style="width: 100%; height: 450px">

                                <GmapMarker :position="{ lat: -15.7825066, lng: -47.7501889}"
                                            :clickable="true"
                                            :label="form.nome_igreja"
                                            :opacity="1.0"
                                            :draggable="true"
                                            @click="clickInfoMap($event.latLng)"
                                            title="Arraste o ponteiro para o endereço da igreja."
                                            @dragend="gMapFunc($event.latLng)"/>

                            </GmapMap>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-btn color="primary" @click="cadastrarIgreja">Cadastrar</v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card>
    </v-container>
</template>
<script>
  import { mapGetters } from 'vuex'
  import axios from 'axios'
  import TituloPagina from '../../components/TituloPagina'
  import GoogleMapLoader from '../../components/GoogleMapLoader'

  export default {
    name: 'CadastroIgreja',
    components: { GoogleMapLoader, TituloPagina },
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
        endereco: {
          cep: null,
          state_id: null,
          city_id: null,
          number: null,
          address: null,
          neighborhood: null,
          lat: null,
          lng: null
        }
      },

      rules: {
        campoObrigatorio: [
          v => !!v || 'Este campo é obrigatório',
        ],
      },
    }),
    computed: {
      ...mapGetters({
        estados: 'member/states',
        cidades: 'member/cities',
        setores: 'setor/setores',
        igrejas: 'igreja/igrejas',
        pastores: 'user/pastores',
      }),

      mapConfig () {
        return {}
      },
    },

    methods: {
      gMapFunc (event) {
        console.log(event.lat())
        this.form.endereco.lat = event.lat()
        this.form.endereco.lng = event.lng()
      },
      clickInfoMap (event) {
        console.log('click: ', event.lng())
      },
      cadastrarIgreja () {
        if (this.$refs.form.validate()) {
          let loader = this.$loading.show()
          this.$store.dispatch('igreja/cadastrarIgreja', this.form).finally(() => {
            loader.hide()
            this.$router.push({ name: 'setoresIgrejas.home' })
          })
        }

      },
      buscaPastores () {
        this.$store.dispatch('user/buscaPastores')
        // this.$store.dispatch('user/buscaPastores').finally(() => (this.isLoading = false));
      },
      buscaCEP () {
        var _this = this
        let loader = this.$loading.show()
        if (this.form.endereco.cep.length === 9) {
          axios.get('https://viacep.com.br/ws/' + this.form.endereco.cep + '/json/')
            .then(function (res) {
              if (res.data.erro === true) {
                loader.hide()
                swal.fire(
                  'CEP inválido',
                  'Por favor, preencha o endereço completo ou insira um novo CEP.',
                  'question')
              }
              var UF = res.data.uf
              _this.form.endereco.neighborhood = res.data.bairro
              _this.form.endereco.address = res.data.logradouro
              _this.form.endereco.state_id = UF
              if (UF !== '') {
                _this.buscarCidade(UF)
                _this.form.endereco.city_id = res.data.localidade
              }
              loader.hide()
            }).catch(function (error) {
            console.log(error)
          })
        }
      },
      buscarCidade (uf) {
        this.$store.dispatch('member/fetchCities', uf)
      },
      buscarEstados () {
        this.$store.dispatch('member/fetchStates')
      },

    },
    mounted () {
      this.buscaPastores()
      this.buscarEstados()
    }
  }
</script>
