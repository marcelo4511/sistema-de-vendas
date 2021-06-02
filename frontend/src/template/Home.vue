<template>
<div>
  <h4 >Home</h4>
  <nav aria-label="breadcrumb mb-2">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
    </ol>
  </nav>
  <div class="col-12 d-flex justify-content-between mb-2">
    <div class="card text-white bg-primary  " style="width:300px;height:80px">
       <div class="card-header">
          <div class="row">
            <h5>Vendas <i class="fa fa-shopping-cart"></i></h5>
            <h5 style="margin-left:150px;">{{Sale}}</h5>
          </div>
        </div>
      </div>
      <div class="card text-white bg-secondary" style="width:300px;height:80px">
        <div class="card-header">
          <div class="row">
            <h5>Produtos <i class="fa fa-folder"></i></h5>
            <h5 style="margin-left:150px;">{{Product}}</h5>
          </div>
        </div>
    </div>
      <div class="card text-white bg-success" style="width:300px;height:80px">
         <div class="card-header">
          <div class="row">
            <h5>Clientes <i class="fa fa-user"></i></h5>
            <h5 style="margin-left:150px;">{{Client}}</h5>
          </div>
        </div>
      </div>
    </div>

       
</div>

</template>

<script>

import { mapGetters} from 'vuex'

import '../config/filterData'
import { } from "chartjs-plugin-datalabels";
export default {
    
name: 'LineChartContainer',
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
  
}
</script>

<style>

</style>