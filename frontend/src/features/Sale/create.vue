<template>
  <div>
    <h4 cabecalho="product_id">Vendas</h4>
      <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
           <li class="breadcrumb-item"><router-link to="/sales">Vendas</router-link></li>
          <li class="breadcrumb-item active" aria-current="page">Criar</li>
        </ol>
      </nav>
      <div class="form-row">
          <div @submit.prevent="abc" class="form-group col-md-6">
          <label for="">Clientes</label>
          <select class="form-control" v-model="client_id" >
              <option selected disabled value="">selecione</option>
              <option   v-for="(client,k) in clients" v-show="client.status == 'Ativo'" :key="k"  :value="client.id">{{client.name}}</option>
          </select>
          </div>
          
          <div class="form-group col-md-6">
            <label for="">Data da Venda</label>
          <input type="date" v-model="datavenda"
          class="form-control">
          </div>
      
      <fieldset class="m-3">
          <div class="row m-2">

          </div>
          <table class="table table-sm"> 
        <thead>
            <tr>
                <th scope="col">produtos</th>
                <th scope="col">Preço</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Total R$</th>
                <th v-show="this.details_sales.length > 1" scope="col">Ação</th>
            </tr>
        </thead>
        <tbody>
          <tr v-for="detalheVenda of details_sales" :key="detalheVenda.id">
            
            <td>
             <select class="form-control" v-model="detalheVenda.product_id" required>
               <option v-for="(product) in products" :key="product.id" v-show="product.status == 'Ativo'" :value="product.id">{{product.name}}</option>

             </select>
              </td>
            <td><money v-model="detalheVenda.descount" :value="detalheVenda.descount" v-bind="money" name="valorSinistrado" class="form-control" @change="calculateLineTotal(detalheVenda)"></money></td>
            <td><input class="form-control" type="number" v-model="detalheVenda.price" @change="calculateLineTotal(detalheVenda)" required></td>
            <td><money readonly disabled :value="detalheVenda.subtotal" v-bind="money" name="totalPrejuizo" class="form-control"></money></td>
            <td>
              <button  class="btn btn-danger" @click="remova(detalheVenda)" ><i class="fa fa-times"></i></button>
            </td>
          </tr>
        </tbody>
        <tfoot>
            <tr>
                <th scope="col">Total</th>
                <th></th>
                <th></th>
                <th scope="col"><money readonly disabled :value="totalizar" v-bind="money" name="totalPrejuizo" class="form-control form-control-sm" style="background-color:#993399;color:#fff;"></money></th>
            </tr>
        </tfoot>
        </table>
        <button type='button' style="float-right;" class="btn btn-info m-4" @click="adiciona">
          <i class="fas fa-plus-circle"></i>
         Adicione
        </button>
      </fieldset>
    <br>

        <div class="card col-12 m-2">
          <div class="card-header">
            Pagamento
          </div>
          <div class="card-body">
            <h5 class="card-title"></h5>
            <div class="row">
              <div class="form-group m-2">
                <label for="">Forma de Pagamento</label>
                <select type="text" class="form-control" v-model="formapagamento.tipo_forma_pagamento">
                  <option disabled selected value="null">Selecione</option>
                  <option value="0">Boleto bancário</option>
                  <option value="1">A vista</option>
                  <option value="2">Cartao de crédito</option>
                  <option value="3">Cartao de débito</option>
                </select>
              </div>

              <div class="form-group m-2">
                <label for="">Parcelas</label>
                <select type="text" class="form-control" v-model="formapagamento.parcelas" v-show="formapagamento.tipo_forma_pagamento == '2'">
                  <option selected value="null">1x</option>
                  <option value="1">6x</option>
                  <option value="2">10x</option>
                  <option value="3">12x</option>
                  <option value="4">24x</option>
                </select>

                 <select type="text" class="form-control" v-model="formapagamento.parcelas" disabled v-show="formapagamento.tipo_forma_pagamento !== '2'">
                  <option selected value="null">1x</option>
                  <option value="1">6x</option>
                  <option value="2">10x</option>
                  <option value="3">12x</option>
                  <option value="4">24x</option>
                </select>
              </div>

              <div class="form-group m-2">
                <label for="">Entrada</label>
                <input type="text" class="form-control" v-show="formapagamento.tipo_forma_pagamento == '2'"  v-model="formapagamento.entrada" placeholder="0,00">
                <input type="text" class="form-control" v-show="formapagamento.tipo_forma_pagamento !== '2'" disabled  v-model="formapagamento.entrada" placeholder="0,00">
              </div>
            </div>
          </div>
        </div>
      </div>
    <button type="submit" @click="onSubmit" class="btn btn-success">Cadastrar</button>
     <button class="btn btn-danger" style="float:right;" v-show="this.details_sales.length > 2" @click="exportPdfSale">Baixar relatório da venda<i class="fa fa-print"></i></button>
  </div>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapState} from 'vuex'
