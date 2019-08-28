<template>
  <v-layout wrap>
    <v-flex xs12 class="mb-3">
      <v-sheet height="500">
        <v-calendar ref="calendar" v-model="start" :type="type" :end="end" color="primary"></v-calendar>
      </v-sheet>
    </v-flex>

    <v-flex sm4 xs12 class="text-sm-left text-xs-center">
      <v-btn @click="$refs.calendar.prev()">
        <v-icon dark left>keyboard_arrow_left</v-icon>Prev
      </v-btn>
    </v-flex>
    <v-flex sm4 xs12 class="text-xs-center">
      <v-select v-model="type" :items="typeOptions" label="Type"></v-select>
    </v-flex>
    <v-flex sm4 xs12 class="text-sm-right text-xs-center">
      <v-btn @click="$refs.calendar.next()">
        Next
        <v-icon right dark>keyboard_arrow_right</v-icon>
      </v-btn>
    </v-flex>
  </v-layout>
</template>
<script>
export default {
  name: "AgendarGeral",
  middleware: ["auth", "admin"],
  components: {},
  data: () => ({
    type: "month",
    start: "2019-01-01",
    end: "2019-01-06",
    typeOptions: [
      { text: "Day", value: "day" },
      { text: "4 Day", value: "4day" },
      { text: "Week", value: "week" },
      { text: "Month", value: "month" },
      { text: "Custom Daily", value: "custom-daily" },
      { text: "Custom Weekly", value: "custom-weekly" }
    ]
  }),
  mounted() {},
  methods: {},
  computed: {
    // ...mapGetters({users: 'auth/users'})
  },
  created() {},
  metaInfo() {
    return { title: "Agenda Geral da Igreja" };
  }
};
</script>
<style scoped>
body,
html,
#app,
#dayspan {
  font-family: Roboto, sans-serif !important;
  width: 100%;
  height: 100%;
}
.v-btn--flat,
.v-text-field--solo .v-input__slot {
  background-color: #f5f5f5 !important;
  margin-bottom: 8px !important;
}
</style>
