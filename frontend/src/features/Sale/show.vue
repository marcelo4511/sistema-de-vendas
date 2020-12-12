<template>
  <div>
    <h4 cabecalho="product_id">Vendas</h4>
      <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
           <li class="breadcrumb-item"><router-link to="/sales">Vendas</router-link></li>
          <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
      </nav>
      <div class="form-row">
          <div @submit.prevent="abc" class="form-group col-md-6">
          <label for="">Clientes</label>
          <select class="form-control" v-model="sales.client_id" disabled>
              <option selected disabled value="">selecione</option>
              <option   v-for="(client,k) in clients" v-show="client.status == 'Ativo'" :key="k"  :value="client.id">{{client.name}}</option>
          </select>
          </div>
          
          <div class="form-group col-md-6">
            <label for="">Data da Venda</label>
          <input type="date" v-model="sales.dataVenda" class="form-control" readonly>
          </div>
      
      <fieldset class="m-3">
          <div class="row m-2">

          </div>
          <table class="table table-sm"> 
        <thead>
            <tr>
                <th scope="col">produtos</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Preço</th>
                <th scope="col">Total R$</th>
            </tr>
        </thead>
        <tbody>
          <tr v-for="detalheVenda of sales.details_sales" :key="detalheVenda.id">
            
            <td>
             <select class="form-control" v-model="detalheVenda.product_id" disabled>
               <option v-for="(product) in products" :key="product.id" v-show="product.status == 'Ativo'" :value="product.id">{{product.name}}</option>

             </select>
              </td>
            <td><input class="form-control" type="number" v-model="detalheVenda.price" @change="calculateLineTotal(detalheVenda)" readonly></td>
            <td><input class="form-control" type="number" v-model="detalheVenda.descount" @change="calculateLineTotal(detalheVenda)" readonly></td>
            <td><input class="form-control" type="text" v-model="detalheVenda.subtotal" readonly></td>
            <td>
            </td>
          </tr>
        </tbody>
        <tfoot>
            <tr>
                <th scope="col">Total</th>
                <th></th>
                <th></th>
                <th scope="">R${{totalizar}}</th>
            </tr>
        </tfoot>
        </table>
        <button type='button' style="float-right;" class="btn btn-danger m-4">
          <i class="fa fa-file-pdf"></i>
         Gerar Boleto
        </button>
      </fieldset>
    <br>
      
      </div>
  </div>
</template>

<script>
import {mapState} from 'vuex'
import axios from 'axios'
import jsPDF from 'jspdf'
import 'jspdf-autotable' 
export default {
     name:'salesedit',
  data(){
    return {
      
      client_id:'',
      datavenda:'',
      total:0,
      sales:{
        details_sales:[{
        product_id:'',
        price:'',
        descount:'',
        subtotal:0,
        name:''

        }],
        
      },
      
    }
  },
  created(){
    this.getSale()
    this.$store.dispatch('Client/getClient')
    this.$store.dispatch('Product/getProducts')
    
  },
  methods:{
        getSale(){
            axios.get(`http://localhost:8000/api/sales/${this.$route.params.sale}`)
            .then(res => {
                this.sales = res.data
                console.log(this.sales)
            })
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
            doc.autoTable(columns,this.sales.details_sales);
            doc.save("relatorioVenda.pdf");

        },
  },
  computed:{
     ...mapState('Client',{clients:state => state.clients}),
     ...mapState('Product',{products:state => state.products}),

     totalizar:function() {
             return  this.sales.details_sales.reduce((total,detalheVenda) => {
                return this.sales.total =  parseFloat(total) + parseFloat(detalheVenda.subtotal) || this.sales.total
                
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