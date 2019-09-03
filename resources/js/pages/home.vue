<template>
  <div>
    <v-layout row wrap>
      <v-flex xs12 ms12 md12>
        <v-card color="blue-grey darken-2" class="white--text">
          <v-card-title primary-title>
            <div>
              <div class="headline">Bem vindo ao AdebSystem 1.0</div>
              <span>Os recursos deste sistema está em fase de implementação. Somente o módulo de cadastro de membro está em funcionamento</span>
            </div>
          </v-card-title>
        </v-card>
      </v-flex>
      <v-flex xs12 ms12 md12>
        <v-carousel>
          <v-carousel-item v-for="(item,i) in items" :src="item.src" :key="i"></v-carousel-item>
        </v-carousel>
      </v-flex>
    </v-layout>
    <v-layout>
      <v-flex>
        <v-layout>
          <post-time-line/>
        </v-layout>
      </v-flex>
    </v-layout>
  </div>
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
                items: [
                    {src: 'https://adeb.com.br/media/k2/items/cache/6648f45035a47efdafeee4d3f3f056e4_XL.jpg'},
                    {src: 'https://adeb.com.br/media/k2/items/cache/ca518bf183c339c376b4bdc5c275df01_XL.jpg'},
                    {src: 'https://adeb.com.br/media/k2/items/cache/dd9b4b0a80eff28fc65a7f105431f022_XL.jpg'},
                ],
            }
        },
    }
</script>
<style scoped>

</style>
