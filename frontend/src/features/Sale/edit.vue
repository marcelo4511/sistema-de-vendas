<template>
  <div>
    <h4 cabecalho="product_id">Vendas</h4>
      <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
           <li class="breadcrumb-item"><router-link to="/sales">Vendas</router-link></li>
          <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
      </nav>
    <div class="form-row">  
        <div class="form-group col-md-6">
          <label  class="col-form-label col-form-label-sm">Clientes</label>
            <select class="form-control form-control-sm" required  v-model="sales.client_id" name="client_id" v-validate = "'required'" data-vv-as="Cliente" :class="['form-control form-control-sm form-control form-control-sm-sm', {'is-invalid': errors.has('client_id')},`${errorsRequest.client_id  ? `is-invalid` : ``}`]">
              <option selected disabled value="">selecione</option>
              <option v-for="(client,indexCliente) in clients" v-show="client.status == 'Ativo'" :key="indexCliente"  :value="client.id">{{client.name}}</option>
            </select>
          <div v-show="submitted && errors.has('client_id')" class="invalid-feedback">{{ errors.first('client_id') }}</div>
          <div class="text-danger" v-if="errorsRequest.client_id">{{ errorsRequest.client_id[0] }}</div>
        </div>
        
        <div class="form-group col-md-6">
          <label  class="col-form-label col-form-label-sm">Data da Venda</label>
          <input type="date" name="datavenda" v-validate = "'required'" data-vv-as="Data Venda" required v-model="sales.dataVenda" class="form-control form-control-sm" :class="['form-control form-control-sm form-control form-control-sm-sm', {'is-invalid': errors.has('datavenda')},`${errorsRequest.dataVenda ? `is-invalid` : ``}`]" />
          <div v-if="submitted && errors.has('datavenda')" class="invalid-feedback">{{ errors.first('datavenda') }}</div>
          <div class="text-danger" v-if="errorsRequest.dataVenda">{{ errorsRequest.dataVenda[0] }}</div>
        </div>
      </div>
      
      <div class="border border-black shadow p-2 bg-white rounded">
        <div class="form-row d-flex justify-content-between align-items-center mb-1" >
          <span class="col-11"><b>Produtos</b> </span>
          <div>
            <button type='button' class="btn btn-sm btn-info mr-1" @click="adiciona">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <hr class="border border-black" style=" margin:0 !important;"/>
        <div class="form-row">   
          <div class="card-body">
            <div class="table table-sm" > 
                <div class="form-row d-flex justify-content-between" v-for="(detalheVenda,key) of sales.details_sales" :key="key">
                    <div class="col-2">
                      <label class="col-form-label col-form-label-sm "><strong>Produto</strong></label>
                        <select class="form-control form-control-sm"  :name="`product_id_${key}`" data-vv-as="Produto" v-validate="'required'" :class="['form-control form-control-sm form-control form-control-sm-sm', {'is-invalid': errors.has(`product_id_${key}`)},`${errorsRequest[`details_sales.${key}.product_id`] ? `is-invalid` : ``}`]"  :disabled="disabled" required v-model="detalheVenda.product_id" @change="getProducts(detalheVenda.product_id,key), calculateEstoque(detalheVenda)">
                          <option v-for="(product) in products" :key="product.id"  v-show="product.status == 'Ativo'" :value="product.id">{{product.name}}</option>
                        </select>
                        <span v-show="errors.has(`product_id_${key}`)" class="invalid-feedback">{{ errors.first(`product_id_${key}`) }}</span>
                        <span class="invalid-feedback">
                          {{ `${errorsRequest[`details_sales.${key}.product_id`] ? errorsRequest[`details_sales.${key}.product_id`] : `` }` }}<br>
                        </span> 
                    </div>
                    <div class="col-2">
                      <label class="col-form-label col-form-label-sm"><strong>Preço</strong></label>
                      <money v-model="detalheVenda.price" :name="`price_${key}`" data-vv-as="Preço" v-validate="'min_value:0.01'" :class="['form-control form-control-sm', {'is-invalid': errors.has(`price_${key}`)},`${errorsRequest[`details_sales.${key}.price`] ? `is-invalid` : ``}`]" :value="detalheVenda.price" @change="getProducts(detalheVenda.price,key),calculateLineTotal(detalheVenda)"  v-bind="money" class="form-control form-control-sm" readonly></money>
                      <span v-show="errors.has(`price_${key}`)" class="invalid-feedback">{{ errors.first(`price_${key}`) }}</span>
                        <span class="invalid-feedback">
                          {{ `${errorsRequest[`details_sales.${key}.price`] ? errorsRequest[`details_sales.${key}.price`] : `` }` }}<br>
                        </span> 
                    </div>
                    <div class="col-2">
                      <label class="col-form-label col-form-label-sm"><strong>Estoque</strong></label>
                      <input class="form-control form-control-sm" type="number" @change="getProducts(detalheVenda.products.estoque, key)" v-model="detalheVenda.products.estoque" required readonly>
                    </div>
                    <div class="col-2">
                      <label class="col-form-label col-form-label-sm"><strong>Quantidade</strong></label>
                      <input  :disabled="loading" class="form-control form-control-sm"  :name="`quantidade${key}`" type="number" data-vv-as="Quantidade" readonly 
                      v-validate="'required|min_value:1'" :class="['form-control form-control-sm form-control form-control-sm-sm', {'is-invalid': errors.has(`quantidade${key}`)},`${errorsRequest[`details_sales.${key}.quantidade`] ? `is-invalid` : ``}`]" v-model="detalheVenda.quantidade" @change="calculateLineTotal(detalheVenda)" @input="calculateEstoque(detalheVenda)">
                      <span v-show="errors.has(`quantidade${key}`)" class="invalid-feedback">{{ errors.first(`quantidade${key}`) }}</span>
                        <span class="invalid-feedback">
                          {{ `${errorsRequest[`details_sales.${key}.quantidade`] ? errorsRequest[`details_sales.${key}.quantidade`] : `` }` }}<br>
                        </span> 
                    </div>
                    <div>
                      <div style="margin-top:30px;" @click="incrementar(detalheVenda)">
                        <b><i class="fa fa-sort-up"></i></b>
                      </div>
                      <div style="margin-top:-15px;" @click="decrementar(detalheVenda)">
                      <b><i class="fa fa-sort-down"></i></b>
                      </div>
                    </div>
                    <div class="col-3">
                      <label class="col-form-label col-form-label-sm"><strong>Subtotal</strong></label>
                      <money readonly disabled :value="detalheVenda.subtotal" v-bind="money" name="totalPrejuizo" class="form-control form-control-sm"></money>
                    </div>
                    <button class="btn btn-sm btn-danger mt-4 mb-4" style="height:40px;" :disabled ="sales.details_sales.length == 1" data-toggle="modal" :data-target="`#detalhe${detalheVenda.id}`"><i class="fa fa-trash"></i></button>
                     <modal class="del" :title="`Deseja remover o produto ? `" :compl="``"  :name="`detalhe${detalheVenda.id}` ">
                        <div class="modal-body text-left" >
                          <button class="btn btn-sm btn-primary mr-2" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>  
                          <button class="btn btn-sm btn-danger" @click="deletaDetalheProduto(detalheVenda.id,key)" :disabled="loading">
                            <i v-if="loading" class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true"></i>
                            <i v-else class="fa fa-trash"></i>
                            Deletar
                          </button>
                        </div>
                    </modal>
                </div>
            </div>
          
            <div class="form-row" v-if="sales.details_sales.length > 0">
                <span class="alert alert-primary text-black p-1"><strong> Total da Venda : R$ {{formatarMoeda(totalizar)}}</strong> </span>
            </div>
          </div>
        </div>
      </div>

      <div class="border border-black shadow mt-3 mb-3 bg-white rounded" v-if="sales.total >  0">
        <div class="border border-black p-2" style="background-color:GhostWhite	">
          <span><strong>Pagamento</strong></span>
        </div>
        <div class="form-row">
          <div>
            <div class="card-body m-0">
              <div class="form-row">
                <div class="form-group m-2">
                  <label class="col-form-label col-form-label-sm">Forma de Pagamento</label>
                  <select type="text" class="form-control form-control-sm" required v-model="sales.forma_pagamento.tipo_forma_pagamento" >
                    <option disabled selected value="null">Selecione</option>
                    <option value="0">Boleto bancário</option>
                    <option value="1">A vista</option>
                    <option value="2">Cartao de crédito</option>
                    <option value="3">Cartao de débito</option>
                  </select>
                </div>

            
                <div class="form-group m-2" v-if="sales.forma_pagamento.tipo_forma_pagamento == 2">
                    <label class="col-form-label col-form-label-sm">Parcelas</label>
                    <select type="text" class="form-control form-control-sm" v-model="sales.forma_pagamento.parcelas" v-show="sales.forma_pagamento.tipo_forma_pagamento == '2'">
                      <option selected :value="null">Selecione</option>
                      <option :value="1">1x</option>
                      <option :value="6">6x</option>
                      <option :value="10">10x</option>
                      <option :value="12">12x</option>
                      <option :value="24">24x</option>
                    </select>

                    <select type="text"  v-if="sales.forma_pagamento.tipo_forma_pagamento == 2" class="form-control form-control-sm" v-model="sales.forma_pagamento.parcelas" @change="valorCreditoFunction(sales.forma_pagamento.parcelas)" disabled v-show="sales.forma_pagamento.tipo_forma_pagamento !== '2'">
                      <option selected value="null">1x</option>
                      <option :value="1">6x</option>
                      <option :value="2">10x</option>
                      <option :value="3">12x</option>
                      <option :value="4">24x</option>
                    </select>
                  </div>

                  <div class="form-group col-2 m-2"  v-if="sales.forma_pagamento.tipo_forma_pagamento == 2">  
                    <label class="col-form-label col-form-label-sm">Entrada</label>
                    <input type="text" class="form-control form-control-sm" v-show="sales.forma_pagamento.tipo_forma_pagamento == '2'"  v-model="sales.forma_pagamento.entrada" placeholder="0,00">
                    <input type="text" class="form-control form-control-sm" v-show="sales.forma_pagamento.tipo_forma_pagamento !== '2'" disabled  v-model="sales.forma_pagamento.entrada" placeholder="0,00">
                  </div>

                  <div class="form-group m-2" v-show="sales.forma_pagamento.parcelas"  v-if="sales.forma_pagamento.tipo_forma_pagamento == 2">
                    <label class="col-form-label col-form-label-sm">Parcelas de :</label>
                    <p aria-disabled="disabled" v-show="sales.forma_pagamento.tipo_forma_pagamento == '2' && sales.forma_pagamento.parcelas != null" class="form-control form-control-sm col-form-label col-form-label-sm"><span>{{sales.forma_pagamento.parcelas }} {{ 'x' }} {{parcelamento | money}}</span></p>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button type="submit" @click="onSubmit" class="btn btn-sm btn-success mt-2">Cadastrar</button>
  </div>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapState} from 'vuex'
