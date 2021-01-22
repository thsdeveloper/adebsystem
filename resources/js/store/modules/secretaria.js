import * as types from '../mutation-types'
import axios from "axios";
import swal from 'sweetalert2'
// state
export const state = {
  visitantes: [],
  visitante: {
    nome: null,
    email: null,
    telefone: null,
    procurando_igreja: false,
    evangelico: false,
    igreja: null,
    observacao: null,
    autoriza_envio: false,
    autoriza_apresentacao: false
  }
};

// getters
export const getters = {
  visitantes: state => state.visitantes,
  visitante: state => state.visitante,
};

// mutations
export const mutations = {
  [types.BUSCAR_VISITANTES](state, visitantes) {
    state.visitantes = visitantes
  },

  [types.BUSCAR_VISITANTE](state, visitante) {
    state.visitante = visitante
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
        }).then((result) => {
          if (result.value) {
            commit(types.BUSCAR_VISITANTES, data);
            return true;
          } else {
            console.info('Operação deu erro [Salvar Visitante]');
          }
        });
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
      commit(types.BUSCAR_VISITANTES, data);
    } catch (e) {
      alert('Ocorreu um erro na busca de visitantes')
    }
  },

  async apresentarVisitantes({commit}, visitantes){
    try {
      const {data} = await axios.post('/api/secretaria/apresentar-visitantes', visitantes);
      if (data) {
        swal({
          type: 'success',
          title: 'Visitantes alterados com sucesso?',
          text: 'Todos os visitantes com o autorização de apresentação foram alterados com sucesso!',
        }).then((result) => {
          if (result.value) {
            commit(types.BUSCAR_VISITANTES, data);
          } else {
            console.info('Operação Cancelada');
          }
        });
      }
    } catch (e) {
      console.error('Ocorreu um erro na busca de visitantes');
    }
  },

  async enviarMensagensVisitantes({commit}, visitantes){
    try {
      const {data} = await axios.post('/api/secretaria/enviar-notificacao-visitantes', visitantes);
      if (data) {
        swal({
          type: 'success',
          title: 'Mensagens enviadas com sucesso?',
          text: 'Todos os visitantes com o autorização receberam uma mensagem de e-mail e SMS!',
        }).then((result) => {
          if (result.value) {
            commit(types.BUSCAR_VISITANTES, data);
          } else {
            console.info('Operação Cancelada');
          }
        });
      }
    } catch (e) {
      console.error('Ocorreu um erro no envio de emails e sms de visitantes');
    }
  },

  async enviarWhatsappVisitante({commit}, visitante){
    try {
      const {data} = await axios.post('/api/secretaria/enviar-whatsapp-visitante', visitante);
      if (data) {
        swal({
          type: 'success',
          title: 'Mensagens enviadas com sucesso?',
          text: 'O visitante recebeu uma mensagem de enviar-whatsapp-visitante',
        }).then((result) => {
          if (result.value) {
            console.info('Operação enviada');
            // commit(types.BUSCAR_VISITANTES, data);
          } else {
            console.info('Operação Cancelada');
          }
        });
      }
    } catch (e) {
      console.error('Ocorreu um erro no envio de whatsapp ao visitante');
    }
  }

  // async emitirCartasVisitantes({commit}, id){
  //   try {
  //     const {data} = await axios.get('/api/carta-boas-vindas/'+id);
  //     if (data) {
  //       swal({
  //         type: 'success',
  //         title: 'Mensagens enviadas com sucesso?',
  //         text: 'Todos os visitantes com o autorização receberam uma mensagem de e-mail e SMS!',
  //       }).then((result) => {
  //         if (result.value) {
  //           commit(types.BUSCAR_VISITANTES, data);
  //         } else {
  //           console.info('Operação Cancelada');
  //         }
  //       });
  //     }
  //   } catch (e) {
  //     console.error('Ocorreu um erro no envio de emails e sms de visitantes');
  //   }
  // }
};
