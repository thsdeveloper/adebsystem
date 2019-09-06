<template>
  <v-row>
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
    <v-col>
      <post-time-line/>
    </v-col>
  </v-row>
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
            return {}
        },
    }
</script>
<style scoped>

</style>
