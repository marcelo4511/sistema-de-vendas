import Vue from 'vue'
import App from './App'
import store from './store'
import router from './config/routes'
import ChartKick from 'vue-chartkick'
import Chart from 'chart.js'
import VueNoty from 'vuejs-noty-fa';
import money from 'v-money'

import './config/filterData'
import './config/messages'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'popper.js'

import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'

import 'font-awesome/css/font-awesome.css'

Vue.use(money, {precision: 2})
Vue.use(ChartKick.use(Chart))
Vue.config.productionTip = false

Vue.use(VueNoty, {
  timeout: 4000,
  progressBar: true,
  layout: 'topRight',
  icon: {
    success: ['fa','check-circle'], 
    info: ['fa', 'times-circle'],
  }
});

new Vue({
  render: h => h(App),
  store,
  router,
}).$mount('#app')
