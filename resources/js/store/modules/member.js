import * as types from '../mutation-types'
import axios from 'axios'
import swal from 'sweetalert2'
// state
export const state = {
  membros: null,
  professions: [],
  memberDetail: null,
  maritalStatus: null,
  trusts: null,
  genders: null,
  schoolings: null,
  tiposCadastros: null,
  cargosMinisteriais: null,
  newUser: null,
  situacoesmembros: null,
  tesoureiros: [],
  aniversariantes: null
}

// getters
export const getters = {
  professions: state => state.professions,
  memberDetail: state => state.memberDetail,
  maritalStatus: state => state.maritalStatus,
  trusts: state => state.trusts,
  genders: state => state.genders,
  schoolings: state => state.schoolings,
  tiposCadastros: state => state.tiposCadastros,
  cargosMinisteriais: state => state.cargosMinisteriais,
  situacoesmembros: state => state.situacoesmembros,
  tesoureiros: state => state.tesoureiros,
  aniversariantes: state => state.aniversariantes,
  membros: state => state.membros,
}

// mutations
export const mutations = {
  [types.FETCH_PROFESSIONS] (state, { professions }) {
    state.professions = professions
  },

  [types.FETCH_USERS_SUCCESS](state, {users}) {
    state.membros = users
  },

  [types.BUSCAR_TIPOS_CADASTROS] (state, { tiposCadastros }) {
    state.tiposCadastros = tiposCadastros
  },

  [types.BUSCAR_CARGOS_MINISTERIAIS] (state, { cargosMinisteriais }) {
    state.cargosMinisteriais = cargosMinisteriais
  },

  [types.FETCH_MEMBER_DETAIL] (state, { memberDetail }) {
    state.memberDetail = memberDetail
  },

  [types.FETCH_MARITAL_STATUS] (state, { maritalStatus }) {
    state.maritalStatus = maritalStatus
  },

  [types.FETCH_TRUSTS] (state, { trusts }) {
    state.trusts = trusts
  },

  [types.FETCH_GENDERS] (state, { genders }) {
    state.genders = genders
  },

  [types.FETCH_SCHOOLINGS] (state, { schoolings }) {
    state.schoolings = schoolings
  },

  [types.SAVE_MEMBER] (state, { newUser }) {
    state.newUser = newUser
  },

  [types.BUSCAR_SITUACOES_MEMBROS] (state, data) {
    state.situacoesmembros = data
  },

  [types.BUSCA_ANIVERSARIANTES] (state, data) {
    state.aniversariantes = data
  },
}

