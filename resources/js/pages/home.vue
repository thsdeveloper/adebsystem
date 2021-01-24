<template>
  <v-container fluid>
    <v-row>
      <v-col>
        <h2>Últimos informativos:</h2>
        <v-form>
          <v-textarea v-model="form.titulo" outlined :counter="10" label="Escreva o informativo"
                      required></v-textarea>
        </v-form>
        <v-btn @click="inserirInformativo()">Inserir informativo</v-btn>
      </v-col>
    </v-row>
    <v-row>
      <v-card tile>
        <v-list-item v-for="item in results" :key="item.id">
          <v-list-item-content>
            <v-list-item-title>{{item.titulo}}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-card>
    </v-row>

  </v-container>
</template>

<script>
import firebase from '../firebaseConfig';

const db = firebase.firestore();

export default {
  middleware: 'auth',
  metaInfo() {
    return {title: this.$t('home')}
  },
  data() {
    return {
      results: [],
      form: {
        titulo: null
      }
    }
  },
  methods: {
    async inserirInformativo() {
      db.collection("informativos").add({titulo: this.form.titulo}).then(() => {
        console.log("Document successfully written!");
      }).catch((error) => {
        console.error("Error writing document: ", error);
      });
    },
    async readEmployees() {
      db.collection("informativos").get().then((querySnapshot) => {
        console.log(querySnapshot);
        querySnapshot.forEach((doc) => {
          this.results.push({
            id: doc.id,
            titulo: doc.data().titulo,
          });
          console.log(doc.id, " => ", doc.data());
        });
        // return employeesData
      })
        .catch((error) => {
          console.log("Error getting documents: ", error);
        });
    },

  },
  created() {

  },
  mounted() {
    this.readEmployees();
  }
}
</script>
