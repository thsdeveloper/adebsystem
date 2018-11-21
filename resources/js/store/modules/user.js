import * as types from '../mutation-types'
import axios from "axios";

// state
export const state = {
    userSelected: null,

}

// getters
export const getters = {

}

// mutations
export const mutations = {
    [types.FETCH_USER] (state, { userId }) {
        state.userSelected = userId
    }
}

// actions
export const actions = {
    async fetchUser({ commit }, { userId }) {
        console.log(commit, userId);
        try {
            const {data} = await axios.get('/api/userFind', userId);
            commit(types.FETCH_USER, { userSelected: data })
        }catch (e) {
            commit(types.FETCH_USER_FAILURE)
        }
    }
}
