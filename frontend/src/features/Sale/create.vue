<template>
  <div>
    <h4 cabecalho="product_id">Vendas</h4>
      <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
            <li class="breadcrumb-item"><router-link to="/sales">Vendas</router-link></li>
            <li class="breadcrumb-item active" aria-current="page">Criar</li>
        </ol>
      </nav>
      <div class="form-row">  
        <div class="form-group col-md-6">
          <label  class="col-form-label col-form-label-sm">Clientes</label>
            <select class="form-control form-control-sm" required v-model="client_id" name="client_id" v-validate = "'required'" data-vv-as="Cliente" :class="['form-control form-control-sm form-control form-control-sm-sm', {'is-invalid': errors.has('client_id')},`${errorsRequest.client_id  ? `is-invalid` : ``}`]">
              <option selected disabled value="">selecione</option>
              <option v-for="(client,indexCliente) in clients" v-show="client.status == 'Ativo'" :key="indexCliente"  :value="client.id">{{client.name}}</option>
            </select>
          <div v-show="submitted && errors.has('client_id')" class="invalid-feedback">{{ errors.first('client_id') }}</div>
          <div class="text-danger" v-if="errorsRequest.client_id">{{ errorsRequest.client_id[0] }}</div>
        </div>
        
          <div class="form-group col-md-6">
            <label  class="col-form-label col-form-label-sm">Data da Venda</label>
            <input type="date" name="datavenda" v-validate = "'required'" data-vv-as="Data Venda" required v-model="datavenda" class="form-control form-control-sm" :class="['form-control form-control-sm form-control form-control-sm-sm', {'is-invalid': errors.has('datavenda')},`${errorsRequest.dataVenda ? `is-invalid` : ``}`]" />
            <div v-if="submitted && errors.has('datavenda')" class="invalid-feedback">{{ errors.first('datavenda') }}</div>
            <div class="text-danger" v-if="errorsRequest.dataVenda">{{ errorsRequest.dataVenda[0] }}</div>
          </div>
        </div>
      
      <div class="border border-black shadow p-2 bg-white rounded">
        <div class="form-row d-flex-justify-content-around mb-2 ml-2" style="height:10px;" >
          <span class="col-10 "><b>Produtos</b> </span>
          <button type='button' class="btn btn-sm btn-info mr-1" @click="adiciona">
            <i class="fas fa-plus"></i>
          </button>
          <button  class="btn btn-sm btn-danger" @click="remova" ><i class="fa fa-times"></i></button>
        </div>
        <div class="form-row">   
          <div class="card-body">
            <div class="table table-sm" > 
              <div class="text-center">
                <div class="form-row" v-for="(detalheVenda,key) of details_sales" :key="key">
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
                      <input class="form-control form-control-sm" type="number" @change="getProducts(detalheVenda.estoque, key)" v-model="detalheVenda.estoque" required readonly>
                    </div>
                    <div class="col-2">
                      <label class="col-form-label col-form-label-sm"><strong>Quantidade</strong></label>
                      <input  :disabled="loading" class="form-control form-control-sm"  :name="`quantidade${key}`" type="text" data-vv-as="Quantidade" v-validate="'required'" :class="['form-control form-control-sm form-control form-control-sm-sm', {'is-invalid': errors.has(`quantidade${key}`)},`${errorsRequest[`details_sales.${key}.quantidade`] ? `is-invalid` : ``}`]" v-model="detalheVenda.quantidade" @change="calculateLineTotal(detalheVenda)" @input="calculateEstoque(detalheVenda)">
                      <span v-show="errors.has(`quantidade${key}`)" class="invalid-feedback">{{ errors.first(`quantidade${key}`) }}</span>
                        <span class="invalid-feedback">
                          {{ `${errorsRequest[`details_sales.${key}.quantidade`] ? errorsRequest[`details_sales.${key}.quantidade`] : `` }` }}<br>
                        </span> 
                    </div>
                    <div >
                      <div  style="margin-top:30px;" @click="inc(detalheVenda)">
                        <b><i class="fa fa-sort-up"></i></b>
                      </div>
                      <div style="margin-top:-15px;" @click="dec(detalheVenda)">
                      <b><i class="fa fa-sort-down"></i></b>
                      </div>
                    </div>
                    <div class="col-3">
                      <label class="col-form-label col-form-label-sm"><strong>Subtotal</strong></label>
                      <money readonly disabled :value="detalheVenda.subtotal" v-bind="money" name="totalPrejuizo" class="form-control form-control-sm"></money>
                    </div>
                </div>
              </div>
            </div>
          
            <div class="form-row">
                <span class="alert alert-primary text-black p-1"><strong> Total da Venda : R$ {{formatarMoeda(totalizar)}}</strong> </span>
            </div>
          </div>
        </div>
      </div>

      <div class="border border-black shadow mt-3 mb-3 bg-white rounded" v-if="total >  0">
        <div class="border border-black p-2" style="background-color:GhostWhite	">
          <span><strong>Pagamento</strong></span>
        </div>
      <div class="form-row">
        <div>
          <div class="card-body m-0">
            <div class="form-row">
              <div class="form-group m-2">
                <label class="col-form-label col-form-label-sm">Forma de Pagamento</label>
                <select type="text" class="form-control form-control-sm" required v-model="formapagamento.tipo_forma_pagamento" >
                  <option disabled selected value="null">Selecione</option>
                  <option value="0">Boleto bancário</option>
                  <option value="1">A vista</option>
                  <option value="2">Cartao de crédito</option>
                  <option value="3">Cartao de débito</option>
                </select>
              </div>

              <div class="form-group m-2">
                <label class="col-form-label col-form-label-sm">Parcelas</label>
                <select type="text" class="form-control form-control-sm" v-model="formapagamento.parcelas" v-show="formapagamento.tipo_forma_pagamento == '2'">
                  <option selected :value="null">Selecione</option>
                  <option :value="1">1x</option>
                  <option :value="6">6x</option>
                  <option :value="10">10x</option>
                  <option :value="12">12x</option>
                  <option :value="24">24x</option>
                </select>

                <select type="text" class="form-control form-control-sm" v-model="formapagamento.parcelas" @change="valorCreditoFunction(formapagamento.parcelas)" disabled v-show="formapagamento.tipo_forma_pagamento !== '2'">
                  <option selected value="null">1x</option>
                  <option :value="1">6x</option>
                  <option :value="2">10x</option>
                  <option :value="3">12x</option>
                  <option :value="4">24x</option>
                </select>
              </div>

              <div class="form-group col-2 m-2">
                <label class="col-form-label col-form-label-sm">Entrada</label>
                <input type="text" class="form-control form-control-sm" v-show="formapagamento.tipo_forma_pagamento == '2'"  v-model="formapagamento.entrada" placeholder="0,00">
                <input type="text" class="form-control form-control-sm" v-show="formapagamento.tipo_forma_pagamento !== '2'" disabled  v-model="formapagamento.entrada" placeholder="0,00">
              </div>

              <div class="form-group m-2" v-show="formapagamento.parcelas">
                <label class="col-form-label col-form-label-sm">Parcelas de :</label>
                <p aria-disabled="disabled" v-show="formapagamento.tipo_forma_pagamento == '2' && formapagamento.parcelas != null" class="form-control form-control-sm col-form-label col-form-label-sm"><span>{{formapagamento.parcelas }} {{ 'x' }} {{parcelamento | money}}</span></p>
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
import {VMoney} from 'v-money'
import 'jspdf-autotable' 

