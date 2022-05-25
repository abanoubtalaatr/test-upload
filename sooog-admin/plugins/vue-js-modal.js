// plugins/vue-js-modal.js
// https://euvl.github.io/vue-js-modal/Installation.html#ssr
import Vue from 'vue'
import VModal from 'vue-js-modal/dist/ssr.nocss'

import 'vue-js-modal/dist/styles.css'

Vue.use(VModal)


export default function(_, inject) {
  inject('modal', VModal)
}
