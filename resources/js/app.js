import Vue from 'vue'

import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import vuetify  from '~/plugins/vuetify'
import App from '~/components/App'

import InstantSearch from 'vue-instantsearch';
Vue.use(InstantSearch);

import 'dayspan-vuetify/dist/lib/dayspan-vuetify.min.css'

Vue.use(require('vue-moment'));

import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
// Init plugin
Vue.use(Loading);

import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask);



import '~/plugins'
import '~/components'

Vue.config.productionTip = true;
// Vue.config.devtools = false;
// Vue.config.performance = true;

/* eslint-disable no-new */
new Vue({
  vuetify,
  i18n,
  store,
  router,
  ...App
});
