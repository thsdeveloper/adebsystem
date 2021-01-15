<template>
  <div>
    <v-row justify="center">
      <v-col sm="8" md="8" lg="5" align-self="center">
        <v-card class="elevation-12">
          <v-form @submit.prevent="login" @keydown="form.onKeydown($event)">
            <v-toolbar dark color="primary">
              <v-toolbar-title>AdebSystem 1.0</v-toolbar-title>
              <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>

              <v-flex>
                <v-text-field v-model="form.login"
                              :error="form.errors.has('login')"
                              :class="{ 'is-invalid': form.errors.has('login') }"
                              name="login"
                              :label="$t('Email ou CPF')"
                              type="text"
                              autofocus>
                </v-text-field>
                <v-alert border="left" type="error" v-if="form.errors.has('login')">
                  <has-error :form="form" field="login"/>
                </v-alert>
              </v-flex>

              <v-flex>
                <v-text-field
                  :error="form.errors.has('password')"
                  v-model="form.password"
                  name="password"
                  :label="$t('password')"
                  type="password">
                </v-text-field>
                <v-alert border="left" type="error" v-if="form.errors.has('password')">
                  <has-error :form="form" field="password"/>
                </v-alert>

              </v-flex>

              <!-- Remember Me -->
              <v-switch v-model="remember" name="remember" label="Lembrar dados de acesso"
                        messages="Marque este opção para lembrar os dados de acesso.">
              </v-switch>

              <!-- GitHub Login Button -->
              <login-with-github/>

              <v-btn class="btnLogin" color="primary" block large rounded type="submit" :loading="form.busy">
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
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'
import swal from 'sweetalert2'

export default {
  layout: 'welcomeApp',
  middleware: 'guest',
  metaInfo () {
    return { title: this.$t('login') }
  },
  components: {
    LoginWithGithub
  },

  // metaInfo () {
  //     return { title: this.$t('login') }
  // },

  data: () => ({
    form: new Form({
      login: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login () {
      // Submit the form.
      const { data } = await this.form.post('/api/login').catch(error => {
        swal({
          type: 'error',
          title: 'Ops! Acorreu algum erro!',
          text: error.response.data.errors.email[0],
        })
      })

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Busca as permissões do usuario logado
      await this.$store.dispatch('auth/permissions')

      // Redirect home.
      this.$router.push({ name: 'home' })

    }
  },
}
</script>
