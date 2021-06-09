<template>
  <div>
    <h4>Compra</h4>
      <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
            <li class="breadcrumb-item"><router-link to="/compras">Compra</router-link></li>
            <li class="breadcrumb-item active" aria-current="page">Criar</li>
        </ol>
      </nav>
      <div class="form-row">  
        <div class="form-group col-md-6">
          <label  class="col-form-label col-form-label-sm">Fornecedores</label>
            <select class="form-control form-control-sm" required v-model="compra.fornecedor_id" name="fornecedor_id"
              v-validate = "'required'" data-vv-as="Fornecedor"
              :class="['form-control form-control-sm form-control form-control-sm-sm', {'is-invalid': errors.has('fornecedor_id')},`${errorsRequest.fornecedor_id  ? `is-invalid` : ``}`]">
              <option selected disabled value="">selecione</option>
              <option v-for="(fornecedor,indexFornecedor) in fornecedores" :key="indexFornecedor"  :value="fornecedor.id">{{fornecedor.name}}</option>
            </select>
          <div v-show=" errors.has('fornecedor_id')" class="invalid-feedback">{{ errors.first('fornecedor_id') }}</div>
        </div>
        
        <div class="form-group col-md-6">
          <label  class="col-form-label col-form-label-sm">Data da Compra</label>
          <input type="date" name="data_compra"
            v-validate = "'required'"
            data-vv-as="Data Venda"
            required v-model="compra.data_compra"
            class="form-control form-control-sm" :class="['form-control form-control-sm form-control form-control-sm-sm', {'is-invalid': errors.has('data_compra')},`${errorsRequest.data_compra ? `is-invalid` : ``}`]" />
          <div v-if=" errors.has('data_compra')" class="invalid-feedback">{{ errors.first('data_compra') }}</div>
        </div>
      </div>
      
      <div class="border border-black shadow p-2 bg-white rounded">
        <div class="form-row d-flex justify-content-between align-items-center m-1" >
          <span><b>Produtos</b> </span>
          <div>
            <button type='button' class="btn btn-sm btn-info mr-1"  @click="adiciona()">
              <i class="fas fa-plus"></i>
            </button>
            <button  class="btn btn-sm btn-danger" @click="remova"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <hr class="border shadow-lg border-black" style=" margin:0 !important;"/>
        <div class="form-row">   
          <div class="card-body">
            <div class="table table-sm" > 
                <div class="form-row d-flex justify-content-between" v-for="(detalheCompra,key) of compra.products" :key="key">
                    <div class="col-4">
                      <label class="col-form-label col-form-label-sm "><strong>Produto</strong></label>
                        <select class="form-control form-control-sm"  :name="`id_${key}`" data-vv-as="Produto" v-validate="'required'" :class="['form-control form-control-sm form-control form-control-sm-sm', {'is-invalid': errors.has(`id_${key}`)},`${errorsRequest[`details_sales.${key}.id`] ? `is-invalid` : ``}`]"  :disabled="disabled" required v-model="detalheCompra.id" >
                          <option v-for="(product) in produtos" :key="product.id"  v-show="product.status == 'Ativo'" :value="product.id">{{product.name}}</option>
                        </select>
                        <span v-show="errors.has(`id_${key}`)" class="invalid-feedback">{{ errors.first(`id_${key}`) }}</span>
                    </div>

                    <div class="col-2">
                      <label class="col-form-label col-form-label-sm"><strong>Preço</strong></label>
                      <money v-model="detalheCompra.price" :name="`price_${key}`" data-vv-as="Preço" v-validate="'min_value:0.01'" 
                      :class="['form-control form-control-sm', {'is-invalid': errors.has(`price_${key}`)},`${errorsRequest[`details_sales.${key}.price`] ? `is-invalid` : ``}`]" 
                      :value="detalheCompra.price"  v-bind="money" class="form-control form-control-sm"></money>
                      <span v-show="errors.has(`price_${key}`)" class="invalid-feedback">{{ errors.first(`price_${key}`) }}</span>
                    </div>

                    <div class="col-2">
                      <label class="col-form-label col-form-label-sm"><strong>Estoque</strong></label>
                      <input class="form-control form-control-sm" type="number" v-model="detalheCompra.estoque" required>
                    </div>

                    <div>
                      <div style="margin-top:30px;">
                        <b><i class="fa fa-sort-up"></i></b>
                      </div>
                      <div style="margin-top:-15px;">
                        <b><i class="fa fa-sort-down"></i></b>
                      </div>
                    </div>

                    <div class="col-3">
                      <label class="col-form-label col-form-label-sm"><strong>Subtotal</strong></label>
                      <money readonly disabled :value="detalheCompra.subtotal" v-bind="money" name="totalPrejuizo" class="form-control form-control-sm"></money>
                    </div>
                </div>
            </div>
          
          </div>
        </div>
      </div>

    <button type="submit" @click="onSubmit" class="btn btn-sm btn-success mt-2" :disabled="loading"><i v-if="loading" class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true"></i>Cadastrar</button>
  </div>
</template>

<script>
import axios from 'axios'
import {VMoney} from 'v-money'
import {API_BASE_URL} from '../../config/Api'
export default {
     directives: {money: VMoney},
    data() {
        return {
            disabled:false,
            loading:false,
            fornecedores:[],
            produtos:[],
            errorsRequest:[],
            compra:{
                data_compra:null,
                total:null,
                fornecedor_id:0,
                products:[{
                    id:'',price:'',estoque:'',subtotal:0,
                }],
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
        this.getFornecedores()
        this.getProdutos()
    },
    methods:{
        getProdutos(){
          axios.get(`${API_BASE_URL}/products`).then(res => {
            this.produtos = res.data
          })
        },
        getFornecedores(){
            axios.get(`${API_BASE_URL}/fornecedores`).then(res => {
                this.fornecedores = res.data
            })
        },
        onSubmit(){
            this.$validator.validate().then(res=> {
                if(res) {
                    axios.post(`${API_BASE_URL}/compras`,this.compra).then((res) => {
                      console.log(res)
                        let usuario = res.data.resultado.user_id
                        if(usuario === 1) {
                            return this.$router.push('/compras')
                        }else {
                            return  this.$router.push('/compras')
                        }
                    })
                }
            })
        },
        adiciona(){
            if(this.compra.products.length <= 2) {
                this.compra.products.push({id:'',subtotal:'',name:'',price:'',estoque : ''})
            }else {
                return this.compra.products
            }
            this.$toasted.global.defaultSuccess()
        },
        remova(){
          if(this.compra.products.length > 1) {
            this.compra.products.pop({id:'',price:'',subtotal:''})
            this.$toasted.global.defaultSuccess()
          }
        }
    }
}
</script>
