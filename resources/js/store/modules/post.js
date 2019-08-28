import * as types from '../mutation-types'
import axios from "axios";

// state
export const state = {
    posts: null,
};

// getters
export const getters = {
    posts: state => state.posts,
};

// mutations
export const mutations = {
    [types.FETCH_POSTS] (state, { posts }) {
        state.posts = posts
    },

    [types.CREATE_POST] (state, { post }) {
        state.posts.unshift(post)
    }
};

// actions
export const actions = {
    async fetchPosts({commit}) {
        try {
            const {data} = await axios.get('/api/posts');
            commit(types.FETCH_POSTS, { posts: data })

        }catch (e) {

        }
    },
    async createPost({commit}, form){
        try {
            const {data} = await axios.post('/api/post/create', {text: form.text, url: form.urlImage});
            commit(types.CREATE_POST, { post: data })
        }catch (e) {

        }
    }
};