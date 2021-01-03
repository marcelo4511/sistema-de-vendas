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

     <input class="form-control col-md-3 mb-3" type="search" style="float: right;" name="nome" placeholder="Buscar">
  
  <table class="table table-sm">
      <thead>
          <tr>
              <th scope="col">Nome do Cliente</th>
              <th scope="col">Data da venda</th>
              <th scope="col">Total da venda</th>
              <th scope="col">Situação</th>
              <td scope="col">TIpo Usuário</td>
              <td scope="col">Nome Usuário</td>
              <th scope="col">Ações</th>
          </tr>
      </thead>
      <tbody>
          <tr v-for="(sale,k) in sales" :key="k" >
              <td>{{sale.clients.name}}</td>
              <td>{{sale.dataVenda | formatDate}}</td>
              <td>{{sale.total}}</td>
              <td>{{sale.situacao.descricao}}</td>
              <td>{{sale.user.tipo_usuario.descricao}}</td>
               <td>{{sale.user.name}}</td>
              <td> 
                <router-link :to="`/salesedit/${sale.id}/edit`" class="btn btn-warning ml-2"><i class="fa fa-pen"></i></router-link>
                <button  class="btn btn-danger ml-2"  @click="removeSale(sale)"><i class="fa fa-trash"></i></button>    
              </td>
          </tr>
      </tbody>
  </table>
  
 
</div>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import axios from 'axios'

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
            sales:[],
            search:[]
        }

    },
    created(){
        this.getSales()
        },
    methods:{
      getSales(){
        axios.get("http://localhost:8000/api/salesemandamento").then(res => {
          this.sales = res.data
        })
      },
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
                this.sales.pop(res.data.id,1)
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
    },
   // computed:{
       
        //searching:function(){
//return this.sales.filter(sale => {
        //        return sale.name.matched(this.search)
//})
//}
//}    
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