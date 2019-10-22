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
            const {data} = await axios.get('/api/setores');
            commit(types.FETCH_SETORES, {setores: data})
        } catch (e) {
            alert('Ocorreu um erro na busca de setores')
        }
    },
};
