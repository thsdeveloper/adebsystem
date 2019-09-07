import * as types from '../mutation-types'

export const state = {
  files: [],
};

// getters
export const getters = {
  files: state => state.files,
};

// mutations
export const mutations = {

  [types.UPDATE_FILES](state, files) {
        state.files = files
  },

};

// actions
export const actions = {
  updateFiles({commit}, files) {
    commit(types.UPDATE_FILES, files)
  },
};
