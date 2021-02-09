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

              <v-flex>
                <v-text-field v-model="form.email" autofocus outlined label="Email:"
                              :rules="emailRules" placeholder="Digite o seu e-mail cadastrado"/>
              </v-flex>

              <v-flex>
                <v-text-field v-model="form.password" outlined label="Senha:" :rules="rulesSenha" type="password" />
              </v-flex>

              <!-- Remember Me -->
              <v-switch v-model="remember" name="remember" label="Lembrar dados de acesso"
                        messages="Marque este opção para lembrar os dados de acesso.">
              </v-switch>

              <v-btn class="btnLogin" color="primary" block large rounded @click="login" :loading="form.busy" :disabled="!valid">
                {{ $t('login') }}
              </v-btn>

            </v-card-text>
            <v-card-actions>
              <v-btn color="primary" text :to="{ name: 'password.request' }">{{ $t('forgot_password') }}</v-btn>
              <v-btn color="primary" text to="/cadastrar">Cadastrar novo membro</v-btn>
            </v-card-actions>
          </v-form>


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
  components: {
  },

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

        if(data){
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
