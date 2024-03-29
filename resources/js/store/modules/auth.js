import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'
import swal from 'sweetalert2'

// state
export const state = {
  user: null,
  token: Cookies.get('token'),
  drawer: null,
  permissions: null
};

// getters
export const getters = {
  user: state => state.user,
  token: state => state.token,
  check: state => state.user !== null,
  drawer: state => state.drawer,
  permissions: state => state.permissions
};

// mutations
export const mutations = {
  [types.SAVE_TOKEN](state, {token, remember}) {
    state.token = token
    Cookies.set('token', token, {expires: remember ? 365 : null})
  },

  [types.TOGGLE_DRAWER](state) {
    state.drawer = !state.drawer
  },

  [types.FETCH_USER_SUCCESS](state, {user}) {
    state.user = user
  },

  [types.FETCH_USER_FAILURE](state) {
    state.token = null
    Cookies.remove('token')
  },

  [types.LOGOUT](state) {
    state.user = null
    state.token = null

    Cookies.remove('token')
  },

  [types.UPDATE_USER](state, {user}) {
    state.user = user
  },

  [types.PERMISSIONS](state, {permissions}) {
    state.permissions = permissions
  }
};

// actions
export const actions = {
  async login({commit}, form){
    try {
      const {data} = await axios.post('/api/login', form).catch(error => {
        console.error(error.response.data.errors.email[0])
        swal({
          type: 'error',
          title: 'Ops! Acorreu algum erro!',
          text: error.response.data.errors.email[0],
        })
      });
      if(data){
        return data;
      }
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  saveToken({commit, dispatch}, payload) {
    commit(types.SAVE_TOKEN, payload)
  },

  async fetchUser({commit}) {
    try {
      const {data} = await axios.get('/api/user');

      commit(types.FETCH_USER_SUCCESS, {user: data});
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  async permissions({commit}) {
    try {
      const {data} = await axios.get('/api/get-permissions');
      commit(types.PERMISSIONS, {permissions: data});
    } catch (e) {
      // commit(types.FETCH_USER_FAILURE)
    }
  },

  updateUser({commit}, payload) {
    commit(types.UPDATE_USER, payload)
  },

  toggleDrawer({commit}) {
    commit(types.TOGGLE_DRAWER)
  },

  async logout({commit}) {
    try {
      await axios.post('/api/logout')
    } catch (e) {
    }

    commit(types.LOGOUT)
  },

  async fetchOauthUrl(ctx, {provider}) {
    const {data} = await axios.post(`/api/oauth/${provider}`);

    return data.url
  }
};
