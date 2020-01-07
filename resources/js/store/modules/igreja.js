import * as types from '../mutation-types'
import axios from "axios";
import swal from 'sweetalert2'
// state
export const state = {
    igrejas: [],
};

// getters
export const getters = {
    igrejas: state => state.igrejas,
};

// mutations
export const mutations = {
    [types.BUSCAR_IGREJAS](state, {igrejas}) {
        state.igrejas = igrejas
    },
};

// actions
export const actions = {
    async buscarIgrejasPorSetor({commit}, setor_id) {
        try {
            const {data} = await axios.get('/api/igrejas/' + setor_id);
            commit(types.BUSCAR_IGREJAS, {igrejas: data})
        } catch (e) {
            alert('Ocorreu um erro na busca de igrejas')
        }
    },

  async buscarIgrejas({commit}) {
    try {
      const {data} = await axios.get('/api/igrejas');
      commit(types.BUSCAR_IGREJAS, {igrejas: data})
    } catch (e) {
      alert('Ocorreu um erro na busca de igrejas')
    }
  },
};
