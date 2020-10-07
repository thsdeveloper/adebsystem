<template>
  <v-row justify="center">
    <v-col sm="8" md="8" lg="5" align-self="center">
      <v-card class="elevation-12">
        <form @submit.prevent="reset" @keydown="form.onKeydown($event)">
          <v-toolbar dark color="primary">
            <v-toolbar-title>Redefinição de Senha</v-toolbar-title>
            <v-spacer></v-spacer>
          </v-toolbar>

          <v-card-text>
            <v-alert type="success" v-if="status">
              {{ status }}
            </v-alert>
            <v-alert border="left" type="error" v-if="form.errors.has('email')">
              <has-error :form="form" field="email"/>
            </v-alert>

            <!-- Email -->
            <v-flex>
              <v-text-field v-model="form.email" disabled :class="{ 'is-invalid': form.errors.has('email') }"
                            class="form-control" type="email" name="email" label="Email" readonly></v-text-field>

            </v-flex>


            <!-- Password -->
            <v-flex>
              <v-text-field v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }"
                            class="form-control" label="Senha" type="password" name="password"></v-text-field>

            </v-flex>

            <!-- Password Confirmation -->
            <v-flex>
              <v-text-field v-model="form.password_confirmation"
                            :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control"
                            type="password" name="password_confirmation" label="Confirme a senha"></v-text-field>

              <v-alert border="left" type="error" v-if="form.errors.has('password_confirmation')">
                <has-error :form="form" field="password_confirmation"/>
              </v-alert>
            </v-flex>

            <v-alert border="left" type="error" v-if="form.errors.has('password')">
              <has-error :form="form" field="password"/>
            </v-alert>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" type="submit" rounded large block :loading="form.busy">Alterar senha</v-btn>
          </v-card-actions>
        </form>
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
      token: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  created () {
    this.form.email = this.$route.query.email
    this.form.token = this.$route.params.token
  },

  methods: {
    async reset () {
      const { data } = await this.form.post('/api/password/reset')

      this.status = data.status

      this.form.reset()
    }
  }
}
</script>
