<template>
<div>
  <h4 >BI</h4>
  <nav aria-label="breadcrumb mb-2">
    <ol class="breadcrumb col-12">
      <li class="breadcrumb-item"><router-link to="/dashboard">Dashboard</router-link></li>
    </ol>
  </nav>

  <div class="col-12 d-flex justify-content-between  mb-3">
    <select name="" id="" class="form-control form-control-sm col-3" v-model="selecionaCliente" @change="selecionar($event)">
        <option value="0">Cliente</option>
         <option v-for="(client, index) in clients" :key="index" :value="client.id">{{ client.name }}</option>
    </select>
    <select name="" id="" class="form-control form-control-sm col-3" v-model="selecionaVendedor" @change="selecionar($event)">
        <option value="0">Vendedor</option>
        <option v-for="(user, index) in users" :key="index" :value="user.id">{{ user.name }}</option>
    </select>
    <select name="" id="" class="form-control form-control-sm col-3" v-model="selectedMonth" @change="selecionar($event)">
        <option selected value="0">Mês</option>
        <option :value="1">Janeiro</option>
        <option :value="2">Fev</option>
        <option :value="3">Março</option>
        <option :value="4">Abril</option>
        <option :value="5">Maio</option>
        <option :value="6">Junho</option>
        <option :value="7">Julho</option>
        <option :value="8">Agosto</option>
        <option :value="9">Setembro</option>
        <option :value="10">Outubro</option>
        <option :value="11">Novembro</option>
        <option :value="12">Dezembro</option>
    </select>
    <select name="" id="" class="form-control form-control-sm col-2" v-model="selectedyear" @change="selecionar($event)">
        <option value="">Ano</option>
        <option :value="2020">2020</option>
        <option :value="2021">2021</option>
    </select>
  </div>

 <!-- <div class="col-12 d-flex justify-content-between">
    <grafico-ano></grafico-ano> 
    <grafico-ano></grafico-ano> 
    <grafico-ano></grafico-ano> 
  </div>
  <div class="col-12 d-flex mb-2 ">
    <div class="card col-12 col-md-6 mr-1">
      <div class="card-body">
        <grafico-comissao-vendedor></grafico-comissao-vendedor>
      </div>
    </div>

    <div class="card col-12 col-md-6">
      <div class="card-body">
        <grafico-total></grafico-total>
      </div>
    </div>
  </div>

  <div class="col-12 d-flex mb-2">
    <div class="card col-12 col-md-6 mr-2">
      <div class="card-body">
        <grafico-mes></grafico-mes>
      </div>
    </div>

    <div class="card col-12 col-md-6">
      <div class="card-body">
        <grafico-quantidade-produto-vendidos></grafico-quantidade-produto-vendidos>
      </div>
    </div>
  </div>       
      
  <div class="col-12 mb-2">
    <div class="card col-12">
      <div class="card-body">
        <grafico-cliente-compra></grafico-cliente-compra>
      </div>
    </div>
  </div>       -->
</div>

</template>

<script>
import {API_BASE_URL} from '../../config/Api'
import { mapGetters} from 'vuex'
import axios from 'axios'
import '../../config/filterData'
import { } from "chartjs-plugin-datalabels";
//import GraficoQuantidadeProdutoVendidos from '../../BI/GraficoQuantidadeProdutoVendidos'
//import GraficoComissaoVendedor from '../../BI/GraficoComissaoVendedor.vue'
//import GraficoTotal from '../../BI/GraficoTotal.vue'
//import GraficoMes from '../../BI/GraficoMes.vue'
//import GraficoAno from '../../BI/GraficoAno.vue'
//import GraficoClienteCompra from '../../BI/GraficoClienteCompra'
import moment from 'moment';
export default {
    
name: 'bi',
 // components: { GraficoQuantidadeProdutoVendidos,GraficoComissaoVendedor,GraficoClienteCompra, GraficoTotal, GraficoMes,GraficoAno },
    data() {
      return{
       selectedMonth:moment().month(),
       selectedyear:moment().year(),
        mes:0,
        selecionaCliente: 0,
        selecionaVendedor: 0,
        users:[],
        clients:[],
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
    this.getClients()
    this.getVendedor()
  },
   mounted(){
       axios.get(`${API_BASE_URL}/clients`).then(res => {
            this.clients = res.data
        })
        axios.get(`${API_BASE_URL}/users`).then(res => {
            this.users = res.data
            let vendedorFiltro = this.users.filter(contasPagar => contasPagar.type_user_id == 1 || contasPagar.type_user_id == 3);
            this.users = vendedorFiltro
        })
   },
  methods:{
       selecionar() { 
        this.$root.$emit('selecionar', {
            mes: this.selectedMonth,
            ano:this.selectedyear,
            clients: this.selecionaCliente,
            vendedor:this.selecionaVendedor
        })
      },
      getClients() {
            if(this.selecionaCliente != 0) {
                 axios.get(`http://localhost:8000/api/clients`).then(res => {
                    this.clients = res.data
                }).then(() => {
                   this.selecionaCliente = 0
                })
            }else {
                this.clients = []
                this.selecionaCliente = 0
            }
       },
       getVendedor() {
            if(this.selecionaVendedor != 0) {
                 axios.get(`http://localhost:8000/api/users`).then(res => {
                    this.users = res.data
                }).then(() => {
                   this.selecionaVendedor = 0
                })
            }else {
                this.users = []
                this.selecionaVendedor = 0
            }
       },
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