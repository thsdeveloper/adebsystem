import * as types from '../mutation-types'
import axios from "axios";

// state
export const state = {
    professions: null,
    states: null,
    cities: null,
    neighborhoods: null,
};

// getters
export const getters = {
    professions: state => state.professions,
    states: state => state.states,
    cities: state => state.cities,
    neighborhoods: state => state.neighborhoods,
};

// mutations
export const mutations = {
    [types.FETCH_PROFESSIONS] (state, { professions }) {
        state.professions = professions
    },

    [types.FETCH_STATES] (state, { states }) {
        state.states = states
    },

    [types.FETCH_CITIES] (state, { cities }) {
        state.cities = cities
    },

    [types.FETCH_NEIGHBORHOODS] (state, { neighborhoods }) {
        state.neighborhoods = neighborhoods
    },
};

// actions
export const actions = {
    async fetchProfessions({commit}) {
        try {
            const {data} = await axios.get('/api/professions');
            commit(types.FETCH_PROFESSIONS, { professions: data })

        }catch (e) {
            alert('Ocorreu um erro no fetchProfessions')
        }
    },

    async fetchStates({commit}) {
        try {
            const {data} = await axios.get('/api/states');
            commit(types.FETCH_STATES, { states: data })
        }catch (e) {
            alert('Ocorreu um erro no fetchStates')
        }
    },

    async fetchCities({commit}, ufState) {
        try {
            const {data} = await axios.get('/api/states/'+ufState+'/cities');
            commit(types.FETCH_CITIES, { cities: data })
        }catch (e) {
            alert('Ocorreu um erro no fetchStates')
        }
    },

    async fetchNeighborhoods({commit}, ufbairro) {
console.log(ufbairro);
        try {
            const {data} = await axios.get('/api/neighborhoods/'+ufbairro);
            commit(types.FETCH_NEIGHBORHOODS, { neighborhoods: data })
        }catch (e) {
            alert('Ocorreu um erro no fetchStates')
        }
    },




};
