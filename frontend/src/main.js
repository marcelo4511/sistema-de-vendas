import Vue from 'vue'

import App from './App'
import store from './store'
import router from './config/routes'
import ChartKick from 'vue-chartkick'
import Chart from 'chart.js'
import VueNoty from 'vuejs-noty-fa';
import money from 'v-money'
import auth from './config/auth'
import axios from 'axios'
import VeeValidate, {
  Validator
} from "vee-validate";
import pt_BR from 'vee-validate/dist/locale/pt_BR'
import '@/config/apexcharts'
import './config/Api'
import './config/filterData'
import './config/messages'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'popper.js'
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'
import 'font-awesome/css/font-awesome.css'

Vue.use(money, {precision: 2})
//Vue.use(VueApexCharts)
Vue.use(VeeValidate);
Validator.localize('pt_BR', pt_BR);

Vue.use(ChartKick.use(Chart))
Vue.config.productionTip = false
Vue.use(VueNoty, {
  timeout: 4000,
  progressBar: true,
  layout: 'topRight',
  icon: {
    success: ['fa','check-circle'], 
    info: ['fa', 'times-circle'],
    error: ['fa', 'times-circle'],
  }
});

new Vue({
  render: h => h(App),
  store,
  auth,
  router,
  //VueApexCharts,
    created () {
      const userInfo = localStorage.getItem('user')
      if (userInfo) {
        const userData = JSON.parse(userInfo)
        this.$store.commit('User/setUserData', userData)
      }
      axios.interceptors.response.use(
        response => response,
        error => {
          if (error.response.status === 403) {
            this.$store.dispatch('User/logout')
          }

          if(error.response.status === 401) {
            this.$store.dispatch('User/logout')
          }
          return Promise.reject(error)
        }
      )
    },
}).$mount('#app')
