<template>
<div>
  <apexchart width="100%" type="bar" :height="height" :options="options" :series="series"></apexchart>
</div>
</template>

<script>
import axios from 'axios'
export default {

  data: function() {
    return {
      height:220,
      options: {
        colors: ['#FFFF00'],
        title: {
          text: 'Total de vendas (Mês)',
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
          formatter: function (val) {
            return parseFloat(val).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
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
          y: {
            formatter: function (val) {
              return parseFloat(val).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
            },
          },
        },
      },
      series: [{
          data:[]
      }]
    }
  },
  created(){
      this.get()
  },methods:{
      get() {
        this.height = 220;
          axios.get('http://localhost:8000/api/bi/grafico/mensal').then(res => {
              this.options.xaxis.categories = res.data.categories
              this.series = [{ 'name': 'Vendas','data': res.data.series }]
          }).then(() => {
            this.height = 219;
          })
      }
  }
}
</script>

<style>

</style>