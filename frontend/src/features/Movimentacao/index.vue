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
        <div class="row">
        <div class="col-md-12 d-flex justify-content-beetween">
            <div class="d-flex justify-content-start">
                <select name="tipo_movimentacao_id" id="tipo_movimentacao_id" class="form-control form-control-sm col-4 col-md-4"  v-model="filtro.tipo_movimentacao_id" @change="filter">
                    <option selected value="0">Todos</option>
                    <option v-for="tipo in tipos" :value="tipo.id" :key="tipo.id">{{tipo.descricao}}</option>
                </select>
            </div>
        </div>
    </div>
        <div class="d-flex justify-content-around mt-4" v-if="!filtro.tipo_movimentacao_id">
            <span class="btn btn-danger"><strong>Total Contas a pagar : {{totalizarpagar | money}}</strong> </span>
            <span class="btn btn-success"><strong>Total Contas a receber : {{totalizarreceber | money}}</strong> </span>
            
        </div>
        <div v-if="filtro.tipo_movimentacao_id == 1">
            <span class="btn btn-success"><strong>Total Contas a receber : {{totalizarreceber | money}}</strong> </span>
        </div>
        <div v-if="filtro.tipo_movimentacao_id == 2">
            <span class="btn btn-danger"><strong>Total Contas a pagar : {{totalizarpagar | money}}</strong> </span>
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
                descricao:'',
                valor:'',
                dt_vencimento:'',
              
            },
            filtro:{
                tipo_movimentacao_id:null
            },
            movimentacoes:[],
            movimentos:[],
            movimentacoespagar:[],
            movimentacoesreceber:[],
            buscar:[],
            total: [],
            tipos:[]
        }
    },
    created(){
        this.$store.dispatch('Provider/getProvider')
        this.filter()
        this.getTipo()
    },
    
    methods:{
        ...mapActions('Provider',['getProvider']),
        
        filter(){
            axios.post(`${API_BASE_URL}/filtromovi`,this.filtro).then(res => {
                this.movimentacoes = res.data
            
                this.movimentacoespagar = res.data
                let produtosEletrodomestico = this.movimentacoespagar.filter(produto => produto.tipo_movimentacao_id == 2);
                
                let teste = produtosEletrodomestico.map(produto => { 
                    return produto.valor
                });
                this.movimentacoespagar = teste

                this.movimentacoesreceber = res.data
                let produtosEletrodomesticoteste = this.movimentacoesreceber.filter(produto => produto.tipo_movimentacao_id == 1);
                
                let teste1 = produtosEletrodomesticoteste.map(produto => { 
                    return produto.valor
                });
                this.movimentacoesreceber = teste1
            })
        },
        getTipo(){
            axios.get(`${API_BASE_URL}/tipo`).then(res => {
                this.tipos = res.data
            })
        },
    },
    computed:{
        totalizarpagar(){
            return this.movimentacoespagar.reduce((acumulador,valor) => {
                return this.total = parseFloat(acumulador) + parseFloat(valor)
            },0) 
        },
        totalizarreceber(){
            return this.movimentacoesreceber.reduce((acumulador,valor) => {
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