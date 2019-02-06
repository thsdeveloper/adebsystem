import * as types from '../mutation-types'
import axios from "axios";
import swal from 'sweetalert2'
// state
export const state = {
    professions: [],
    states: [],
    cities: [],
    memberDetail: null,
    maritalStatus: null,
    trusts: null,
    genders: null,
    schoolings: null,
    newUser: null,
};

// getters
export const getters = {
    professions: state => state.professions,
    states: state => state.states,
    cities: state => state.cities,
    memberDetail: state => state.memberDetail,
    maritalStatus: state => state.maritalStatus,
    trusts: state => state.trusts,
    genders: state => state.genders,
    schoolings: state => state.schoolings,
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

    // async buscaMembroDetail({commit}, idUser) {
    //     try {
    //         const {data} = await axios.get('/api/member/detail/'+idUser);
    //         commit(types.FETCH_MEMBER_DETAIL, { memberDetail: data })
    //     }catch (e) {
    //         alert('Ocorreu um erro na busca do membro')
    //     }
    // },

    async fetchMaritalStatus({commit}) {
        try {
            const {data} = await axios.get('/api/member/marital-status');
            commit(types.FETCH_MARITAL_STATUS, { maritalStatus: data })
        }catch (e) {
            alert('Ocorreu um erro na busca do ESTADO CIVIL');s
        }
    },

    async fetchTrusts({commit}) {
        try {
            const {data} = await axios.get('/api/member/trusts');
            commit(types.FETCH_TRUSTS, { trusts: data })
        }catch (e) {
            alert('Ocorreu um erro na busca do funções');
        }
    },

    async fetchMember({commit}, id) {
        try {
            const {data} = await axios.get('/api/member/detail/'+id);
            if(data){
                commit(types.FETCH_MEMBER_DETAIL, { memberDetail: data })
            }
        }catch (e) {
        }
    },

    async saveMember({commit}, dados) {
        try {
            const {data} = await axios.post('/api/member/store', dados);
            if(data){
                swal({
                    type: 'success',
                    title: 'Membro cadastrado com sucesso!',
                    text: 'O membro '+data.user.name+' foi cadastrado com sucesso em nossa base de dados.',
                });
            }
            // commit(types.SAVE_MEMBER, { newUser: data })
        }catch (e) {
            alert('Ocorreu um erro para salvar o member');
        }
    },

    async fetchGenders({commit}) {
        try {
            const {data} = await axios.get('/api/member/genders');
            commit(types.FETCH_GENDERS, { genders: data })
        }catch (e) {
            alert('Ocorreu um erro na busca do genero');
        }
    },

    async fetchSchoolings({commit}) {
        try {
            const {data} = await axios.get('/api/member/schoolings');
            commit(types.FETCH_SCHOOLINGS, { schoolings: data })
        }catch (e) {
            alert('Ocorreu um erro na busca da escolaridade');
        }
    },





};
