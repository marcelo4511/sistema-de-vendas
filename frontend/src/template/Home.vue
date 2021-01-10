<template>
<div>
<h4 cabecalho="Produto">Home</h4>
<nav aria-label="breadcrumb mb-4">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
  </ol>
</nav>
  <div class="row painel">
    <div class="card text-white bg-primary ml-3 " style="width:300px;height:250px">
       <div class="card-header">
          <div class="row">
            <h5>Vendas <i class="fa fa-shopping-cart"></i></h5>
            <h5 style="margin-left:150px;">{{Sale}}</h5>
          </div>
        </div>
      </div>
      <div class="card text-white bg-secondary ml-3" style="width:300px;height:250px">
        <div class="card-header">
          <div class="row">
            <h5>Produtos <i class="fa fa-folder"></i></h5>
            <h5 style="margin-left:150px;">{{Product}}</h5>
          </div>
        </div>
    </div>
      <div class="card text-white bg-success ml-3" style="width:300px;height:250px">
         <div class="card-header">
          <div class="row">
            <h5>Clientes <i class="fa fa-user"></i></h5>
            <h5 style="margin-left:150px;">{{Client}}</h5>
          </div>
        </div>
      </div>
    </div>

  <div class="abc"><br>

    <div class="card border-0">
      <div class="card-body">
        <p class="card-title">Comissão dos vendedores </p>
          <line-chart v-if="loaded" :chartdata="chartdata"/>
      </div>
    </div>

    <div class="card .bg-info border-0">
      <div class="card-body">
        <p class="card-title">Vendas por mês</p>
          <pie-chart v-if="loaded" :chartdata="teste"/>
      </div>
    </div>

  </div>

<div class="abc"><br>
    
    <div class="card border-0">
      <div class="card-body">
        <p class="card-title">Desempenho de venda por produto </p>
      
        <bar-chart v-if="loaded" :chartdata="fff"/> 
      </div>
    </div>

    <div class="card border-0">
      <div class="card-body">
        <p class="card-title">Desempenho de venda por Vendedor</p>
       <teste-chart v-if="loaded" :chartdata="testando1"/> 
      </div>
    </div>
  </div>

        
        <h4>Faturamento anual</h4>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Ano</th>
              <th scope="col">Total das vendas</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(f,i) in faturamento" :key="i">
          
              <td>{{f.ano}}</td>
              <td>{{f.total}}</td>
            
            </tr>
          </tbody>
        </table>
      
</div>

</template>

<script>
import axios from 'axios'
import { mapGetters} from 'vuex'
import LineChart from './Linechart'
import PieChart from './PieChart'
import BarChart from './BarChart'
import TesteChart from './TesteChart'
import '../config/filterData'
import { } from "chartjs-plugin-datalabels";
export default {
    
name: 'LineChartContainer',
  components: { LineChart,PieChart,TesteChart,BarChart },
    data() {
      return{
        testando1:null,
        loaded: false,
        chartdata: null,
        teste:null,
        fff:null,
        faturamento:null
      }
  },
    
   created(){
    this.$store.dispatch('Client/getClient'),
    this.$store.dispatch('Sale/getSales'),
    this.$store.dispatch('Product/getProducts')
  },
  
    computed:{
        ...mapGetters({
            Client:'Client/Client',
            Product:'Product/Product',
            Sale:'Sale/Sale'
        }),
    },

      async mounted() {
      this.loaded = false;
     
    await axios.get("http://localhost:8000/api/graficomensal").then(res => {
        this.abc = res.data
        
        this.teste = {
          labels: this.abc.map(element => {
            return element.mes
          }),
         
          backgroundColor: ['#939'],
          datasets: [
            {
              label: "Vendas R$",
              data: this.abc.map(element => {
                return element.teste 
              }),

               
          backgroundColor: [ '#ADD8E6','#00BFFF',   '#00FF7F', '#ADFF2F'],
            }
          ],options: {
            plugins: {
              datalabels: {
                color: "white",
                textAlign: "center",
                font: {
                  weight: "bold",
                  size: 20
                }, labels: [
        {
          render: 'percentage',
          fontColor: ['green', 'white', 'red'],
          precision: 2,
        }
      ],
              }
            }
          }
        };
       
      })

      this.graficoComissao()
      this.relatorioAnual()
      this.testeteste()
      this.testando()
       //this.addPlugin(ChartDataLabels);
  },
  methods:{
    relatorioAnual(){
       axios.get("http://localhost:8000/api/graficoanual").then(res => {
         this.faturamento = res.data
         console.log(res.data)
       })
    },

    async graficoComissao(){
        this.loaded = false;
       await axios.get("http://localhost:8000/api/grafico").then(res => {
        this.grafico = res.data
       
        this.loaded = true;
        this.chartdata = {
         
          labels: this.grafico.map(element => {
           return element.name
          }),
             backgroundColor: ['#939'],
          datasets: [
            {
              label: "Vendas R$",
              data: this.grafico.map(element => {
                return element.comissao 
              }),

               
         backgroundColor: [   '#ADD8E6','#00BFFF',   '#00FF7F', '#ADFF2F'],
         
            }
          ],
          options: {
            plugins: {
              datalabels: {
                color: "black",
                textAlign: "center",
                font: {
                  weight: "bold",
                  size: 16
                }, labels: [
        {
          render: 'percentage',
          fontColor: ['green', 'white', 'red'],
          precision: 2,
        }
      ],
              }
            }
          }
        };
       
      })
    },
    async testeteste(){
        this.loaded = false;
       await axios.get("http://localhost:8000/api/teste2").then(res => {
        this.grafico = res.data
        
        this.loaded = false;
        this.fff = {

          labels: this.grafico.map(element => {
           return element.name
          }),
             backgroundColor: ['#939'],
          datasets: [
            {
              label: "Vendas R$",
              data: this.grafico.map(element => {
                return element.venda
              }),

               
          backgroundColor: [ '#ADD8E6','#00BFFF',   '#00FF7F', '#ADFF2F'],
        
            }
          ]
        };
       
      })
    },


    async testando(){
        this.loaded = false;
       await axios.get("http://localhost:8000/api/teste").then(res => {
        this.abc = res.data
        
        
        this.loaded = true;
        this.testando1 = {
         
          labels: this.abc.map(element => {
           return element.name
          }),
              backgroundColor: [ '#ADD8E6','#00BFFF',   '#00FF7F', '#ADFF2F'],
          datasets: [
            {
              label: "Quantidade de vendas",
              data: this.abc.map(element => {
                return element.qtd
              }),
            
               
          backgroundColor: [ '#ADD8E6','#00BFFF',   '#00FF7F', '#ADFF2F'],
            },{
            label: "Valor total das vendas R$",
              data: this.abc.map(element => {
                return element.total
              }),
             backgroundColor: [ '#ADD8E6','#00BFFF','#00FF7F', '#ADFF2F'],
            }
          ],
        };
       
      })
    }
  },
}
</script>

<style>
  div.abc{
    width: 640px;
    display: flex;
    flex-direction: row;
    justify-content:center;
    align-items: center;
    margin-top: 13px;
    margin-left: 100px;
  }

div.teste{
  width: 599px;
    display: flex;
    flex-direction: row;
    justify-content:center;
    align-items: center;
    margin-top: 200px;
    margin-left: 100px;
}
  div .painel{
    display: flex;
    flex-direction: column;
    justify-content:flex-start;
    align-items: center;
    height: 100px;
  }

  div.abc h4{
    color: black;
  }

  div .card{
    
    width: 600px;
    height: 360px;
    margin: 10px;
  }

  div .card p{
    color:gray;
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>