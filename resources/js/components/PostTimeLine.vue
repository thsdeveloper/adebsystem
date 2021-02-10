<template>
  <div>
    <v-timeline align-top dense>
      <v-timeline-item v-for="(post, index) in posts" :key="post.id">
        <template v-slot:icon>
          <v-avatar>
            <img :src="post.user.photo_url">
          </v-avatar>
        </template>
        <v-card class="elevation-2" :loading="loading">
          <template slot="progress">
            <v-progress-linear color="deep-purple" height="5" indeterminate></v-progress-linear>
          </template>

          <v-card-title class="grey lighten-4">
            <div class="subtitle-2 full-width">{{ post.user.name }}</div>
            <div class="caption full-width">Data da publicação: {{ post.dataPublicacao.toDate() | DataCerta }}</div>
            <div>
              <v-rating color="warning" v-model="post.rating" dense hover size="18" @input="rating(post)"></v-rating>
            </div>
          </v-card-title>
          <v-card-title class="headline">
            {{ post.titulo }}
          </v-card-title>
          <v-card-text>
            {{ post.conteudo }}
          </v-card-text>
          <v-img v-if="post.urlImage != null" height="250" :src="post.urlImage"
                 lazy-src="https://lh3.googleusercontent.com/proxy/qkLJPcGOEPr2ztEC5XdmII7f-a1kor8avqKaHay77Zot6h_FPxL38260KvmENhC8gvcGPhcVgPySK-1_4p4MZI0T_3odxFRLNGuHzFExRatoXJBHoQ"></v-img>
          <v-card-actions>
            <v-chip color="blue" dark small v-if="post.likes > 0">{{ post.likes }}</v-chip>
            <v-btn color="primary" @click="curtir(post)" text>
              Curtir
            </v-btn>
            <v-spacer></v-spacer>

<!--            <ShareNetwork :popup="{width: 600, height: 600}"-->
<!--                          network="WhatsApp"-->
<!--                          url="https://www.adebriachofundo.com.br"-->
<!--                          :title="post.titulo"-->
<!--                          :description="post.conteudo"-->
<!--                          :quote="post.conteudo"-->
<!--                          hashtags="adebsystem">-->
<!--              <v-btn color="deep-purple lighten-2" text>WhatsApp</v-btn>-->
<!--            </ShareNetwork>-->
          </v-card-actions>
        </v-card>
      </v-timeline-item>
    </v-timeline>

    <div>
      <create-post/>
    </div>

  </div>
</template>

<script>
import {mapGetters} from 'vuex'
import CreatePost from "../components/CreatePost";
import VButton from "./Button";
import moment from 'moment'

export default {
  name: "PostTimeLine",
  components: {VButton, CreatePost},
  data() {
    return {
      loading: false,

    }
  },
  computed: {
    ...mapGetters({posts: 'post/posts'}),
  },
  methods: {
    curtir(post) {
      this.$store.dispatch('post/like', post);
    },
    rating(post){
      this.$store.dispatch('post/rating', post);
    }
  },
  created() {
    this.$store.dispatch('post/bindPosts');
  },
  filters: {
    DataCerta(val) {
      if (val) {
        return moment(val).format('DD/MM/YYYY HH:mm')
      }

    }
  }
}
</script>

<style scoped>
.v-card__title.title-card-posts .v-avatar {
  margin-right: 10px;
}

.full-width {
  width: 100%;
}
</style>
