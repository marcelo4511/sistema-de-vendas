<template>
<div>
<h4 cabecalho="Produto">Home</h4>
<nav aria-label="breadcrumb mb-4">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
  </ol>
</nav>
  <div class="row cartinha">
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

  <div class="abc">
    <p>Desempenho  R$</p>
   
     <line-chart
      v-if="loaded"
      :chartdata="chartdata"
       />
      
  </div>
</div>

</template>

<script>
import axios from 'axios'
import { mapGetters} from 'vuex'
import LineChart from './chart'
//import axios from 'axios'
import '../config/filterData'
export default {
    
name: 'LineChartContainer',
  components: { LineChart },
    data() {
      return{

        loaded: false,
    chartdata: null
      }
  },
    
   created(){
    this.$store.dispatch('Category/setList'),
    this.$store.dispatch('Client/getClient'),
    this.$store.dispatch('Sale/getSales'),
    this.$store.dispatch('Product/getProducts')
  },
  
    computed:{
        ...mapGetters({
            Client:'Client/Client',
            totalCategory:'Category/totalCategory',
            Product:'Product/Product',
            Sale:'Sale/Sale'
        }),
    },

      async mounted() {
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
            return element.dataVenda
          }),
          datasets: [
            {
              label: "Vendas",
              data: this.abc.map(element => {
                return element.total
              }),

            
              borderWidth: 2
            }
          ]
        };
       
      })
      .catch(err => {
        console.log(err);
      });
      
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
  }

  div .cartinha{
    display: flex;
    flex-direction: column;
    justify-content:flex-start;
    align-items: center;
    height: 100px;
  }
</style>