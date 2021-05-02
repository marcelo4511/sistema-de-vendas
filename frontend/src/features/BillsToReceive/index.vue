<template>
<div>
    <h4 cabecalho="Produto">Contas a Receber</h4>
        <nav aria-label="breadcrumb mb-4">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Contas a Receber</li>
            </ol>
        </nav>
    <router-link to="/billstoreceivestore" tag="span"><button class="btn btn-sm btn-primary">Cadastrar</button></router-link>
    <input class="form-control form-control-sm col-md-3 mb-3" type="search" style="float: right;" name="nome" placeholder="Buscar" v-model="buscar">
  
   <div class="table table-responsive">
        <table class="table table-sm">
            <thead class="text-center">
                <tr>
                    <th scope="col">Descrição</th>
                    <th scope="col">Valor a pagar</th>
                    <th scope="col">Data do vencimento</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Comprovante</th>
                    <th scope="col">Situação</th>
                    <th scope="col">Açôes</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr v-for="(provider,k) in pesquisar" :key="k" >
                    <td>{{provider.descricao}}</td>
                    <td>{{provider.valor | money}}</td>
                    <td>{{provider.dt_vencimento | momentDate}}</td>
                    <td>{{provider.user.name}}</td>
                    <td>{{provider.Comprovante}}</td>
                   <td>{{provider.situacao.descricao}}</td>

                    <td class="align-middle" width="20%">   
                    <div v-show="provider.situacao_id == 1">
                        <router-link :to="`/provideredit/${provider.id}/edit`" class="btn btn-sm btn-warning  m-1"><i class="fa fa-pen"></i></router-link>
                        <button  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>  
                        <button  class="btn btn-sm btn-success m-1" @click="aprovar(provider)"><i class="fa fa-check "></i></button>
                    </div>
                </td>
                </tr>
            </tbody>
        </table>
   </div>
</div>
</template>

<script>
import moment from 'moment'
import {API_BASE_URL} from '../../config/Api'
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import axios from 'axios'
import {mapActions} from 'vuex' 
import swal from 'sweetalert'
export default {
    data(){
        return {
            provider:{
                descricao:'',
                valor:'',
                dt_vencimento:'',
            },
        providers:[],
            buscar:[]
        }
    },
    created(){
        this.$store.dispatch('Provider/getProvider')
        this.getProvider()
    },
    
    methods:{
        ...mapActions('Provider',['getProvider']),
        getProvider(){
            axios.get(`${API_BASE_URL}/billstoreceive`).then(res => {
                this.providers = res.data
            })
        },
        postMovimentacao(provider){
            provider.tipo_movimentacao_id = 1
            axios.post(`${API_BASE_URL}/movimentacao/`,provider).then(() => {
            })
        },
        removeClient(provider){
            swal({
            title: "Você está certo disso ?",
            text: "Depois de excluído, você não será capaz de recuperar este arquivo!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                axios.delete(`${API_BASE_URL}/fornecedores/${provider.id}`)
            .then(res => {
                this.providers.splice(res.data.id,1)
                swal("Fornecedor deletado com sucesso!", {
                icon: "success",
                });
            })
            } else {
                swal("seu dado está a salvo");
            }
            });
               return  this.postMovimentacao(provider)
        },
        aprovar(provider){
            swal({
            title: "Tela de venda para aprovação",
            text: "Depois de aprovado, você não será capaz de modificar essa venda!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                axios.post(`${API_BASE_URL}/billstoreceive/aprovar/${provider.id}`)
            .then(() => {
                swal("Venda aprovada!", {
                icon: "success",
                });
                return location.reload()
            })
            } else {
                swal("Venda continua a esperar o pagamento");
            }
            });
            return  this.postMovimentacao(provider)
        },
    },
    computed:{
     //   ...mapState('Provider',{providers:state => state.providers}),
        pesquisar:function(){
           return this.providers.filter(providers => {
                return providers.descricao.includes(this.buscar)
            })
        }
    },
    filters:{
        money(value){
            if(value){
                return value = parseFloat(value).toLocaleString('pt-BR',{style:'currency',currency:'BRL'}) 
            }
        },
        momentDate(date){
            if(date){
                return date ? moment(date).format('DD/MM/YYYY') : null
            }
        },
  },
}
</script>

<style>

</style>