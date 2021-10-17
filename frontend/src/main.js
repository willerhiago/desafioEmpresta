import Vue from 'vue'
import './plugins/bootstrap-vue'
import App from './App.vue'
import router from './router'
import money from 'v-money'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

Vue.component('v-select', vSelect)

Vue.use(money, {
  decimal: ',',
  thousands: '.',
  prefix: 'R$ ',
  precision: 2,
  masked: false /* doesn't work with directive */
})

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
