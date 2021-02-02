// src/firebaseConfig.js
import firebase from "firebase";

// Your web app's Firebase configuration
let firebaseConfig = {
  apiKey: "AIzaSyCBxVQ5xuffvJIxcw18OCC11vjn1-OX0rI",
  authDomain: "adebriacho.firebaseapp.com",
  databaseURL: "https://adebriacho.firebaseio.com",
  projectId: "adebriacho",
  storageBucket: "adebriacho.appspot.com",
  messagingSenderId: "899810145857",
  appId: "1:899810145857:web:0a2a687cad46ebb03878c0",
  measurementId: "G-XTYC40JH3K"
};

// Initialize Firebase
export default firebase.initializeApp(firebaseConfig);
