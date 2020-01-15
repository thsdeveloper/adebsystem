// register the plugin on vue
import Vue from 'vue';
import Toasted from 'vue-toasted';
Vue.use(Toasted, {
  position: 'top-right',
  theme: 'bubble',
});