export default {
  directives: {money: VMoney},
  data(){
    return {
      disabled:false,
      loading:true,
      valorCreditoData:null,
      result: 0,
      details_sales:[{
        product_id:'',
        quantidade:'',
        subtotal:0,
        price:'',
        name:'',
        estoque:''
      }],
      client_id:'',
      datavenda:'',
      total:0,
      formapagamento:{
        tipo_forma_pagamento:null,
        parcelas:null,
        entrada:null
      },
      submitted: false,
      errorsRequest:[],
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
    this.getProducts(),
    this.$store.dispatch('Client/getClient')
    this.$store.dispatch('Product/getProducts')
  },
  methods:{
  getProducts(product,key){
    if(product) {
      axios.get(`http://localhost:8000/api/product/${product}`).then(res => {
        this.details_sales[key].product_id = res.data[0].id
        this.details_sales[key].name = res.data[0].name
        this.details_sales[key].id = res.data[0].id
        this.details_sales[key].price = res.data[0].price
        this.details_sales[key].estoque = res.data[0].estoque   
        this.details_sales[key].subtotal = 0   
      })
    }
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
        axios.post('http://localhost:8000/api/sales',{
            client_id:this.client_id,
            dataVenda:this.datavenda,
            total:this.total,
            details_sales:this.details_sales,
            formapagamento:this.formapagamento
            
        }).then((res) => {
          let usuario = res.data.resultado.user_id
          let indexCliente = this.client_id - 1
          this.submitContaReceber(indexCliente)
          this.$noty.success("Cadastrado com sucesso!!")
          if(usuario === 1) {
            return this.$router.push('/sales')
          }else {
          return  this.$router.push('/vendas')
          }
        
        })
        .catch(error => {
       if (error.response.status === 422) {
          this.errorsRequest = error.response.data.errors;
        }
       });
        }else {
    //         
        }
    })
  },
    inc(detalheVenda){
      if(detalheVenda.estoque){
        detalheVenda.quantidade ++
        detalheVenda.estoque --
      }  
      this.calculateLineTotal(detalheVenda)
    },
    dec(detalheVenda){
      if(detalheVenda.quantidade > 0){
        detalheVenda.quantidade --
        detalheVenda.estoque ++
      }  
       this.calculateLineTotal(detalheVenda)
    },
    remova(){
      if(this.details_sales.length > 1) {
        this.details_sales.pop({product_id:'',price:'',quantidade:'',subtotal:''})
        this.$toasted.global.defaultSuccess()
      }
    },

    adiciona(){
      if(this.details_sales.length <= 2) {
        this.details_sales.push({product_id:'',quantidade:'',subtotal:'',name:'',price:'',estoque:''})
      }else {
        return this.details_sales
      }
      this.$toasted.global.defaultSuccess()
    },

    calculateLineTotal(detalheVenda){
      let total = parseFloat(detalheVenda.price) * parseFloat(detalheVenda.quantidade) || 0
      detalheVenda.subtotal = total.toFixed(2) ? total.toFixed(2) : 0
    },
    calculateEstoque(detalheVenda) {
     //  parseInt(detalheVenda.quantidade.replace(/\D/g, ''))
      setTimeout(function(){ 
        detalheVenda.estoque - 1
        detalheVenda.quantidade +  1
        if(detalheVenda.estoque < 0 && detalheVenda.estoque !== null){
          this.loading = true
          detalheVenda.quantidade = 0
          this.$noty.error("Produto sem estoque!,favor colocar outro produto") 
          this.disabled = true
          this.disabled = false
        }else{
          this.loading = false
        }
      }.bind(this),2000)
      
    },
    valorCreditoFunction(parcelas){
      this.formapagamento.parcelas = parcelas
    },
    submitContaReceber(indexCliente){
      axios.post(`http://localhost:8000/api/billstoreceive`,{
        descricao:this.clients[indexCliente].name,
        valor:this.total,
        situacao_id:1,
      }) .then(() => {

      })
    }
  },
  computed:{
    ...mapState('Client',{clients:state => state.clients}),
    ...mapState('Product',{products:state => state.products}),

    totalizar() {
      return  this.details_sales.reduce((total,detalheVenda) => {
          return this.total =  parseFloat(total) + parseFloat(detalheVenda.subtotal) || 0
      },0)
    },
    parcelamento(){
      return this.total / this.formapagamento.parcelas || 0
    },
  },
  filters:{
    money(value){
      if(value){
        return value = parseFloat(value).toLocaleString('pt-BR',{style:'currency',currency:'BRL'}) 
      }
    },
  },
}
</script>