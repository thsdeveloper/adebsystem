import firebase from 'firebase/app'
import 'firebase/firestore'
import 'firebase/storage'

// Get a Firestore instance
export const db = firebase.initializeApp({
    apiKey: "AIzaSyCBxVQ5xuffvJIxcw18OCC11vjn1-OX0rI",
    authDomain: "adebriacho.firebaseapp.com",
    databaseURL: "https://adebriacho.firebaseio.com",
    projectId: "adebriacho",
    storageBucket: "adebriacho.appspot.com",
    messagingSenderId: "899810145857",
    appId: "1:899810145857:web:0a2a687cad46ebb03878c0",
    measurementId: "G-XTYC40JH3K"
  })

// Export types that exists in Firestore
// This is not always necessary, but it's used in other examples
const { TimeStamp, GeoPoint } = firebase.firestore
export { TimeStamp, GeoPoint }

// if using Firebase JS SDK < 5.8.0
db.firestore().settings({ timestampsInSnapshots: true })
