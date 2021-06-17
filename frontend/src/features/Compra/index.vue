<template>
<div>
    <h4 cabecalho="Produto">Compras</h4>
    <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
            <li class="breadcrumb-item active" aria-current="page">Compras</li>
        </ol>
    </nav>
    
    <div class=" border border-black shadow p-3 mb-1 bg-white rounded" >
        <div class="form-row d-flex justify-content-between">
            <router-link to="/compras/store" tag="span"><button class="btn btn-sm btn-primary col-12"><i class="fa fa-plus"></i> Cadastrar</button></router-link>
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
                        <th scope="col" class="col-form-label col-form-label-sm">Nome do Forncedor</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Data da compra</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Total da Compra</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Situação</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Tipo Usuario</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="(compra,k) in compras" :key="k" style="height:10px;" >
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{compra.fornecedor && compra.fornecedor.name ? compra.fornecedor.name : 'NI'}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{compra.data_compra | formatDate}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{compra.total | formatPrice}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{compra.situacao.descricao}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{compra.user.tipo_usuario.descricao}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;" width="20%">   
                            <div v-show="compra.situacao_id == 1">
                                <!--<button  class="btn btn-sm btn-success m-1" @click="aprovar(sale)"><i class="fa fa-check "></i></button>-->
                                <router-link :to="`/comprasedit/${compra.id}/edit`" class="btn btn-sm btn-warning m-1"><i class="fa fa-pen"></i></router-link>
                                <button  class="btn btn-sm btn-danger" data-toggle="modal" :data-target="`#categoria${compra.id}`"><i class="fa fa-trash"></i></button> 
                                <modal class="del" :title="`Deseja remover a Compra`" :compl="``" :name="`categoria${compra.id}` ">
                                    <div class="modal-body text-left" >
                                        <button class="btn btn-sm btn-primary mr-2" data-dismiss="modal"> Cancelar</button>  
                                        <button class="btn btn-sm btn-danger" @click="removeCompra(compra.id,k)" :disabled="loading">
                                        <i v-if="loading"  class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true"></i>
                                        Deletar
                                        </button>
                                    </div>
                                </modal> 
                            </div>

                            <div v-show="sale.situacao_id == 2">
                                <router-link :to="`/salesshow/${sale.id}/show`" class="btn btn-sm btn-info m-1"><i class="fa fa-eye"></i></router-link>  
                                <button  class="btn btn-sm btn-dark"  @click="relatorioVenda(sale)"><i class="fa fa-file-pdf"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="loading"><td colspan="6" align="center" ><i  class="mt-2 spinner-border spinner-border spinner text-primary" role="status" aria-hidden="true"></i></td></tr>
                    <tr v-if="loading == false && compras.length == 0"><td colspan="6"  align="center" style="border:0;margim-bottom:2px;"><label class="col-form-label col-form-label-sm">Nenhum registro encontrado.</label></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import axios from 'axios'
import {API_BASE_URL} from '../../config/Api'
import $ from 'jquery'
export default {
    components:{
        Modal: () => import('../Modal/modal.vue')
    },
    data(){
        return {
            loading:false,
            compras:[],
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
        this.getFornecedores()
        this.getCompras()
        this.$store.dispatch('Sale/getSales')
        },
    methods:{
        getFornecedores(){
            axios.get(`${API_BASE_URL}/clients/`).then(res => {
                this.clientes = res.data
            })
        },
        getCompras(){
            this.loading = true
            axios.get(`${API_BASE_URL}/compras/`).then(res => {
                this.compras = res.data
                this.loading = false
            })
        },
        removeCompra(compra,indexCompra){
          if(compra){
            this.loading = true
            axios.delete(`${API_BASE_URL}/compras/${compra}`).then((res) => {
              if(res.data.status){
                this.$noty.success("Deletado com sucesso!!")
                this.compras.splice(indexCompra,1)
                this.loading = false
                $('.del').modal('hide');
              }else {
                this.$noty.info("Houve erro na requisição!!")
              }
            })
          }
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
    },
    computed:{
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