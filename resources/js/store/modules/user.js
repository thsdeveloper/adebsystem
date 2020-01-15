import * as types from '../mutation-types'
import axios from 'axios'

// state
export const state = {
  pastores: [],
}

// getters
export const getters = {
  pastores: state => state.pastores,
}

// mutations
export const mutations = {
  [types.BUSCA_PASTORES] (state, { pastores }) {
    state.pastores = pastores
  },
}

// actions
export const actions = {
  async buscaPastores ({ commit }, nome) {
    try {
      const { data } = await axios.get('/api/pastores')
      commit(types.BUSCA_PASTORES, { pastores: data })
    } catch (e) {
      alert('Erro ao buscar pastores')
    }
  },
}
