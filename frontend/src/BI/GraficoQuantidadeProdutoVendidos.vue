<template>
<div v-if="loading" class="text-center">
  <div><span><i  class="mt-2 spinner-border spinner-border spinner text-primary"></i></span></div>
</div>
<apexchart v-else width="100%" type="bar" :height="height" :options="options" :series="series"></apexchart>
</template>

<script>
import axios from 'axios'
import moment from 'moment'
export default {

  data: function() {
    return {
      loading:false,
      height:220,
      payload: {
        mes: moment().month(),
        ano: moment().year(),
      },
      options: {
        colors: ['#800080'],
        title: {
          text: 'Quantidade de Produtos Vendidos',
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
          text: 'Por Produtos',
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
            columnWidth: '80%',
            dataLabels: {
              position: 'top',
              hideOverflowingLabels: true,
            },
          },
        },
        grid: {
          borderColor: '#e7e7e7',
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5,
          },
        },
        dataLabels: {
          style: {
            colors: ['#333'],
          },
          enabled: true,
          offsetY: -20,
          hideOverflowingLabels: false,
        },
        markers: {
          size: 1,
        },
        xaxis: {
          categories: [],
          labels: {
            rotate: 0,
            show: true,
            align: 'left',
            trim: true,
            hideOverlappingLabels: false,
          },
        },
        tooltip: {
          shared: true,
          intersect: false,
          y: {
          },
        },
      },
      series: []
    }
  },
  created(){
    this.get();
    this.$root.$on('selecionar' ,(payload) => {
      this.payload.mes = payload.mes
      this.payload.ano = payload.ano
      this.get()
    }) 
  },
  methods:{
      get() {
        this.loading = true
        this.height = 220;
          axios.post('http://localhost:8000/api/bi/grafico/quantidade/produtos/vendidos',{payload:this.payload}).then(res => {
              this.options.xaxis.categories = res.data.categories
              this.series = [{ 'name': 'Vendas','data': res.data.series }]
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