import * as types from '../mutation-types'

export const state = {
    visible: false,
    text: null,
    timeout: 6000,
    multiline: false,
};

// getters
// export const getters = {
//     posts: state => state.posts,
// };

// mutations
export const mutations = {

    [types.SHOW_SNACK_BAR] (state,  payload) {
        state.text = payload.text
        state.multiline = (payload.text.length > 50) ? true : false

        if (payload.multiline) {
            state.multiline = payload.multiline
        }

        if (payload.timeout) {
            state.timeout = payload.timeout
        }

        state.visible = true
    },

    [types.CLOSE_SNACK_BAR] (state) {
        state.visible = false
        state.multiline = false
        state.timeout = 6000
        state.text = null
    },

};

// actions
export const actions = {
    showSnackbar({commit}, text){
        commit(types.SHOW_SNACK_BAR, { text })
    },

    closeSnackbar({commit}) {
        commit(types.CLOSE_SNACK_BAR)
    },
};
