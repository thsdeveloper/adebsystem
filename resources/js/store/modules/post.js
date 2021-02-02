import * as types from '../mutation-types'
import axios from "axios";
import firebase from '../firebaseConfig';
const db = firebase.firestore();

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
  [types.FETCH_POSTS](state, {posts}) {
    state.posts = posts
  },

  [types.CREATE_POST](state, {post}) {
    state.posts.unshift(post)
  }
};

// actions
export const actions = {
  async fetchPosts({commit}) {
    try {
      const {data} = await axios.get('/api/posts');
      commit(types.FETCH_POSTS, {posts: data})

    } catch (e) {

    }
  },
  async criarPublicacao({commit}, publicacao) {
    try {
      const {data} = await db.collection("informativos").add(publicacao).then(() => {
        console.log("Document successfully written!");
      }).catch((error) => {
        console.error("Error writing document: ", error);
      });
      if(data){
        console.log("Document successfully written!");
      }
      commit(types.CREATE_POST, {post: data})
    } catch (e) {
      console.error("Error writing document: ", e);
    }

  }

};
