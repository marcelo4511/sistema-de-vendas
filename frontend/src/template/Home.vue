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

   
     <line-chart
        v-if="loaded"
        :chartdata="chartdata"
      />

       <pie-chart
        v-if="loaded"
        :chartdata="teste"
       />
       
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
      <td>R$ {{f.total}},00</td>
    
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
import '../config/filterData'
import moment from 'moment'
export default {
    
name: 'LineChartContainer',
  components: { LineChart,PieChart },
    data() {
      return{

        loaded: false,
        chartdata: null,
        teste:null,
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
     /*await axios
      .get("http://localhost:8000/api/sales")
      .then(res => {
        this.abc = res.data
        console.log(this.abc.map((element) => {
         return element.total
        }))
        this.loaded = true;
        this.chartdata = {
         // labels: [`total da venda dia ${res.data[0].dataVenda}`, `Female${res.data[1].dataVenda}`,'dsf'],
          labels: this.abc.map(element => {
            return moment(element.dataVenda).format('DD/MM/YYYY')
          }),
             backgroundColor: ['#C28535', '#8AAE56', '#B66C46'],
          datasets: [
            {
              label: "Vendas R$",
              data: this.abc.map(element => {
                return element.total 
              }),

               
          backgroundColor: ['#C28535','#939', '#8AAE56', '#B66C46'],
          //data: [this.one, this.two, this.three]
            }
          ]
        };
       
      })
      .catch(err => {
        console.log(err);
      });*/

    await axios
      .get("http://localhost:8000/api/graficomensal")
      .then(res => {
        this.abc = res.data
        console.log(this.abc.map((element) => {
         return element.total
        }))
        this.loaded = true;
        this.teste = {
         // labels: [`total da venda dia ${res.data[0].dataVenda}`, `Female${res.data[1].dataVenda}`,'dsf'],
          labels: this.abc.map(element => {
            return element.mes
          }),
             backgroundColor: ['#939'],
          datasets: [
            {
              label: "Vendas R$",
              data: this.abc.map(element => {
                return element.total 
              }),

               
          backgroundColor: ['#C28535','#939', '#8AAE56', '#B66C46'],
          //data: [this.one, this.two, this.three]
            }
          ]
        };
       
      })

     this.f()
      this.relatorioAnual()
  },
  methods:{
    relatorioAnual(){
       axios.get("http://localhost:8000/api/graficoanual").then(res => {
         this.faturamento = res.data
         console.log(res.data)
       })
    },

    async f(){
        this.loaded = false;
       await axios
      .get("http://localhost:8000/api/sales")
      .then(res => {
        this.abc = res.data
        console.log(this.abc.map((element) => {
         return element.total
        }))
        this.loaded = true;
        this.chartdata = {
         // labels: [`total da venda dia ${res.data[0].dataVenda}`, `Female${res.data[1].dataVenda}`,'dsf'],
          labels: this.abc.map(element => {
           return moment(element.dataVenda).format('DD/MM/YYYY')
          }),
             backgroundColor: ['#939'],
          datasets: [
            {
              label: "Vendas R$",
              data: this.abc.map(element => {
                return element.total 
              }),

               
          backgroundColor: ['#C28535','#939', '#8AAE56', '#B66C46'],
          //data: [this.one, this.two, this.three]
            }
          ]
        };
       
      })
    }
  },
}
</script>

<style>
  div.abc{
    width: 599px;
    display: flex;
    flex-direction: row;
    justify-content:center;
    align-items: center;
    margin-top: 13px;
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
</style>