<template>
  <div>
      <h4 cabecalho="Produto">Contas a Pagar</h4>
        <nav aria-label="breadcrumb mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/billstopay">Contas a Pagar</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Criar</li>
            </ol>
        </nav>
      <form @submit.prevent="onSubmit" class="form-group">
        <div class="row">  
            <div class="form-group col-md-6 col-lg-3">
                <label for="">Descrição</label>
                <input type="text" class="form-control form-control-sm" v-model="provider.descricao" required>
            </div>
            <div class="form-grouṕ col-md-6 col-lg-3">
                <label for="">Valor</label>
                <input type="text" class="form-control form-control-sm" v-money="money" v-model="provider.valor"  required>
            </div>
            <div class="form-group col-md-6 col-lg-3">
                <label for="">Data do vencimento</label>
                <input type="date" class="form-control form-control-sm" v-model="provider.dt_vencimento" required>
            </div>
            <div class="form-group col-md-6 col-lg-3">
                <label for="">Comprovante</label>
                <input type="file" class="form-control form-control-sm" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-10 col-lg-10">
                <button class="btn btn-sm btn-success" type="submit">Salvar</button>
            </div>
        </div>
      </form>
  </div>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapActions,mapState} from 'vuex'
import {mask} from 'vue-the-mask'
export default {
     directives: {mask},
    name:'providerstore',

    data(){
        return{
            provider:{
                descricao:'',
                valor:'',
                dt_vencimento:'',
                tipo_movimentacao_id:2,
            },
            money: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                precision: 2,
                masked: false 
            },
        }
    },

    methods:{
        ...mapActions('BillsToPay',['postProvider']),
        onSubmit(){
            this.$store.dispatch('BillsToPay/postProvider',this.provider).then((() => {
            this.$noty.success("Cadastrado com sucesso!!")
            }))
        },
    },
    computed:{
        ...mapState('BillsToPay',{billstopay:state => state.billstopays}),
    },
    watch:{
        'provider.descricao': function(descricao){
            if(descricao) {
                return this.provider.descricao = descricao[0].toUpperCase() + descricao.substr(1)  
            }else if(descricao == undefined){
                return null
            }
        }
    },
}
</script>

<style>
    span{
        cursor: pointer;
    }
</style>