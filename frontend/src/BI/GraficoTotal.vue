<template>
<div v-if="loading" class="text-center">
  <div><span><i  class="mt-2 spinner-border spinner-border spinner text-primary"></i></span></div>
</div>
<apexchart v-else width="100%" type="bar" :height="height" :options="options" :series="series"></apexchart>
</template>

<script>
import {API_BASE_URL} from '../config/Api'
import moment from 'moment'
import axios from 'axios'
export default {

  data: function() {
    return {
      loading : false,
       payload: {
        mes: moment().month(),
        ano: moment().year(),
        clients:0,
        vendedor:0
      },
      height:220,
      options: {
        colors: ['#990000','#0000FF'],
        title: {
          text: 'Total de Vendas e quantidade',
          align: 'left',
          margin: 10,
          offsetX: 0,
          offsetY: 20,
          floating: false,
          style: {
            fontSize: '14px',
            fontWeight: 'bold',
            color: '#263238',
          },
        },
        subtitle: {
          text: 'Por Vendedor',
          align: 'left',
          margin: 10,
          offsetX: 0,
          offsetY: 40,
          style: {
            fontSize: '12px',
            fontWeight: 'normal',
            color: '#9699a2',
          },
        },
        chart: {
          type: 'bar',
         
          toolbar: {
            show: true,
            tools: {
              download: true,
              selection: false,
              pan: false,
            
            },
          },
          zoom: {
            enabled: false,
          },
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '80%',
            
          },
        },
        dataLabels: {
              style: {
                fontSize: '12px',
                fontFamily: 'Helvetica, Arial, sans-serif',
                fontWeight: 'bold',
                colors: ['black'],  
              },              
              formatter: val => {
                return parseFloat(val).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
              },
            },
        grid: {
          borderColor: '#e7e7e7',
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5,
          },
        },
      
        markers: {
          size: 1,
        },
        xaxis: {
          categories: [],
           tickPlacement: 'between',
          labels: {
            rotate: 0,
            show: true,
            align: 'left',
            trim: true,
            hideOverlappingLabels: false,
          },
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return parseFloat(val).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
            },
          },
        },
      },
     series: [
       {
         name:'Total',
        data: []
      }, {
        name:'Quantidade',
       data: []      
       }
       ]
    }
  },
  created(){
    this.get();
    this.$root.$on('selecionar' ,(payload) => {
      this.payload.mes = payload.mes
      this.payload.ano = payload.ano
      this.payload.clients = payload.clients
      this.payload.vendedor = payload.vendedor
      this.get()
    }) 
  },
  methods:{
      get() {
        this.loading = true
        this.height = 220;
          axios.post(`${API_BASE_URL}/bi/grafico/quantidade/total`,{payload:this.payload}).then(res => {
            
                this.options.xaxis.categories = res.data.categories
            
                this.series[0].data = res.data.series

                this.series[1].data = res.data.seriesx
             
                this.loading = false
          }).then(() => {
            this.height = 219;
          })
      }
  }
}
</script>

<style>

</style>