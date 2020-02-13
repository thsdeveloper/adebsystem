import * as types from '../mutation-types'
import axios from 'axios'

// state
export const state = {
  igrejas: [],
  igreja: {},
}

// getters
export const getters = {
  igrejas: state => state.igrejas,
  igreja: state => state.igreja,
}

// mutations
export const mutations = {
  [types.BUSCAR_IGREJAS] (state, { igrejas }) {
    state.igrejas = igrejas
  },

  [types.CADASTRAR_IGREJAS] (state, igreja ) {
    state.igreja = igreja
  },

  [types.REMOVER_IGREJA_ARRAY] (state, payload){
    const index = state.igrejas.findIndex(igreja => igreja.id == payload.igreja.id)
    state.igrejas.splice(index, 1);
  }
}

// actions
export const actions = {
  async buscarIgrejasPorSetor ({ commit }, setor_id) {
    try {
      const { data } = await axios.get('/api/igrejas/' + setor_id)
      commit(types.BUSCAR_IGREJAS, { igrejas: data })
    } catch (e) {
      alert('Ocorreu um erro na busca de igrejas')
    }
  },

  async buscarIgrejas ({ commit }) {
    try {
      const { data } = await axios.get('/api/igrejas')
      commit(types.BUSCAR_IGREJAS, { igrejas: data })
    } catch (e) {
      alert('Ocorreu um erro na busca de igrejas')
    }
  },

  async cadastrarIgreja ({ commit }, payload) {
    try {
      const { data } = await axios.post('/api/cadastrar-igreja', payload)
      commit(types.CADASTRAR_IGREJAS, data.igreja)
    } catch (e) {
      alert('Ocorreu um erro ao cadastrar uma igreja')
    }
  },

  async excluir ({ commit }, id) {
    try {
      const { data } = await axios.post('/api/excluir-igreja', {id: id})
      commit(types.REMOVER_IGREJA_ARRAY, data)
    } catch (e) {
      alert('Ocorreu um erro ao excluir uma igreja')
    }
  },

  async visualizarIgrejaPorId ({ commit }, id) {
    try {
      const { data } = await axios.post('/api/visualizar-igreja', {id: id})
      commit(types.CADASTRAR_IGREJAS, data)
    } catch (e) {
      alert('Ocorreu um erro ao buscar a igreja')
    }
  },

}
