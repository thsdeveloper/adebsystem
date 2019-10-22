<template>
  <div>


    <v-bottom-nav :value="true" :active.sync="e1" absolute color="transparent">
      <v-btn flat color="teal" value="recent">
        <span>Recent</span>
        <v-icon>history</v-icon>
      </v-btn>
      <v-btn flat color="teal" value="favorites">
        <span>Favorites</span>
        <v-icon>favorite</v-icon>
      </v-btn>
      <v-btn flat color="teal" value="nearby">
        <span>Nearby</span>
        <v-icon>place</v-icon>
      </v-btn>
    </v-bottom-nav>
  </div>
</template>

<script>
    export default {
        middleware: ['auth', 'permission'],
        data () {
            return {
                e1: 'recent'
            }
        }
    }
</script>

<style>
  .settings-card .card-body {
    padding: 0;
  }
</style>
