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
                <v-row>
                  <v-col cols="12" sm="12" md="12">
                    <v-radio-group v-model="form.tipo" row :rules="rulesObrigatorio">
                      <v-radio label="Publicação" value="publicacao"></v-radio>
                      <v-radio label="Artigo" value="artigo"></v-radio>
                      <v-radio label="Evento" value="evento"></v-radio>
                    </v-radio-group>
                  </v-col>
                  <v-col cols="12" sm="12" md="12" v-model="form.titulo" :rules="rulesObrigatorio">
                    <v-text-field label="Título da publicação" outlined></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="12" md="12" v-model="form.conteudo" :rules="rulesObrigatorio">
                    <vue-editor v-if="form.tipo === 'artigo'" v-model="form.conteudo"/>
                    <v-textarea v-else label="O que está pensando?"
                                hint="Escreva suas informações referente a publicação aqui" outlined></v-textarea>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-btn fab dark small color="indigo">
                      <v-icon dark>add_photo_alternate</v-icon>
                    </v-btn>
                    <v-btn fab dark small color="indigo">
                      <v-icon dark>movie_creation</v-icon>
                    </v-btn>
                    <v-btn fab dark small color="indigo">
                      <v-icon dark>attachment</v-icon>
                    </v-btn>
                  </v-col>
                </v-row>
                <v-btn dark text @click="publicar()">
                  Publicar
                </v-btn>
              </v-form>

            </v-container>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-row>
  </div>
</template>

<script>
import {VueEditor} from "vue2-editor";

export default {
  name: "CreatePost",
  components: {
    VueEditor
  },
  data() {
    return {
      dialog: false,
      valid: false,

      form: {
        tipo: 'publicacao',
        titulo: null,
        conteudo: null,
        dataPublicacao: null,
        dataEvento: null,
      },

      rulesObrigatorio: [
        v => !!v || 'O campo é obrigatório',
      ],
    }
  },
  methods: {
    publicar() {
      if (this.$refs.form.validate()) {
        alert('opa esta valido')
        let loader = this.$loading.show();
        this.$store.dispatch('post/criarPublicacao', this.form).then(res => {
          loader.hide();
        });
      }
    },
  },
}
</script>
