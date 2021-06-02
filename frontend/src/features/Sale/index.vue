<template>
<div>
    <h4 cabecalho="Produto">Vendas</h4>
    <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
            <li class="breadcrumb-item active" aria-current="page">Vendas</li>
        </ol>
    </nav>
    
    <div class=" border border-black shadow p-3 mb-1 bg-white rounded" >
        <div class="form-row d-flex justify-content-between">
            <router-link to="/sales/create" tag="span"><button class="btn btn-sm btn-primary col-12"><i class="fa fa-plus"></i> Cadastrar</button></router-link>
            <div class="col-md-4 ">
                <select name="" id="" class="form-control form-control-sm">
                    <option selected disabled value="">selecione</option>
                    <option v-for="(client,indexClient) in clientes" :value="client.id" :key="indexClient">{{client.name}}</option>
                </select>
            </div>
            <div class="col-md-2 ">
                <input type="date" class="form-control form-control-sm ">
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control form-control-sm ">
            </div>
            <input class="form-control form-control-sm col-md-2" type="search" name="nome" placeholder="Buscar" v-model="search">
        </div>
        <div class="table-responsive scroll" ref="scroll" style="overflow-y:auto;height:300px;margin-top:3vh;">
            <table class="table table-hover table-bordered table-sm">
                <thead class="thead-light text-center">
                    <tr>
                        <th scope="col" class="col-form-label col-form-label-sm">Nome do Cliente</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Data da venda</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Total da venda</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Situação</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Tipo Usuario</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="(sale,k) in sales" :key="k" style="height:10px;" >
                        <td class="align-middle" style="font-size: 1em; height:10px;" >{{sale.clients && sale.clients.name ? sale.clients.name : 'NI'}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{sale.dataVenda | formatDate}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{sale.total | formatPrice}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{sale.situacao.descricao}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{sale.user.tipo_usuario.descricao}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;" width="20%">   
                            <div v-show="sale.situacao_id == 1">
                                <button  class="btn btn-sm btn-success m-1" @click="aprovar(sale)"><i class="fa fa-check "></i></button>
                                <router-link :to="`/salesedit/${sale.id}/edit`" class="btn btn-sm btn-warning m-1"><i class="fa fa-pen"></i></router-link>
                                <button  class="btn btn-sm btn-danger"  @click="removeSale(sale)"><i class="fa fa-trash"></i></button>  
                            </div>

                            <div v-show="sale.situacao_id == 2">
                                <router-link :to="`/salesshow/${sale.id}/show`" class="btn btn-sm btn-info m-1"><i class="fa fa-eye"></i></router-link>  
                                <button  class="btn btn-sm btn-dark"  @click="relatorioVenda(sale)"><i class="fa fa-file-pdf"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import axios from 'axios'
import {mapGetters, mapState} from 'vuex'
import {API_BASE_URL} from '../../config/Api'
import jsPDF from 'jspdf'
import swal from 'sweetalert'
import 'jspdf-autotable' 

export default {
    data(){
        return {
            clientes:[],
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
        this.getClients()
        this.$store.dispatch('Sale/getSales')
        },
    methods:{
        getClients(){
            axios.get(`${API_BASE_URL}/clients/`).then(res => {
                this.clientes = res.data
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
                axios.delete(`${API_BASE_URL}/sales/${sale.id}`)
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
       
            axios.get("${API_BASE_URL}/sales")
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
            axios.get(`${API_BASE_URL}/relatorioexcel`).then(res => {
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
            axios.get('${API_BASE_URL}/relatoriopdf',{
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
            axios.get(`${API_BASE_URL}/relatoriopdfdetalhes/${sale.id}`,{
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
                axios.post(`${API_BASE_URL}/aprovar/${sale.id}`)
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