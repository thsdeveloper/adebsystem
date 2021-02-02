<template>
  <v-container>
    <v-row>
      <v-col>
        <h1> Olá, {{ form.name }}</h1>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
          <v-text-field :label="$t('name')" outlined required v-model="form.name"
                        :class="{ 'is-invalid': form.errors.has('name') }" name="name"></v-text-field>
          <has-error :form="form" field="name"/>
          <v-text-field :label="$t('email')" outlined required v-model="form.email"
                        :class="{ 'is-invalid': form.errors.has('email') }" name="email"></v-text-field>
          <has-error :form="form" field="name"/>
          <v-btn color="blue" dark flat type="submit">Atualizar</v-btn>
        </form>
      </v-col>
      <v-col>
        <small>*Só você pode ver suas configurações. O AdebSystem tem o compromisso de proteger sua privacidade e
          segurança. </small>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-btn slot="activator" flat to="/settings/password">Alterar senha</v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Form from 'vform'
import {mapGetters} from 'vuex'
import {VclFacebook, VclInstagram, VueContentLoading} from 'vue-content-loading';

export default {
  components: {
    VueContentLoading
  },
  scrollToTop: false,

  metaInfo() {
    return {title: this.$t('settings')}
  },

  data: () => ({
    form: new Form({
      name: '',
      email: ''
    }),

    dialogUpdateInfo: false,
  }),

  computed: {
    ...mapGetters({user: 'auth/user'})
  },

  created() {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },
  mounted() {

  },

  methods: {
    async update() {
      const {data} = await this.form.patch('/api/settings/profile');

      this.$store.dispatch('auth/updateUser', {user: data})
    }
  }
}
</script>
