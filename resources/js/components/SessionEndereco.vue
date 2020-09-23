<template>
  <div>
    <v-row v-if="form">
      <v-col>
        <v-text-field v-model="enderecoViaCep.cep" v-mask="maskCep" outlined label="CEP"
                      append-icon="delete" @change="buscarCEP" @click:append="limparCEP"
        />
      </v-col>
      <v-col>
        <v-select v-model="enderecoViaCep.uf" :items="estados"
                  :rules="rules.campoObrigatorio" outlined
                  label="Estado" :disabled="desabilitaForm"
                  item-text="name"
                  item-value="uf" hint="Selecione o estado do usuário"
                  no-data-text="Não encontramos este estado!" @change="buscarCidade"
                  @input="atualizaEstado"
        />
      </v-col>
      <v-col>
        <v-autocomplete v-model="enderecoViaCep.localidade" :items="cidades"
                        :rules="rules.campoObrigatorio" outlined
                        label="Cidade" item-text="name" :disabled="desabilitaForm"
                        item-value="name" deletable-chips hint="Selecione a cidade do usuário"
                        no-data-text="Não encontramos a cidade!"
                        @input="atualizaCidade"
        />
      </v-col>
    </v-row>
    <v-row v-if="form">
      <v-col>
        <v-text-field v-model="enderecoViaCep.bairro" :disabled="desabilitaForm"
                      :rules="rules.campoObrigatorio" outlined label="Bairro"
                      @input="atualizaBairro"
        />
      </v-col>
      <v-col>
        <v-text-field v-model="enderecoViaCep.logradouro" :rules="rules.campoObrigatorio"
                      outlined label="Endereço"
                      @input="atualizaEndereco"
        />
      </v-col>
      <v-col>
        <v-text-field v-model="enderecoViaCep.numero" v-mask="numeroEnd"
                      label="Número" outlined :rules="rules.campoObrigatorio"
                      placeholder="Ex. 38"
                      @input="atualizaNumero"
        />
      </v-col>
    </v-row>
    <v-row v-if="mapa">
      <v-col>
        <GmapMap :center="centerMap" :zoom="zoomMap" :map-type-id="roadmap"
                 :style="'width: '+widthMap+'; height: '+heightMap+''"
        >
          <GmapMarker :position="{ lat: -15.7825066, lng: -47.7501889}" :clickable="true" :label="labelMaker"
                      :opacity="1.0" :draggable="true" :title="titleMarker"
                      @click="clickInfoMap($event.latLng)"
                      @dragend="gMapFunc($event.latLng)"
          />
        </GmapMap>
      </v-col>
    </v-row>
  </div>
</template>
<script>
import { mapGetters, mapMutations } from 'vuex'
import GoogleMapLoader from './GoogleMapLoader'

export default {
  name: 'SessionEnderecos',
  components: { GoogleMapLoader },
  props: {
    mapa: { type: Boolean, default: false },
    form: { type: Boolean, default: true },
    centerMap: {
      type: Object,
      default () {
        return { lat: -15.7825066, lng: -47.7501889 }
      }
    },
    roadmap: { type: String, default: 'roadmap' },
    zoomMap: { type: Number, default: 10 },
    widthMap: { type: String, default: '100%' },
    heightMap: { type: String, default: '450px' },
    titleMarker: { type: String, default: 'Arraste o ponteiro para o endereço informado.' },
    labelMaker: { type: String, default: 'Local' }

  },
  data: () => ({
    maskCep: '#####-###',
    numeroEnd: '######',
    rules: {
      campoObrigatorio: [
        v => !!v || 'Este campo é obrigatório'
      ]
    }

  }),
  methods: {
    ...mapMutations({
      ATUALIZAR_CEP: 'endereco/ATUALIZAR_CEP',
      ATUALIZAR_ESTADO: 'endereco/ATUALIZAR_ESTADO',
      ATUALIZAR_CIDADE: 'endereco/ATUALIZAR_CIDADE',
      ATUALIZAR_BAIRRO: 'endereco/ATUALIZAR_BAIRRO',
      ATUALIZAR_ENDERECO: 'endereco/ATUALIZAR_ENDERECO',
      ATUALIZAR_NUMERO: 'endereco/ATUALIZAR_NUMERO',
      DESABILITA_FORM: 'endereco/DESABILITA_FORM'
    }),

    atualizaEstado (uf) {
      this.ATUALIZAR_ESTADO(uf)
    },
    atualizaCidade (cidade) {
      this.ATUALIZAR_CIDADE(cidade)
    },
    atualizaBairro (bairro) {
      this.ATUALIZAR_BAIRRO(bairro)
    },
    atualizaEndereco (endereco) {
      this.ATUALIZAR_ENDERECO(endereco)
    },
    atualizaNumero (numero) {
      this.ATUALIZAR_NUMERO(numero)
    },
    limparCEP () {
      this.DESABILITA_FORM(false)
    },

    buscarCEP () {
      let loader = this.$loading.show()
      this.$store.dispatch('endereco/buscarCEP', this.enderecoViaCep.cep).then(viaCep => {
        loader.hide()
      })
    },
    buscarEstados () {
      this.$store.dispatch('endereco/buscarEstados')
    },
    buscarCidade (uf) {
      this.$store.dispatch('endereco/buscarCidades', uf)
    },
    gMapFunc (event) {
      this.$store.dispatch('endereco/setLatLng', event)
    },
    clickInfoMap (event) {
      console.log('click: ', event.lng())
    }
  },
  computed: {
    ...mapGetters({
      estados: 'endereco/estados',
      cidades: 'endereco/cidades',
      enderecoViaCep: 'endereco/enderecoViaCep',
      desabilitaForm: 'endereco/desabilitaForm'
    })
  },
  mounted () {
    this.buscarEstados()
  }

}
</script>
