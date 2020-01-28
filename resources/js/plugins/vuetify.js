import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'

Vue.use(Vuetify);

const opts = {
  iconfont: 'mdi',
  theme: {
    dark: false,
    // light: {
    //   primary: '#3f51b5',
    //   secondary: '#b0bec5',
    //   accent: '#8c9eff',
    //   error: '#b71c1c',
    // },
  }
}

export default new Vuetify(opts)
