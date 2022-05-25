import Vue from 'vue'

const eventBus = new Vue()
// this helps WebStorm with autocompletion, otherwise it's not needed
Vue.prototype.$EventBus = eventBus
