<template>
<div>
    <h4 cabecalho="Produto">Vendas</h4>
        <nav aria-label="breadcrumb mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                
                <li class="breadcrumb-item active" aria-current="page">Vendas</li>
            </ol>
        </nav>
        <router-link to="/sales/create" tag="span"><button class="btn btn-primary">Cadastrar</button></router-link>

     <input class="form-control col-md-3 mb-3" type="search" style="float: right;" name="nome" placeholder="Buscar" v-model="search">
  
  <table class="table table-sm">
      <thead>
          <tr>
              <th scope="col">Nome do Cliente</th>
              <th scope="col">Data da venda</th>
              <th scope="col">Total da venda</th>
              <th scope="col">Ações</th>
          </tr>
      </thead>
      <tbody>
          <tr v-for="(sale,k) in searching" :key="k" >
              <td>{{sale.name}}</td>
              <td>{{sale.dataVenda}}</td>
              <td>R$ {{formatPrice(sale.total)}}</td>
              <td>  
                    <button  class="btn btn-warning"><i class="fa fa-pen"></i></button>
                    <button  class="btn btn-danger ml-2"  @click="removeSale(sale)"><i class="fa fa-trash"></i></button>
                   
              </td>
          </tr>
      </tbody>
  </table>

  <button class="btn btn-danger" @click="exportPdf">Baixar relatório total<i class="fa fa-print"></i></button>
</div>
</template>

<script>
import axios from 'axios'
import {mapState} from 'vuex'
import jsPDF from 'jspdf'
import swal from 'sweetalert'
import 'jspdf-autotable' 

export default {
    data(){
        return {
            sale:{
                id:'',
                dataVenda:'',
                client_id:'',
                name:'',
                total:''
            },
            search:[]
        }

    },
    created(){
        this.$store.dispatch('Sale/getSales')
    },
    methods:{
          removeSale(sale){
            swal({
            title: "Você está certo disso ?",
            text: "Depois de excluído, você não será capaz de recuperar este arquivo!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                axios.delete(`http://localhost:8000/api/sales/${sale.total}`)
            .then(res => {
                this.sales.splice(res.data.id,1)
                swal("Venda deletada com sucesso!", {
                icon: "success",
                });
            })
            } else {
                swal("seu dado está a salvo");
            }
            });
               
        },
        formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        exportPdf(){
       
            axios.get("http://localhost:8000/api/sales")
            .then(function(res){
            console.log(res.data)
            })

            let columns = [
            {title:"Clientes",dataKey:"name"},
            {title:"Data da Venda",dataKey:"dataVenda"},
            {title:"Total das Vendas R$",dataKey: "total"}
            ];
            
            var doc = new jsPDF('p','pt');
            doc.text('Relatório das vendas realizadas',10,12)
            doc.autoTable(columns,this.sales);
            doc.save("relatorio.pdf");

        },

        
    },
    computed:{
        ...mapState('Sale',{sales:state => state.sales}),

        reais:function(){
            return this.total.toFixed(2).replace('.',',')
        },
        searching:function(){
            return this.sales.filter(sale => {
                return sale.name.includes(this.search)
            })
        }
    }    
}

</script>

<style>
    .red{
        background-color: brown;
        color:#fff;
        border-radius: 5px;
        border-color: black;
    }

    .red:hover{
        transition: 2ms;
    }
</style>