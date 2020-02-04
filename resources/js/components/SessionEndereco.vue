<template>
    <div>
        <v-row>
            <v-col>
                <v-text-field v-model="form.cep" outlined v-mask="maskCep" label="CEP"
                              @change="buscaCEP"/>
            </v-col>
            <v-col>
                <v-select v-model="form.state_id" :items="estados"
                          :rules="rules.campoObrigatorio" outlined
                          label="Estado" :disabled="disabled"
                          item-text="name"
                          item-value="uf" hint="Selecione o estado do usuário"
                          @change="buscarCidade"
                          no-data-text="Não encontramos este estado!"/>
            </v-col>
            <v-col>
                <v-autocomplete v-model="form.city_id" :items="cidades"
                                :rules="rules.campoObrigatorio" outlined
                                label="Cidade" item-text="name" :disabled="disabled"
                                item-value="name" deletable-chips
                                hint="Selecione a cidade do usuário"
                                no-data-text="Não encontramos a cidade!"/>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-text-field v-model="form.neighborhood" :disabled="disabled"
                              :rules="rules.campoObrigatorio" outlined
                              label="Bairro"/>
            </v-col>
            <v-col>
                <v-text-field v-model="form.address"
                              :rules="rules.campoObrigatorio" outlined
                              label="Endereço"/>
            </v-col>
            <v-col>
                <v-text-field v-model="form.number" v-mask="numeroEnd"
                              label="Número" outlined
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
                                label="Nome"
                                :opacity="1.0"
                                :draggable="true"
                                @click="clickInfoMap($event.latLng)"
                                title="Arraste o ponteiro para o endereço da igreja."
                                @dragend="gMapFunc($event.latLng)"/>

                </GmapMap>
            </v-col>
        </v-row>
    </div>
</template>
<script>
  import { mapGetters } from 'vuex'
  import axios from 'axios'
  import swal from 'sweetalert2'
  import GoogleMapLoader from './GoogleMapLoader'

  export default {
    name: 'SessionEnderecos',
    components: { GoogleMapLoader },
    data: () => ({
      maskCep: '#####-###',
      numeroEnd: '######',
      disabled: false,

      form: {
        cep: null,
        state_id: null,
        city_id: null,
        number: null,
        address: null,
        neighborhood: null,
        lat: null,
        lng: null,
      },

      rules: {
        campoObrigatorio: [
          v => !!v || 'Este campo é obrigatório',
        ],
      },

    }),
    methods: {
      async buscaCEP() {
        try {
          if (this.form.cep.length === 9) {
            let loader = this.$loading.show();
            const { data } = await axios.get('https://viacep.com.br/ws/' + this.form.cep + '/json/');
            if(data){
              this.disabled = true;
              var UF = data.uf
              this.form.neighborhood = data.bairro
              this.form.address = data.logradouro
              this.form.state_id = UF
              if (UF !== '') {
                this.buscarCidade(UF)
                this.form.city_id = data.localidade
              }
              loader.hide();
            }
            if(data.erro){
              this.disabled = false;
              loader.hide();
              swal({
                type: 'error',
                title: 'CEP não encontrado!',
                text: 'Por favor, insira um CEP válido ou preencha manualmente o endereço.',
                confirmButtonText: 'Ok',
              })
            }
          }
        } catch (e) {
          console.error('103', e);
        }
      },
      buscarCidade (uf) {
        this.$store.dispatch('member/fetchCities', uf)
      },
      buscarEstados () {
        this.$store.dispatch('member/fetchStates')
      },
      gMapFunc (event) {
        console.log(event.lat())
        this.form.endereco.lat = event.lat()
        this.form.endereco.lng = event.lng()
      },
      clickInfoMap (event) {
        console.log('click: ', event.lng())
      },
    },
    computed: {
      ...mapGetters({
        estados: 'member/states',
        cidades: 'member/cities',
      }),
    },
    mounted () {
      this.buscarEstados()
    },

  }
</script>