import axios from 'axios'
import jsPDF from 'jspdf'
import {VMoney} from 'v-money'
import 'jspdf-autotable' 

export default {
   directives: {money: VMoney},

  data(){
    return {
      details_sales:[{
        product_id:'',
        price:'',
        descount:'',
        subtotal:0,
        name:''

      }],
      client_id:'',
      datavenda:'',
      total:0,
      formapagamento:{
        tipo_forma_pagamento:null,
        parcelas:null,
        entrada:null
      },
       money: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                suffix: '',
               
                precision: 2,
                masked: false
            }
    }
  },
  created(){
    //this.getProducts(),
    this.$store.dispatch('Client/getClient')
    this.$store.dispatch('Product/getProducts')
    
  },
  methods:{
  
  onSubmit(){
    axios.post('http://localhost:8000/api/sales',{
        client_id:this.client_id,
        dataVenda:this.datavenda,
        total:this.total,
        details_sales:this.details_sales,
        formapagamento:this.formapagamento
    }).then(res => {
      console.log(this.details_sales);
      console.log(res.data)
      this.$toasted.global.defaultSuccess()
      this.$router.push('/sales')
    })
  },
    
    remova(){
        if(this.details_sales.length > 1) {

          this.details_sales.splice({
            product_id:'',
            price:'',
            descount:'',
            subtotal:''
          },1)
          this.$toasted.global.defaultSuccess()
        }
          
      },

      adiciona(){
            if(this.details_sales.length <= 2) {

              this.details_sales.push({
                product_id:'',
                price:'',
                descount:'',
                subtotal:'',
                name:''
              })
            }else {
              return this.details_sales
            }
             
              
              this.$toasted.global.defaultSuccess()
        },

   
    calculateLineTotal(detalheVenda){
        var total = parseFloat(detalheVenda.price) * parseFloat(detalheVenda.descount) || 0
         detalheVenda.subtotal = total.toFixed(2);
    },
    exportPdfSale(){
       
            axios.get("http://localhost:8000/api/details")
            .then(function(res){
            console.log(res.data)
            })

            let columns = [
            {title:"Produto",dataKey:"name"},
            {title:"Preço",dataKey:"price"},
            {title:"Desconto",dataKey:"descount"},
            {title:"Total da Venda R$",dataKey: "subtotal"}
            ];
            
            var doc = new jsPDF('p','pt');
            doc.text('Relatório das vendas realizadas',10,12)
            doc.autoTable(columns,this.details_sales);
            doc.save("relatorioVenda.pdf");

        },
  },
  computed:{
     ...mapState('Client',{clients:state => state.clients}),
     ...mapState('Product',{products:state => state.products}),

     totalizar:function() {
             return  this.details_sales.reduce((total,detalheVenda) => {
                return this.total =  parseFloat(total) + parseFloat(detalheVenda.subtotal) || this.total
                
            },0)
        },
      
  }  
}
</script>

<style>
 div fieldset {
     border: black solid 3px;
     border-radius: 10px;
 }
</style>