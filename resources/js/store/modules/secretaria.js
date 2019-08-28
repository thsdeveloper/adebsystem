import * as types from '../mutation-types'
import axios from "axios";
import swal from 'sweetalert2'
// state
export const state = {
  visitantes: [],
};

// getters
export const getters = {
  visitantes: state => state.visitantes,
};

// mutations
export const mutations = {
  [types.BUSCAR_VISITANTES](state, data) {
    state.visitantes = data
  },
};

// actions
export const actions = {
  async salvarVisitante({commit}, form) {
    try {
      const {data} = await axios.post('/api/secretaria/salvar-visitante', form);
      if (data) {
        swal({
          type: 'success',
          title: 'Visitante cadastrado com sucesso!',
          text: 'Aguardando ser apresentado...',
        });
        return true;
        // commit(types.SAVE_VISITANTE, form)
      }
    } catch (e) {
      swal({
        type: 'error',
        title: e.response.data.erros[0],
        text: e.response.data.erros[0],
        confirmButtonText: 'Ok',
      })
    }
  },

  async buscarVisitantes({commit}) {
    try {
      const {data} = await axios.get('/api/secretaria/listar-visitante');
      commit(types.BUSCAR_VISITANTES, data)

    }catch (e) {
      alert('Ocorreu um erro no fetchProfessions')
    }
  },
};
