import * as types from '../mutation-types'
import axios from "axios";

// state
export const state = {
    professions: null,
};

// getters
export const getters = {
    professions: state => state.professions,
};

// mutations
export const mutations = {
    [types.FETCH_PROFESSIONS] (state, { professions }) {
        state.professions = professions
    },
};

// actions
export const actions = {
    async fetchProfessions({commit}) {
        try {
            const {data} = await axios.get('/api/professions');
            commit(types.FETCH_PROFESSIONS, { professions: data })

        }catch (e) {
            alert('Ocorreu um erro no fetchProfessions', e)
        }
    },
};
