<template>
  <div>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent fullscreen>
        <template v-slot:activator="{ on, attrs }">
          <v-btn dark fab fixed bottom right color="primary" v-bind="attrs" v-on="on">
            <v-icon>add</v-icon>
          </v-btn>
        </template>
        <v-card>
          <v-toolbar dark color="primary">
            <v-btn icon dark @click="dialog = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Criar publicação</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn dark text @click="publicar()">
                Publicar
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-card-text>
            <v-container>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-row class="p-5">
                  <v-col cols="12" sm="12" md="12">
                    <v-text-field v-model="form.titulo" label="Título da publicação" outlined
                                  :rules="rulesObrigatorio"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12" md="12">
                    <v-textarea v-model="form.conteudo" label="O que está pensando?" :rules="rulesObrigatorio"
                                hint="Escreva suas informações referente a publicação aqui" outlined></v-textarea>
                  </v-col>
                  <v-col>
                    <v-file-input counter accept="image/*" show-size small-chips truncate-length="50" placeholder="Escolha uma imagem para o post"
                    v-model="image" @change="previewImage"></v-file-input>
                    <v-img
                      v-if="imagePreviewURL"
                      :src="imagePreviewURL"
                      max-height="300"
                      max-width="317"
                    ></v-img>
                  </v-col>
                </v-row>
              </v-form>

            </v-container>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-row>
  </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
  name: "CreatePost",
  data() {
    return {
      documents: [],
      dialog: false,
      valid: false,

      image: null,
      imagePreviewURL: null,

      form: {
        titulo: null,
        dataPublicacao: new Date(),
        conteudo: null,
        user: {},
        urlImage: null,
        likes: 0,
        rating: 0,
      },

      rulesObrigatorio: [
        v => !!v || 'O campo é obrigatório',
      ],
    }
  },
  methods: {
    publicar() {
      if (this.$refs.form.validate()) {
        let loader = this.$loading.show();
        this.$store.dispatch('post/criarPublicacao', {form: this.form, image: this.image}).then(res => {
          loader.hide();
          this.dialog = false;
        }).catch(error => {
          console.error(error);
        });
      }
    },

    previewImage(event) {
      const file = event; // in case vuetify file input
      if (file) {
        this.imagePreviewURL = URL.createObjectURL(file);
        URL.revokeObjectURL(file); // free memory
      } else {
        this.imagePreviewURL =  null
      }
    },
  },
  computed: {
    ...mapGetters({
      usuario: 'auth/user',
    }),
  },
  created() {
    this.form.user = this.usuario;
  }
}
</script>
