<template>
  <div>
    <v-row justify="center">
      <v-col sm="8" md="8" lg="5" align-self="center">
        <v-card class="elevation-12">
          <v-form ref="form" v-model="valid" lazy-validation @keydown="form.onKeydown($event)">
            <v-toolbar dark color="primary">
              <v-toolbar-title>AdebSystem 1.2.5</v-toolbar-title>
              <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>
              <v-row>
                <v-col cols="12">
                  <v-text-field v-model="form.email" autofocus outlined label="Email:"
                                :rules="emailRules" placeholder="Digite o seu e-mail cadastrado"/>
                </v-col>
                <v-col cols="12">
                  <v-text-field v-model="form.password" outlined label="Senha:" :rules="rulesSenha" type="password"/>
                </v-col>
                <v-col cols="12">
                  <v-btn class="btnLogin" color="primary" block large rounded @click="login" :loading="form.busy"
                         :disabled="!valid">
                    {{ $t('login') }}
                  </v-btn>
                </v-col>
              </v-row>
              <v-row class="pt-4">
                 <v-col>
                   <v-btn color="primary" block outlined :to="{ name: 'password.request' }">
                     <v-icon left color="red">password</v-icon> Esqueceu a senha?</v-btn>
                 </v-col>
                 <v-col>
                   <v-btn color="primary" block outlined to="/cadastrar">Cadastrar novo membro</v-btn>
                 </v-col>
              </v-row>

            </v-card-text>
          </v-form>

          <v-container>
            <v-row>
              <v-col>
                <div class="caption text-center">
                  De acordo com a Lei Geral de Proteção de Dados Pessoais (LGPD), todas as informações cadastrais e
                  dados inseridos no <strong>AdebSystem</strong> serão mantidos estritamente confidenciais e protegidos
                  em servidores de alta segurança, e jamais serão usados para outros fins nem compartilhados com
                  terceiros.
                </div>
              </v-col>
            </v-row>
          </v-container>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>
<style>
.btnLogin {
  margin-top: 20px;
}
</style>
<script>
import swal from 'sweetalert2'

export default {
  layout: 'welcomeApp',
  middleware: 'guest',
  metaInfo() {
    return {title: this.$t('login')}
  },
  components: {},

  data: () => ({
    valid: false,
    form: {
      email: '',
      password: ''
    },
    remember: false,

    rulesSenha: [
      v => !!v || 'O campo senha é obrigatório',
    ],
    emailRules: [
      v => !!v || 'Email é obrigatório',
      v => /.+@.+/.test(v) || 'E-mail deve ser válido'
    ],

  }),

  methods: {
    async login() {
      if (this.$refs.form.validate()) {
        let loader = this.$loading.show()
        const data = await this.$store.dispatch('auth/login', this.form);

        if (data) {
          // Save the token.
          await this.$store.dispatch('auth/saveToken', {token: data.token, remember: this.remember})

          //Busca o usuário logado.
          await this.$store.dispatch('auth/fetchUser')

          // Busca as permissões do usuario logado
          await this.$store.dispatch('auth/permissions')

          // Redirect home.
          await this.$router.push({name: 'home'})
          loader.hide()
        }
        loader.hide()
      }
    }
  },
}
</script>
