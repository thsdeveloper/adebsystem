// import * as types from '../mutation-types'
import {firestoreAction, vuexfireMutations} from 'vuexfire'
import {db} from '../db'

// state
export const state = {
  posts: [],
};

// getters
export const getters = {
  posts: state => state.posts,
};

// actions
export const actions = {

  bindPosts: firestoreAction((context) => {
    // return the promise returned by `bindFirestoreRef`
    return context.bindFirestoreRef('posts', db.firestore().collection('posts').orderBy('dataPublicacao', 'desc'))
  }),

  criarPublicacao: firestoreAction((context, payload) => {
    console.log('payload: ', payload);

    return db.firestore().collection('posts').add(payload.form).then(res => {
      console.log('COLECTION RES', res);

      if(payload.image != null){
        context.dispatch('uploadImage', {image: payload.image, ref: res.id});
      }

    })
  }),

  like: firestoreAction((context, payload) => {
    return db.firestore().collection('posts').doc(payload.id).update({ likes: payload.likes+=1 });
  }),

  rating: firestoreAction((context, payload) => {
    const ratingSelecionado = payload.rating;
    console.log('Rating Atual:', ratingSelecionado);


    const avg = ratingSelecionado / 2;
    console.log(avg)


    return db.firestore().collection('posts').doc(payload.id).update({ rating: avg });
  }),

  async uploadImage({commit}, payload) {
    console.log('uploadImage', payload);

    //Define o nome de variaveis de image e reference;
    let image = payload.image;
    let reference = payload.ref;

    //Set a referência do arquivo no servidor
    let storageRef = db.storage().ref('posts/'+reference+'/' + image.name);

    //upload do arquivo no servidor
    let task = storageRef.put(image);

    task.on('state_changed',
      function progress(snapshot) {
        let percentage = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
        console.log('Percentual:', percentage);
      },
      function error(err) {
        console.error('complete upload: ', err);
      },
      function complete() {
        task.snapshot.ref.getDownloadURL().then(function (downloadURL) {
          console.log('File available at', downloadURL);

          db.firestore().collection('posts').doc(reference).update({
            urlImage: downloadURL,
          });

        })
      }
    );
  }

};
