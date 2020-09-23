import * as types from '../mutation-types'
import axios from 'axios'
import swal from "sweetalert2"

// state
export const state = {
  estados: [],
  cidades: [],
  desabilitaForm: false,
  enderecoViaCep: {
    bairro: null,
    cep: null,
    complemento: null,
    gia: null,
    ibge: null,
    localidade: null,
    logradouro: null,
    uf: null,
    unidade: null,
    numero: null
  },
  latLng: {
    lat: null,
    lng: null,
  }
}

// getters
export const getters = {
  estados: state => state.estados,
  cidades: state => state.cidades,
  enderecoViaCep: state => state.enderecoViaCep,
  desabilitaForm: state => state.desabilitaForm,
  latLng: state => state.latLng,
}

// mutations
export const mutations = {
  [types.BUSCAR_ESTADOS] (state, estados) {
    state.estados = estados
  },
  [types.BUSCAR_CIDADES] (state, cidades) {
    state.cidades = cidades
  },
  [types.BUSCAR_ENDERECO_CEP] (state, enderecoViaCep) {
    state.enderecoViaCep = enderecoViaCep;
    Object.assign(state.enderecoViaCep, {numero: null});
  },

  [types.ATUALIZAR_CEP] (state, value) {
    state.enderecoViaCep.cep = value
  },

  [types.ATUALIZAR_ESTADO] (state, uf) {
    console.log('Chegou o que??', state, uf)
    state.enderecoViaCep.uf = uf
  },

  [types.ATUALIZAR_CIDADE] (state, cidade) {
    state.enderecoViaCep.cidade = cidade
  },

  [types.ATUALIZAR_BAIRRO] (state, bairro) {
    state.enderecoViaCep.bairro = bairro
  },

  [types.ATUALIZAR_ENDERECO] (state, endereco) {
    state.enderecoViaCep.logradouro = endereco
  },

  [types.ATUALIZAR_NUMERO] (state, numero) {
    state.enderecoViaCep.numero = numero
  },

  [types.DESABILITA_FORM] (state, value) {
    state.desabilitaForm = value;
    Object.keys(state.enderecoViaCep).forEach(function(index) {
      state.enderecoViaCep[index] = null
    });
  },

  [types.SET_LAT_LNG] (state, latLng) {
    state.latLng.lat = latLng.lat();
    state.latLng.lng = latLng.lng();
  },

}

// actions
export const actions = {

  async buscarEstados({ commit }) {
    try {
      const { data } = await axios.get('/api/states');
      commit(types.BUSCAR_ESTADOS, data)
    } catch (e) {
      alert('Ocorreu um erro na busca de estados')
    }
  },

  async setLatLng({ commit }, latLng) {
    try {
      commit(types.SET_LAT_LNG, latLng)
    } catch (e) {
      alert('Ocorreu um erro na busca de Geolocalização')
    }
  },

  async buscarCidades({ commit }, ufState) {
    try {
      const { data } = await axios.get('/api/states/' + ufState + '/cities')
      commit(types.BUSCAR_CIDADES, data)
    } catch (e) {
      alert('Ocorreu um erro na busca de cidades')
    }
  },

  async buscarCEP({state ,commit, dispatch}, cep) {
    try {
      if (cep.length === 9) {
        const { data } = await axios.get('https://viacep.com.br/ws/' +cep+ '/json/');
        if(!data.erro){
          state.desabilitaForm = true;
          dispatch('buscarCidades', data.uf);
          commit(types.BUSCAR_ENDERECO_CEP, data);
          return data;
        }else{
          state.desabilitaForm = false;
          swal.fire(
            'CEP Não encontrado!',
            'Por favor, preencha o endereço completo ou insira um CEP válido.',
            'question')
          return false;
        }
      }
    } catch (e) {
      console.error('103', e);
    }
  },

}
