<template>
<div>
    <h4 cabecalho="Produto">Movimentações</h4>
        <nav aria-label="breadcrumb mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Movimentações</li>
            </ol>
        </nav>
    <input class="form-control form-control-sm col-md-3 mb-3" type="search" style="float: right;" name="nome" placeholder="Buscar" v-model="buscar"><br>
    
        <div class="d-flex justify-content-around mt-4">
            <span><strong>Total Geral : {{totalizar | money}}</strong> </span>
            <span><strong>Total Contas a pagar : {{totalizar | money}}</strong> </span>
            <span><strong>Total Contas a receber : {{totalizar | money}}</strong> </span>
        </div>
   <div class="table table-responsive">
        <table class="table table-sm">
            <thead class="text-center">
                <tr>
                    <th scope="col">Descrição</th>
                    <th scope="col">Valor a pagar</th>
                    <th scope="col">Data do vencimento</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Movimentações</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr v-for="(provider,k) in movimentacoes" :key="k"  v-show="provider.tipo_movimentacao_id == 2">
                    <td>{{provider.descricao}}</td>
                    <td>{{provider.valor | money}}</td>
                    <td>{{provider.dt_vencimento | momentDate}}</td>
                    <td>{{provider.user.name}}</td>
                    <td><span class="btn btn-sm btn-danger">{{provider.tipo_movimentacao.descricao}}</span></td>
                </tr>
                <tr v-for="(provider,k) in movimentacoes" :key="'y'+ k" v-show="provider.tipo_movimentacao_id == 1">
                    <td>{{provider.descricao}}</td>
                    <td>{{provider.valor | money}}</td>
                    <td>{{provider.dt_vencimento | momentDate}}</td>
                    <td>{{provider.user.name}}</td>
                    <td><span class="btn btn-sm btn-success">{{provider.tipo_movimentacao.descricao}}</span></td>
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
export default {
    data(){
        return {
            provider:{
                name:'',
                cnpj_cpf:'',
                email:'',
                cep:'',
                fone:'',
                celular:'',
                status:''
            },
            movimentacoes:[],
            movimentos:[],
            movimentacoespagar:[],
            movimentacoesreceber:[],
            buscar:[],
            total: [],
        }
    },
    created(){
        this.$store.dispatch('Provider/getProvider')
        this.getProvider()
    },
    
    methods:{
        ...mapActions('Provider',['getProvider']),
        getProvider(){
            axios.get(`${API_BASE_URL}/movimentacao`).then(res => {
                this.movimentacoes = res.data
                this.movimentos = res.data.map(movimento => {
                  return  movimento.valor
                })
                if(res.data.tipo_movimentacao_id == 2){
                    this.movimentacoespagar = res.data.map(movimento => {
                        return movimento.valor
                    })
                }
                console.log(this.movimentacoespagar)
                this.movimentacoesreceber.map(movimento => {
                    return movimento.valor
                })
            })
        },
    },
    computed:{
        totalizar(){
            return this.movimentos.reduce((acumulador,valor) => {
                return this.total = parseFloat(acumulador) + parseFloat(valor)
            },0) 
        },
        totalizarpagar(){
            return this.movimentos.reduce((acumulador,valor) => {
                return this.total = parseFloat(acumulador) + parseFloat(valor)
            },0) 
        },
        totalizarreceber(){
            return this.movimentos.reduce((acumulador,valor) => {
                return this.total = parseFloat(acumulador) + parseFloat(valor)
            },0) 
        },
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