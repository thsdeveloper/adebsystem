<template>
  <v-container fluid>

    <v-row>
      <post-time-line></post-time-line>
    </v-row>

  </v-container>
</template>

<script>

import PostTimeLine from "../components/PostTimeLine";

export default {
  components: {PostTimeLine},
  middleware: 'auth',
  metaInfo() {
    return {title: this.$t('home')}
  },
  data() {
    return {
      // results: [],
      // form: {
      //   titulo: null
      // }
    }
  },
  methods: {
    // async inserirInformativo() {
    //   db.collection("informativos").add({titulo: this.form.titulo}).then(() => {
    //     console.log("Document successfully written!");
    //   }).catch((error) => {
    //     console.error("Error writing document: ", error);
    //   });
    // },
    // async readEmployees() {
    //   db.collection("informativos").get().then((querySnapshot) => {
    //     console.log(querySnapshot);
    //     querySnapshot.forEach((doc) => {
    //       this.results.push({
    //         id: doc.id,
    //         titulo: doc.data().titulo,
    //       });
    //       console.log(doc.id, " => ", doc.data());
    //     });
    //     // return employeesData
    //   })
    //     .catch((error) => {
    //       console.log("Error getting documents: ", error);
    //     });
    // },

  },
  created() {

  },
  mounted() {
    // this.readEmployees();
  }
}
</script>
