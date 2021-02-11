import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

Vue.use(Vuetify);

const opts = {
  icons: {
    iconfont: 'md',
  },
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
