import Vue from 'vue'

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import InstantSearch from 'vue-instantsearch';
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import 'dayspan-vuetify/dist/lib/dayspan-vuetify.min.css'

Vue.use(require('vue-moment'));

import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
// Init plugin
Vue.use(Loading);

Vue.use(Vuetify);
Vue.use(InstantSearch);

import '~/plugins'
import '~/components'

Vue.config.productionTip = true;
// Vue.config.devtools = true;
// Vue.config.performance = true;

/* eslint-disable no-new */
new Vue({
    i18n,
    store,
    router,
    ...App
});
