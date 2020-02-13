<template>
<div class="p-5">
  <v-card>
    <session-enderecos mapa height-map="200px"/>
  </v-card>
</div>
</template>

<style>

</style>
<script>
  import SessionEnderecos from '../../components/SessionEndereco'
  export default {
    components: { SessionEnderecos }
  }
</script>
