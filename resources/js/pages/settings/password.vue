<template>
    <div>
        <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
            <v-img src="https://www.gstatic.com/identity/boq/accountsettingsmobile/securitycheckup_scene_green_632x224_2dfcc26da3020a780f78a297352a3d39.png" height="125px" contain></v-img>
        </v-flex>
        <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
            <p class="display-1">Segurança</p>
        </v-flex>
        <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
            <p class="subheading">Configurações e recomendações para ajudar você a manter sua conta segura</p>
        </v-flex>
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg6 offset-lg3>
                <form @submit.prevent="update" @keydown="form.onKeydown($event)">
                    <alert-success :form="form" :message="$t('password_updated')"/>

                    <v-flex xs12 sm12 md12>
                        <v-text-field :label="$t('new_password')" required v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" name="password" type="password"></v-text-field>
                        <has-error :form="form" field="password"/>
                    </v-flex>

                    <v-flex xs12 sm12 md12>
                        <v-text-field :label="$t('confirm_password')" required v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" name="password_confirmation" type="password"></v-text-field>
                        <has-error :form="form" field="password_confirmation"/>
                    </v-flex>
                    <v-button :loading="form.busy" type="success">{{ $t('update') }}</v-button>
                </form>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
import Form from 'vform'

export default {
  scrollToTop: true,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async update () {
      await this.form.patch('/api/settings/password');

      this.form.reset()
    }
  }
}
</script>
