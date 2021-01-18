<template>
  <v-container fluid>
    <v-row>
      <v-col>
        <h2>Informativos</h2>
      </v-col>
    </v-row>



    <v-row>
      <v-col>
        <v-card>
          <v-card-title>Crescimento nos últimos anos</v-card-title>
          <v-card-text>
            <apexchart type="bar" :options="options" :series="series"/>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col>
        <v-card color="#385F73" dark>
          <v-card-text class="white--text">
            <div class="headline mb-2">AdebSystem 1.0</div>
            Sistema Integrado de Gerenciamento da ADEB
          </v-card-text>

          <v-card-actions>
            <v-btn text>Contato</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

import PostTimeLine from '../components/PostTimeLine'
import GoogleMap from '../components/GoogleMapLoader'
import firebase from '../firebaseConfig';

const db = firebase.firestore();

export default {
  components: {GoogleMap, PostTimeLine},
  middleware: 'auth',
  metaInfo() {
    return {title: this.$t('home')}
  },
  data() {
    return {
      itemsRotas: [],
      options: {
        chart: {
          id: 'vuechart-example'
        },
        xaxis: {
          categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
        }
      },
      series: [{
        name: 'series-1',
        data: [30, 40, 45, 50, 49, 60, 70, 91]
      }]
    }
  },
  methods: {
    buscaNoticias() {
      db.collection("informativos").add({date: 'date', ne: 'name'}).then(() => {
        console.log("Document successfully written!");
      })
        .catch((error) => {
          console.error("Error writing document: ", error);
        });
    },
    async readEmployees() {
      let employeesData = [];
      db.collection("employees").get().then((querySnapshot) => {
          querySnapshot.forEach((doc) => {
            employeesData.push({
              id: doc.id,
              name: doc.data().name,
              date: doc.data().date,
            });
            console.log(doc.id, " => ", doc.data());
          });
          return employeesData
        })
        .catch((error) => {
          console.log("Error getting documents: ", error);
        });
    }
  },
  created() {
    this.$router.options.routes.forEach(route => {
      this.itemsRotas.push({
        name: route.name, path: route.path
      })
    })
  },
  mounted() {
    this.buscaNoticias();
  }
}
</script>
