import Vue from 'vue'
import moment from 'moment';

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
    }
});

Vue.filter('formatDateTime',function(value) {
    if(value) {
        return moment(String(value)).format('DD/MM/YYYY H:m:s')
    }
})

Vue.filter('formatPrice',function(value) {
    if(value) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return 'R$' + ' ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }
})