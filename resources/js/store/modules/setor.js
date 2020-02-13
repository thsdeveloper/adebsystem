import * as types from '../mutation-types'
import axios from "axios";

// state
export const state = {
    setores: [],
};

// getters
export const getters = {
    setores: state => state.setores,
};

// mutations
export const mutations = {
    [types.FETCH_SETORES](state, {setores}) {
        state.setores = setores
    },
};

// actions
export const actions = {
    async fetchSetores({commit}) {
        try {
            const {data} = await axios.get('/api/setor/listar');
            commit(types.FETCH_SETORES, {setores: data})
        } catch (e) {
            alert('Ocorreu um erro na busca de setores')
        }
    },

    async cadastrarSetor({ commit }, payload) {
        try {
            const { data } = await axios.post('/api/setor/cadastrar', payload)
            commit(types.CADASTRAR_SETOR, data.igreja)
        } catch (e) {
            alert('Ocorreu um erro ao cadastrar uma igreja')
        }
    },
};
