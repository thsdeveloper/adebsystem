import * as types from '../mutation-types'
import axios from "axios";

// state
export const state = {
    departments: [],
};

// getters
export const getters = {
    departments: state => state.departments,
};

// mutations
export const mutations = {
    [types.FETCH_DEPARTMENTS] (state, { departments }) {
        state.departments = departments
    },
};

// actions
export const actions = {
    async fetchDepartments({commit}) {
        try {
            const {data} = await axios.get('/api/departments');
            commit(types.FETCH_DEPARTMENTS, { departments: data })
        }catch (e) {
            alert('Ocorreu um erro no departments')
        }
    },
};
