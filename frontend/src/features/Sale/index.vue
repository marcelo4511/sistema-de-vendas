<template>
<div>
    <h4 cabecalho="Produto">Vendas</h4>
        <nav aria-label="breadcrumb mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                
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
              <th scope="col">Situação</th>
              <th scope="col">Tipo Usuario</th>
              <th scope="col">Ações</th>
          </tr>
      </thead>
      <tbody class="text-center">
          <tr v-for="(sale,k) in sales" :key="k" >
                <td>{{sale.clients && sale.clients.name ? sale.clients.name : 'NI'}}</td>
                <td>{{sale.dataVenda | formatDate}}</td>
                <td>{{sale.total | formatPrice}}</td>
                <td>{{sale.situacao.descricao}}</td>
                <td>{{sale.user.tipo_usuario.descricao}}</td>
                <td class="align-middle" width="20%">   
                    <div v-show="sale.situacao_id == 1">
                        <button  class="btn btn-success m-1" @click="aprovar(sale)"><i class="fa fa-check "></i></button>
                        <router-link :to="`/salesedit/${sale.id}/edit`" class="btn btn-warning m-1"><i class="fa fa-pen"></i></router-link>
                        <button  class="btn btn-danger"  @click="removeSale(sale)"><i class="fa fa-trash"></i></button>  
                    </div>

                    <div v-show="sale.situacao_id == 2">
                        <router-link :to="`/salesshow/${sale.id}/show`" class="btn btn-info m-1"><i class="fa fa-eye"></i></router-link>  
                        <button  class="btn btn-dark"  @click="relatorioVenda(sale)"><i class="fa fa-file-pdf"></i></button>
                    </div>
                </td>
          </tr>
      </tbody>
  </table>
  
  <div v-show="sale">
    <button class="btn btn-success mr-2" @click="relatorioExcel">Baixar relatório total <i class="fa fa-file-excel"></i></button>
    <button class="btn btn-danger" @click="relatorioPdf">Baixar relatório total <i class="fa fa-print"></i></button>
  </div>
</div>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import axios from 'axios'
import {mapGetters, mapState} from 'vuex'
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
                axios.delete(`http://localhost:8000/api/sales/${sale.id}`)
            .then(res => {
                this.sales.splice(res.data.id,-1)
                swal("Venda deletada com sucesso!", {
                icon: "success",
                });
            })
               
            } else {
                swal("seu dado está a salvo");
            }
            });
             return this.$forceUpdate();
               
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
            doc.html('<center>Relatório das vendas realizadas</center>',10,12)
            doc.autoTable(columns,this.sales);
            doc.save("relatorio.pdf");

        },

        relatorioExcel() {
            axios.get(`http://localhost:8000/api/relatorioexcel`).then(res => {
                if (res.status === 200) {
                    let blob = new Blob([res.data], {
                        type: "application/vnd.ms-excel"
                    });
                    const urlObject = window.URL.createObjectURL(blob);
                    const a = document.createElement("a");
                    a.href = urlObject;
                    a.setAttribute("download", "listavendas.xls");
                    document.body.appendChild(a);
                    a.click();
                }
            });
        },
        relatorioPdf(){
            axios.get('http://localhost:8000/api/relatoriopdf',{
            responseType: 'blob'
            }).then((response) => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'file.pdf');
            document.body.appendChild(link);
            link.click();
            });
        },
        relatorioVenda(sale){
            axios.get(`http://localhost:8000/api/relatoriopdfdetalhes/${sale.id}`,{
            responseType: 'blob'
            }).then((response) => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'file.pdf');
            document.body.appendChild(link);
            link.click();
            });
        },
        aprovar(sale){
            swal({
            title: "Tela de venda para aprovação",
            text: "Depois de aprovado, você não será capaz de modificar essa venda!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                axios.post(`http://localhost:8000/api/aprovar/${sale.id}`)
            .then(res => {
                console.log(res.data)
               
                swal("Venda aprovada!", {
                icon: "success",
                });
                return location.reload()
            })
            } else {
                swal("Venda continua a esperar o pagamento");
            }
            });
         
           
               
        },
    },
    computed:{
        ...mapState('Sale',{sales:state => state.sales}),
        ...mapGetters({
        
            Sale:'Sale/teste'
        }),
        reais:function(){
            return this.total.toFixed(2).replace('.',',')
        },
       
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