// actions
export const actions = {

  async buscarMembros({commit}, options) {
    console.log('buscarMembros action', options);
    try {
      const {data} = await axios.get('/api/users', {
        params: {
          page: options.page,
          itemsPerPage: options.itemsPerPage,
          'filter[name]': options.form.nome,
          'filter[email]': options.form.email,
          'filter[details.cpf]': options.form.cpf,
          'filter[details.igreja.setor.nome_setor]': options.form.nome_setor,
          'filter[details.igreja.nome_igreja]': options.form.nome_igreja,
          'filter[departments.name]': options.form.nome_departamento,
          'filter[trusts.name]': options.form.nome_funcao_igreja,
        }
      });
      // commit(types.FETCH_USERS_SUCCESS, {users: data});
      return data;
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  async fetchProfessions ({ commit }) {
    try {
      const { data } = await axios.get('/api/professions')
      commit(types.FETCH_PROFESSIONS, { professions: data })

    } catch (e) {
      alert('Ocorreu um erro no fetchProfessions')
    }
  },

  async buscarSituacoesMembro ({ commit }) {
    try {
      const { data } = await axios.get('/api/membro/situacoes')
      commit(types.BUSCAR_SITUACOES_MEMBROS, data)

    } catch (e) {
      alert('Ocorreu um erro no buscar situacoes membro')
    }
  },

  async buscarTiposCadastros ({ commit }) {
    try {
      const { data } = await axios.get('/api/tipos-cadastros')
      commit(types.BUSCAR_TIPOS_CADASTROS, { tiposCadastros: data })
    } catch (e) {
      alert('Ocorreu um erro na busca de tipos de cadastros')
    }
  },

  async buscarCargosMinisteriais ({ commit }) {
    try {
      const { data } = await axios.get('/api/cargos-ministeriais')
      commit(types.BUSCAR_CARGOS_MINISTERIAIS, { cargosMinisteriais: data })
    } catch (e) {
      alert('Ocorreu um erro na busca de cargos ministeriais')
    }
  },

  async fetchMaritalStatus ({ commit }) {
    try {
      const { data } = await axios.get('/api/membro/marital-status')
      commit(types.FETCH_MARITAL_STATUS, { maritalStatus: data })
    } catch (e) {
      alert('Ocorreu um erro na busca do ESTADO CIVIL')
      s
    }
  },

  async fetchTrusts ({ commit }) {
    try {
      const { data } = await axios.get('/api/cargos-funcoes')
      commit(types.FETCH_TRUSTS, { trusts: data })
    } catch (e) {
      alert('Ocorreu um erro na busca do funções')
    }
  },

  async fetchMember ({ commit }, id) {
    try {
      const { data } = await axios.get('/api/membro/visualizar/' + id)
      if (data) {
        commit(types.FETCH_MEMBER_DETAIL, { memberDetail: data });
        return data;
      }
    } catch (e) {
    }
  },

  async saveMember ({ commit }, form) {
    try {
      const { data } = await axios.post('/api/membro/cadastrar', form)
    } catch (e) {
      swal({
        type: 'error',
        title: e.response.data.erros[0],
        text: e.response.data.code + ' | ' + e.response.data.msg,
        confirmButtonText: 'Ok',
      })
    }
  },

  async editarMembro ({ commit }, form) {
    try {
      const { data } = await axios.post('/api/membro/editar', form)
    } catch (e) {
      swal({
        type: 'error',
        title: e.response.data.erros[0],
        text: e.response.data.code + ' | ' + e.response.data.msg,
        confirmButtonText: 'Ok',
      })
    }
  },

  async fetchGenders ({ commit }) {
    try {
      const { data } = await axios.get('/api/membro/genders')
      commit(types.FETCH_GENDERS, { genders: data })
    } catch (e) {
      alert('Ocorreu um erro na busca do genero')
    }
  },

  async fetchSchoolings ({ commit }) {
    try {
      const { data } = await axios.get('/api/membro/schoolings')
      commit(types.FETCH_SCHOOLINGS, { schoolings: data })
    } catch (e) {
      alert('Ocorreu um erro na busca da escolaridade')
    }
  },

  async desativarMembro ({ commit }, id) {
    try {
      const { data } = await axios.post('/api/membro/desativar', { id_membro: id })
      return data
      // commit(types.DESATIVAR_MEMBRO, data)
    } catch (e) {
      alert('Ocorreu um erro na DESATIVAÇÃO DO MEMBRO')
    }
  },

  async buscarTesoureiros ({ commit }, idSetor) {
    try {
      const { data } = await axios.post('/api/membro/tesoureiros', { idSetor: idSetor })
      // commit(types.FETCH_SCHOOLINGS, { schoolings: data })
    } catch (e) {
      alert('Ocorreu ao buscar os tesoureiros')
    }
  },

  async buscaCadastroCpf ({ commit }, cpf) {
    try {
      const { data } = await axios.post('/api/membro/buscar-cadastro-membro-cpf', { cpf: cpf })
      return data
    } catch (e) {
      alert('Ocorreu ao buscar os tesoureiros')
    }
  },

  async buscarNumerosMembros ({ commit }) {
    try {
      const { data } = await axios.get('/api/membro/quantidade')
      return data
    } catch (e) {
      alert('Ocorreu ao buscar os tesoureiros')
    }
  },

  async buscarAniversariantes ({ commit }) {
    try {
      const { data } = await axios.get('/api/membro/aniversariantes')
      commit(types.BUSCA_ANIVERSARIANTES, data)
    } catch (e) {
      alert('Ocorreu ao buscar dos aniversariantes');
    }
  },

}
