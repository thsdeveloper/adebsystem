// register the plugin on vue
import Vue from 'vue';
import Toasted from 'vue-toasted';
Vue.use(Toasted, {
  position: 'bottom-center',
  theme: 'toasted-primary',
  icon: 'check',
  type: 'success'
});
