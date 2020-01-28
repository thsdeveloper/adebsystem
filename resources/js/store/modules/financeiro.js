import * as types from '../mutation-types'
import axios from 'axios'

// state
export const state = {
  categorias: [],
  contas: []
}

// getters
export const getters = {
  categorias: state => state.categorias,
  contas: state => state.contas,
}

// mutations
export const mutations = {
  [types.BUSCAR_CATEGORIAS_FINANCEIRO] (state, categorias) {
    state.categorias = categorias
  },

  [types.CADASTRAR_CATEGORIA_FINANCEIRO] (state, categoria) {
    state.categorias.splice(0, 0, categoria);
  },
}

// actions
export const actions = {

  async buscarCategorias ({ commit }, tipo) {
    try {
      const { data } = await axios.post('/api/financeiro/listar-tipo-categoria', { tipo: tipo })
      commit(types.BUSCAR_CATEGORIAS_FINANCEIRO, data)
    } catch (e) {
      alert('Ocorreu um erro na busca de categorias')
    }
  },

  async cadastrarCategoria ({ commit }, payload) {
    try {
      const { data } = await axios.post('/api/financeiro/inserir-tipo-categoria', { tipo: payload.tipo, nome: payload.categoria.nome })
      commit(types.CADASTRAR_CATEGORIA_FINANCEIRO, data.categoria);
      return data.categoria;
    } catch (e) {
      alert('Ocorreu um erro ao cadastrar uma categoria')
    }
  },

  async cadastrarTransacao ({ commit }, payload) {
    try {
      const { data } = await axios.post('/api/financeiro/inserir-transacao', { tipo: payload.tipo, transacao: payload.transacao })
      // commit(types.CADASTRAR_CATEGORIA_FINANCEIRO, data.categoria);
      // return data.categoria;
    } catch (e) {
      alert('Ocorreu um erro ao cadastrar uma transação')
    }
  },

}
