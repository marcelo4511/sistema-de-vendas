<template>
<div>
    <h4 cabecalho="Produto">Movimentações</h4>
        <nav aria-label="breadcrumb mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Movimentações</li>
            </ol>
        </nav>

        <div class=" border border-black shadow p-3 bg-white rounded">
            <div class="form-row">
                <div class="col-12 d-flex justify-content-beetween mb-2">
                    <div class="form-group col-4 col-md-3">
                        <select name="tipo_movimentacao_id" id="tipo_movimentacao_id" class="form-control form-control-sm"  v-model="filtro.tipo_movimentacao_id" @change="filter">
                            <option selected value="0">Todos</option>
                            <option v-for="tipo in tipos" :value="tipo.id" :key="tipo.id">{{tipo.descricao}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <input class="form-control form-control-sm" type="date" v-model="filtro.de" @change="filter">
                    </div>
                    <div class="form-group col-md-2">
                        <input class="form-control form-control-sm" type="date" v-model="filtro.ate" @change="filter">
                    </div>

                    <div class="form-group col-4 col-md-3">
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
                <input class="form-control form-control-sm col-md-2" type="search" name="nome" placeholder="Buscar" v-model="buscar">
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between" >
                <span class="h6 alert alert-danger p-1"><strong> Contas a pagar : R$ {{formatarMoeda(totalizarpagar)}}</strong> </span>
                <span class="h6 alert alert-success p-1"><strong> Contas a receber : R$ {{formatarMoeda(totalizarreceber)}}</strong> </span>
            </div>
          
            <div class="table table-responsive scroll" ref="scroll" style="overflow-y:auto;height:250px;margin-top:1vh;">
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
                        <tr v-for="(provider,k) in movimentacoes" :key="k">
                            <td class="align-middle" style="font-size: 1em; ">{{provider.descricao}}</td>
                            <td class="align-middle" style="font-size: 1em; ">{{provider.valor | money}}</td>
                            <td class="align-middle" style="font-size: 1em; ">{{provider.dt_vencimento | momentDate}}</td>
                            <td class="align-middle" style="font-size: 1em; ">{{provider.user.name}}</td>
                            <td class="align-middle" v-show="provider.tipo_movimentacao_id == 2" style="font-size: 1em; "><span class="text-danger"><b>{{provider.tipo_movimentacao.descricao}}</b> </span></td>
                            <td class="align-middle" v-show="provider.tipo_movimentacao_id == 1"><span class="text-success"><b>{{provider.tipo_movimentacao.descricao}}</b> </span></td>
                        </tr>
                        <tr v-if="loading"><td colspan="7" align="center" ><i  class="mt-2 spinner-border spinner-border spinner text-primary" role="status" aria-hidden="true"></i></td></tr>
                        <tr v-if="loading == false && movimentacoes.length == 0"><td colspan="7"  align="center" style="border:0;margim-bottom:2px;"><label class="col-form-label col-form-label-sm">Nenhum registro encontrado.</label></td></tr>
                    </tbody>
                </table>
                <div v-show="movimentacoes == 0">
                    <div style="text-align:center;"><label class="col-form-label col-form-label-sm">Nenhum registro encontrado.</label> </div>
                </div>
            </div>
        </div>
            
        <div class="mt-3">
            <span v-if="saldo < 0" class="text-danger mt-3"><b> Saldo : R$ {{formatarMoeda(saldo)}} </b></span>
            <span v-if="saldo >= 0" class="text-success mt-3"><b> Saldo : R$ {{formatarMoeda(saldo)}} </b></span>
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
                mes:moment().format('M')
            },
            movimentacoes:[],
            movimentos:[],
            movimentacoespagar:[],
            movimentacoesreceber:[],
            buscar:[],
            totalApagar: [],
            totalReceber:[],
            tipos:[]
        }
    },
    created(){
        this.$store.dispatch('Provider/getProvider')
        this.getTipo()
        this.filter()
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
        getTipo(){
            axios.get(`${API_BASE_URL}/tipo`).then(res => {
                this.tipos = res.data
            })
        },
    },
    computed:{
        totalizarpagar(){
            return this.movimentacoespagar.reduce((acumulador,valor) => {
                return this.totalApagar = parseFloat(acumulador) + parseFloat(valor)
            },0) 
        },
        totalizarreceber(){
            return this.movimentacoesreceber.reduce((acumulador,valor) => {
                return this.totalReceber = parseFloat(acumulador) + parseFloat(valor)
            },0) 
        },
        saldo(){
            if(this.movimentacoespagar == 0 && this.movimentacoesreceber == 0) {
                return 0
            }else {
                return parseFloat(this.totalReceber) - parseFloat(this.totalApagar) || 0
            }
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
  .scroll::-webkit-scrollbar {
    height: 10px;
    width: 10px;
  }

.scroll::-webkit-scrollbar-track {
  background: #f1f1f1;
}

.scroll::-webkit-scrollbar-thumb {
  background: linear-gradient(to right, #1e469a, #49a7c1);;
  border-radius: 10px;
}
</style>