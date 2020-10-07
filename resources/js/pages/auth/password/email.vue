<template>
  <v-row justify="center">
    <v-col sm="8" md="8" lg="5" align-self="center">
      <v-card class="elevation-12">
        <v-form @submit.prevent="send" @keydown="form.onKeydown($event)">
          <v-toolbar dark color="primary">
            <v-toolbar-title>{{ $t('reset_password') }}</v-toolbar-title>
            <v-spacer></v-spacer>
          </v-toolbar>
          <v-card-text>
            <p>
              Olá, seja bem vindo!
            </p>
            <p>Para realizar a redefinição de senha você irá precisar do acesso ao seu e-mail cadastrado no sistema,
              insira abaixo e clique no botão <strong>"Redefinir Senha"</strong> para receber um e-mail com o passo a passo da sua redefinição.</p>

            <v-alert border="left" type="error" v-if="form.errors.has('login')">
              <has-error :form="form" field="login"/>
            </v-alert>

            <v-alert type="success" v-if="status">
              {{ status }}
            </v-alert>


            <v-flex>
              <v-text-field v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" name="email"
                            label="Email" type="email"></v-text-field>

              <v-alert border="left" type="error" v-if="form.errors.has('email')">
                <has-error :form="form" field="email"/>
              </v-alert>
            </v-flex>

            <!-- GitHub Login Button -->
            <login-with-github/>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <!--<v-btn color="primary" flat :to="{ name: 'password.request' }">{{ $t('forgot_password') }}</v-btn>-->
            <v-btn color="primary" type="submit" rounded large block :loading="form.busy">Redefinir senha</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-col>
  </v-row>


</template>

<script>
import Form from 'vform'

export default {
  middleware: 'guest',
  layout: 'welcomeApp',

  // metaInfo () {
  //     return { title: this.$t('reset_password') }
  // },

  data: () => ({
    status: '',
    form: new Form({
      email: ''
    })
  }),

  methods: {
    async send () {
      const { data } = await this.form.post('/api/password/email')

      this.status = data.status

      this.form.reset()
    }
  }
}
</script>
