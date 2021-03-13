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

  <div class="d-flex justify-content-between">
      
    <div class="card col-12">
      <div class="card-body">
         <grafico-ano></grafico-ano>
      </div>
    </div>
  </div>
      
  <div class="d-flex justify-content-between">
    <div class="card col-12 col-lg-6">
      <div class="card-body">
        <grafico-comissao-vendedor></grafico-comissao-vendedor>
      </div>
    </div>

    <div class="card col-12 col-lg-6">
      <div class="card-body">
        <grafico-total></grafico-total>
      </div>
    </div>
  </div>

<div class="d-flex justify-content-between">
    <div class="card col-12 col-lg-6">
      <div class="card-body">
        <grafico-mes></grafico-mes>
      </div>
    </div>

    <div class="card col-12 col-lg-6">
      <div class="card-body">
        <grafico-quantidade-produto-vendidos></grafico-quantidade-produto-vendidos>
      </div>
    </div>
  </div>       
      
</div>

</template>

<script>

import { mapGetters} from 'vuex'

import '../config/filterData'
import { } from "chartjs-plugin-datalabels";
import GraficoQuantidadeProdutoVendidos from './GraficoQuantidadeProdutoVendidos.vue'
import GraficoComissaoVendedor from './GraficoComissaoVendedor.vue'
import GraficoTotal from './GraficoTotal.vue'
import GraficoMes from './GraficoMes.vue'
import GraficoAno from './GraficoAno.vue'
export default {
    
name: 'LineChartContainer',
  components: { GraficoQuantidadeProdutoVendidos,GraficoComissaoVendedor, GraficoTotal, GraficoMes, GraficoAno },
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