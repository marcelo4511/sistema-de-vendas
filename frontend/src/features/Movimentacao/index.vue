<template>
<div>
    <h4 cabecalho="Produto">Movimentações</h4>
        <nav aria-label="breadcrumb mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Movimentações</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-12 d-flex justify-content-beetween mb-2">
                <div class="form-group col-6 col-md-5">
                    <label for="">Movimentação</label>
                    <select name="tipo_movimentacao_id" id="tipo_movimentacao_id" class="form-control form-control-sm"  v-model="filtro.tipo_movimentacao_id" @change="filter">
                        <option selected value="0">Todos</option>
                        <option v-for="tipo in tipos" :value="tipo.id" :key="tipo.id">{{tipo.descricao}}</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label class="col-form-label col-form-label-sm">De</label>
                    <input class="form-control form-control-sm" type="date" v-model="filtro.de" @change="filter">
                </div>
                <div class="form-group col-md-2">
                    <label class="col-form-label col-form-label-sm">ate</label>
                    <input class="form-control form-control-sm" type="date" v-model="filtro.ate" @change="filter">
                </div>

                <div class="form-group col-6 col-md-3">
                    <label class="col-form-label col-form-label-sm">Mês</label>
                    <select name="tipo_movimentacao_id" id="tipo_movimentacao_id" class="form-control form-control-sm"  v-model="filtro.mes" @change="filter">
                        <option selected value="0">Todos</option>
                        <option value="1">Janeiro</option>
                        <option value="2">Fev</option>
                        <option value="3">Março</option>
                        <option value="4">Abril</option>
                        <option value="5">Maio</option>
                        <option value="6">Junho</option>
                        <option value="7">Julho</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                </div>
            </div>
        </div>
         <div class="form-row d-flex justify-content-between mt-4  mb-2" >
            <span class="badge badge-danger p-1"><strong> Contas a pagar : R$ {{formatarMoeda(totalizarpagar)}}</strong> </span>
            <span class="badge badge-success p-1"><strong> Contas a receber : R$ {{formatarMoeda(totalizarreceber)}}</strong> </span>
        </div>

        <div class=" border border-black shadow p-3 mb-4 bg-white rounded">
            <div class="form-row d-flex justify-content-between m-2 ">
                <select name="" id="" class="form-control form-control-sm col-md-1">
                    <option value=""></option>
                    <option value="">10</option>
                    <option value="">50</option>
                    <option value="">100</option>
                </select>
                <input class="form-control form-control-sm col-md-2" type="search" name="nome" placeholder="Buscar" v-model="buscar">
            </div>
            <div class="form-row m-2" >
                    <div class="table table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th scope="col" class="col-form-label col-form-label-sm">Descrição</th>
                                    <th scope="col" class="col-form-label col-form-label-sm">Valor a pagar</th>
                                    <th scope="col" class="col-form-label col-form-label-sm">Data do vencimento</th>
                                    <th scope="col" class="col-form-label col-form-label-sm">Usuário</th>
                                    <th scope="col" class="col-form-label col-form-label-sm">Movimentações</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="(provider,k) in movimentacoes" :key="k"  v-show="provider.tipo_movimentacao_id == 2">
                                    <td class="align-middle" style="font-size: 1em; ">{{provider.descricao}}</td>
                                    <td class="align-middle" style="font-size: 1em; ">{{provider.valor | money}}</td>
                                    <td class="align-middle" style="font-size: 1em; ">{{provider.dt_vencimento | momentDate}}</td>
                                    <td class="align-middle" style="font-size: 1em; ">{{provider.user.name}}</td>
                                    <td class="align-middle" style="font-size: 1em; "><span class="text-danger"><b>{{provider.tipo_movimentacao.descricao}}</b> </span></td>
                                </tr>
                                <tr v-for="(provider,k) in movimentacoes" :key="'y'+ k" v-show="provider.tipo_movimentacao_id == 1">
                                    <td class="align-middle" style="font-size: 1em; ">{{provider.descricao}}</td>
                                    <td class="align-middle" style="font-size: 1em; ">{{provider.valor | money}}</td>
                                    <td class="align-middle" style="font-size: 1em; ">{{provider.dt_vencimento | momentDate}}</td>
                                    <td class="align-middle" style="font-size: 1em; ">{{provider.user.name}}</td>
                                    <td class="align-middle" style="font-size: 1em; "><span class="text-success"><b>{{provider.tipo_movimentacao.descricao}}</b> </span></td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-show="movimentacoes == 0">
                            <div style="text-align:center;"><label class="col-form-label col-form-label-sm">Nenhum registro encontrado.</label> </div>
                        </div>
                    </div>
                </div>
            </div>
        <div>
            <span class="text-black mt-3"><b> Saldo :</b> R$ {{formatarMoeda(saldo)}}</span>
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
                tipo_movimentacao_id:0,
                de:null,
                ate:null,
                mes:0
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
        this.index()
        this.getTipo()
    },
    
    methods:{
        ...mapActions('Provider',['getProvider']),
        formatarMoeda(moeda){
            moeda = parseFloat(moeda);
            moeda = moeda.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+,)/g, "$1.");
            return moeda;
        },
        filter(){
            axios.post(`${API_BASE_URL}/filtromovi`,this.filtro).then(res => {
                this.movimentacoes = res.data
            
                this.movimentacoespagar = res.data
                let contasPagarFiltro = this.movimentacoespagar.filter(contasPagar => contasPagar.tipo_movimentacao_id == 2);
                
                let contasPagarValor = contasPagarFiltro.map(contasPagar => { 
                    return contasPagar.valor
                });
                this.movimentacoespagar = contasPagarValor

                this.movimentacoesreceber = res.data
                let contasReceberFiltro = this.movimentacoesreceber.filter(contasReceber => contasReceber.tipo_movimentacao_id == 1);
                
                let contasReceberValor = contasReceberFiltro.map(contasReceber => { 
                    return contasReceber.valor
                });
                this.movimentacoesreceber = contasReceberValor
            })
        },
        index(){
            axios.get(`${API_BASE_URL}/movimentacao/lista`).then(res => {
                this.movimentacoes = res.data
            
                this.movimentacoespagar = res.data
                let contasPagarFiltro = this.movimentacoespagar.filter(contasPagar => contasPagar.tipo_movimentacao_id == 2);
                
                let contasPagarValor = contasPagarFiltro.map(contasPagar => { 
                    return contasPagar.valor
                });
                this.movimentacoespagar = contasPagarValor

                this.movimentacoesreceber = res.data
                let contasReceberFiltro = this.movimentacoesreceber.filter(contasReceber => contasReceber.tipo_movimentacao_id == 1);
                
                let contasReceberValor = contasReceberFiltro.map(contasReceber => { 
                    return contasReceber.valor
                });
                this.movimentacoesreceber = contasReceberValor
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
        saldo(){
            return parseFloat(this.movimentacoesreceber) - parseFloat(this.movimentacoespagar) || 0
        }
    },
     filters:{
        money(value){
            if(value){
                return value ? parseFloat(value).toLocaleString('pt-BR',{style:'currency',currency:'BRL'}) : parseInt(value).toLocaleString('pt-BR',{style:'currency',currency:'BRL'})
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