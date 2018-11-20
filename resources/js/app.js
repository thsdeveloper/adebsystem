import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import InstantSearch from 'vue-instantsearch';
import VueRecyclist from 'vue-recyclist'


Vue.use(Vuetify);
Vue.use(InstantSearch);
Vue.use(VueRecyclist);

import '~/plugins'
import '~/components'

Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
    i18n,
    store,
    router,
    ...App
});
