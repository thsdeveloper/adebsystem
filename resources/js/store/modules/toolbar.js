import * as types from '../mutation-types'

export const state = {
    tabsVisible: false,
    menusTabs: []
};

// getters
export const getters = {
    tabsVisible: state => state.tabsVisible,
    menusTabs: state => state.menusTabs,
};

// mutations
export const mutations = {

    [types.VISIBLE_TABS] (state, {payload}) {
        console.log('MUTATION TOOLBAR: ', payload.menusTabs);
        state.tabsVisible = payload.tabsVisible;
        state.menusTabs = payload.menusTabs;
    },

};

// actions
export const actions = {
    tabsVisible({commit, dispatch}, payload){
        console.log(payload);
        commit(types.VISIBLE_TABS, { payload })
    },
};
