import Vue from 'vue';
// need instance of vuetify, for example
import vuetify from '@/plugins/vuetify'

import VuetifyDialog from 'vuetify-dialog'
import 'vuetify-dialog/dist/vuetify-dialog.css'

Vue.use(VuetifyDialog, {
  context: {
    vuetify
  }
})