import axios from 'axios'
import {API_BASE_URL} from '../../config/Api'
import {VMoney} from 'v-money'
import 'jspdf-autotable' 
import $ from 'jquery'
export default {
  name:'salesedit',
  directives: {money: VMoney},
  components:{
    Modal: () => import('../Modal/modal.vue')
  },
  data(){
    return {
      disabled:false,
      loading:false,
      submitted: false,
      errorsRequest:[],
      client_id:'',
      datavenda:'',
      sales:{
        total:0,
        details_sales:[{
        id:'',product_id:'',price:'',quantidade:'',products:{estoque:''},subtotal:0,
        }],
        forma_pagamento:{
          tipo_forma_pagamento:null,parcelas:null,entrada:null
        }
      },
       money: {
        decimal: ',',
        thousands: '.',
        prefix: 'R$ ',
        suffix: '',
        precision: 2,
        masked: false
      }
    }
  },
  created(){
    this.getVenda(this.$route.params.id)
    this.$store.dispatch('Client/getClient')
    this.$store.dispatch('Product/getProducts')
  
  },
  mounted() {
      this.getProducts()
  },
  methods:{
    getVenda(id){
      axios.get(`${API_BASE_URL}/sales/${id}`).then((response) => {
        this.sales = response.data
      })
    },
    getProducts(product,key){
      if(product) {
        axios.get(`${API_BASE_URL}/product/${product}`).then(res => {
          this.sales.details_sales[key].product_id = res.data[0].id
          this.sales.details_sales[key].name = res.data[0].name
          this.sales.details_sales[key].id = res.data[0].id
          this.sales.details_sales[key].price = res.data[0].price
          this.sales.details_sales[key].quantidade = 0
          this.sales.details_sales[key].products.estoque = res.data[0].estoque   
          this.sales.details_sales[key].subtotal = 0   
        })
      }
    },
    calculateEstoque(detalheVenda) {
      let estoque =  parseInt(detalheVenda.estoque) - parseInt(detalheVenda.quantidade) || parseInt(detalheVenda.estoque)
      detalheVenda.estoque = estoque
    },
    formatarMoeda(moeda){
      moeda = parseFloat(moeda);
      moeda = moeda.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+,)/g, "$1.");
      return moeda;
    },
 onSubmit(){
    this.submitted = true;
    this.$validator.validate().then(res=>{
      if(res) {
      axios.put(`${API_BASE_URL}/sales/${this.$route.params.id}`,this.sales).then((res) => {
        console.log(this.sales)
        let usuario = res.data.resultado.user_id
        this.$noty.success("Atualizado com sucesso!!")
        if(usuario === 1) {
          return this.$router.push('/sales')
        }else {
          return  this.$router.push('/vendas')
        }
      
      })
      .catch(error => {
      if (error.response.status === 422) {
        this.errorsRequest = error.response.data.errors;
      }else {
        this.$noty.info('houve um problema na edição')
      }
      });
      }
    })
  },
    deletaDetalheProduto(detalheVenda,key){
      if(detalheVenda){
        this.loading = true
        axios.delete(`${API_BASE_URL}/detalhesdelete/${detalheVenda}`).then(() => {
          this.$noty.success("Deletado com sucesso!!")
          this.sales.details_sales.splice(key,1)
          this.loading = false
          $('.del').modal('hide');
        })
        }else {
        this.loading = true
        this.sales.details_sales.splice(key,1)
        this.$noty.success("Deletado com sucesso!!")
        this.loading = false
        $('.del').modal('hide');
      }
    },
    calculateLineTotal(detalheVenda){
      var total = parseFloat(detalheVenda.price) * parseFloat(detalheVenda.quantidade) || 0
      detalheVenda.subtotal = total.toFixed(2);
      return detalheVenda.price && detalheVenda.quantidade
    },
     incrementar(detalheVenda){
      if(detalheVenda.products.estoque){
        detalheVenda.quantidade ++
        detalheVenda.products.estoque --
      }  
      this.calculateLineTotal(detalheVenda)
    },
    decrementar(detalheVenda){
      if(detalheVenda.quantidade > 0){
        detalheVenda.quantidade --
        detalheVenda.products.estoque ++
      }  
    this.calculateLineTotal(detalheVenda)
    },
    adiciona(){
      if(this.sales.details_sales.length <= 2) {
        this.sales.details_sales.push({id:'',product_id:'',quantidade:'',subtotal:'',name:'',price:'',products:{estoque : ''}})
      }else {
        return this.details_sales
      }
      this.$toasted.global.defaultSuccess()
    },
  },
  computed:{
     ...mapState('Client',{clients:state => state.clients}),
     ...mapState('Product',{products:state => state.products}),

     totalizar() {
      return this.sales.details_sales.reduce((total,detalheVenda) => {
        return this.sales.total =  parseFloat(total) + parseFloat(detalheVenda.subtotal) || this.sales.total
      },0)
    },
    parcelamento(){
      return this.sales.total / this.sales.forma_pagamento.parcelas || 0
    },
  },  
  filters:{
    money(value){
      if(value){
        return value = parseFloat(value).toLocaleString('pt-BR',{style:'currency',currency:'BRL'}) 
      }
    },
  }
}
</script>

<style>
 div fieldset {
     border: black solid 3px;
     border-radius: 10px;
 }
</style>