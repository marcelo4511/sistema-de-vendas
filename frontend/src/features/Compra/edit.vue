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
          </div>
        </div>
        <hr class="border shadow-lg border-black" style=" margin:0 !important;"/>
        <div class="form-row">   
          <div class="card-body">
            <div class="table table-sm" > 
                <div class="form-row d-flex justify-content-between" v-for="(detalheCompra,key) of compra.produtos" :key="key">
                    <div class="col-3">
                      <label class="col-form-label col-form-label-sm "><strong>Produto</strong></label>
                        <input autocomplete="off" class="form-control form-control-sm" type="search" :name="`id_${key}`" @input="getProdutos(detalheCompra.name,key)" data-vv-as="Produto" v-validate="'required'" :class="['form-control form-control-sm form-control form-control-sm-sm', {'is-invalid': errors.has(`id_${key}`)},`${errorsRequest[`details_sales.${key}.id`] ? `is-invalid` : ``}`]"  :disabled="disabled" required v-model="detalheCompra.name" >
                        
                        <ul class="list-group list-group-flush " v-show="detalheCompra.produtosList !== null && detalheCompra.name !== ''" style="list-style: none;cursor:pointer;margin-top:2px;overflow-y:scroll;height: auto; max-height: 150px;">
                          <li id="autocompletar" v-for="(product) in detalheCompra.produtosList" :key="product.id" class=" list-group-item border shadow-sm border-black" @click="clickName(product.name,key)" v-show="product.status == 'Ativo'" :value="product.id">{{product.name}}</li>
                        </ul>
                        <div class="progress mt-2" v-if="detalheCompra.carregamento">
                          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                          </div>
                        </div>
                        <span v-show="errors.has(`id_${key}`)" class="invalid-feedback">{{ errors.first(`id_${key}`) }}</span>
                    </div>
                  
                    <div class="col-2">
                      <label class="col-form-label col-form-label-sm"><strong>Categoria</strong></label>
                      <select name="" id="" class=" form-control form-control-sm selectpicker" data-live-search="true">
                        <option v-for="(fornecedor,indexFornecedor) in fornecedores" :key="indexFornecedor"  :value="fornecedor.id">{{fornecedor.name}}</option>
                      </select>
                    </div>
                    <div class="col-2">
                      <label class="col-form-label col-form-label-sm"><strong>Preço</strong></label>
                      <money v-model="detalheCompra.price" :name="`price_${key}`" data-vv-as="Preço" v-validate="'min_value:0.01'" 
                      :class="['form-control form-control-sm', {'is-invalid': errors.has(`price_${key}`)},`${errorsRequest[`details_sales.${key}.price`] ? `is-invalid` : ``}`]" 
                      :value="detalheCompra.price"  v-bind="money" class="form-control form-control-sm" @blur="calculateSubTotal(key)"></money>
                      <span v-show="errors.has(`price_${key}`)" class="invalid-feedback">{{ errors.first(`price_${key}`) }}</span>
                    </div>

                    <div class="col-2">
                      <label class="col-form-label col-form-label-sm"><strong>Estoque</strong></label>
                      <input class="form-control form-control-sm" @blur="calculateSubTotal(key),detalheCompra.estoquecount = detalheCompra.estoque" type="text" v-model="detalheCompra.estoque" required>
                    </div>

                    <div class="col-0">
                      <div style="margin-top:30px;cursor:pointer;" @click="incrementar(key)">
                        <b><i class="fa fa-sort-up"></i></b>
                      </div>
                      <div style="margin-top:-15px;cursor:pointer;" @click="decrementar(key)">
                        <b><i class="fa fa-sort-down"></i></b>
                      </div>
                    </div>

                    <div class="col-2">
                      <label class="col-form-label col-form-label-sm"><strong>Subtotal</strong></label>
                      <money readonly disabled :value="detalheCompra.pivot.subtotal" v-bind="money" name="totalPrejuizo" class="form-control form-control-sm"></money>
                    </div>
                    <button class="btn btn-sm btn-danger " style="height:30px;margin-top:30px;" :disabled ="compra.produtos.length == 1" data-toggle="modal" :data-target="`#detalhe${detalheCompra.id}`"><i class="fa fa-trash"></i></button>
                     <modal class="del" :title="`Deseja remover o produto ? `" :compl="``"  :name="`detalhe${detalheCompra.id}` ">
                        <div class="modal-body text-left" >
                          <button class="btn btn-sm btn-primary mr-2" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>  
                          <button class="btn btn-sm btn-danger" @click="removeProduct(key)" :disabled="loading">
                            <i v-if="loading" class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true"></i>
                            <i v-else class="fa fa-trash"></i>
                            Deletar
                          </button>
                        </div>
                    </modal>
                </div>
                
            </div>
          </div>
        </div>
        <div class="col-12">
          <span class="alert alert-primary text-black p-1">Total da Compra: <strong> R$ {{formatarMoeda(totalizar)}}</strong></span>
        </div>
      </div>

    <button type="submit" @click="onSubmit" class="btn btn-sm btn-success mt-2" :disabled="loading"><i v-if="loading" class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true"></i>Cadastrar</button>
  </div>
</template>

<script>
import axios from 'axios'
import {VMoney} from 'v-money'
import {API_BASE_URL} from '../../config/Api'
import $ from 'jquery'
export default {
     directives: {money: VMoney},
     components:{
        Modal: () => import('../Modal/modal.vue')
    },
    data() {
        return {
            disabled:false,
            loading:false,
            fornecedores:[],
            errorsRequest:[],
            compra:{
                data_compra:null,
                total:0,
                fornecedor_id:0,
                produtos:[{
                    id:'',name:'',price:'',estoque:0,estoquecount:0,pivot:{subtotal:0},produtosList:[],carregamento: false
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
        this.getCompra(this.$route.params.id)
    },
    methods:{
        getCompra(id){
          axios.get(`${API_BASE_URL}/compras/${id}`).then((response) => {
            this.compra = response.data  
          })
        },
        getFornecedores(){
          axios.get(`${API_BASE_URL}/fornecedores`).then(res => {
              this.fornecedores = res.data
          })
        },
        getProdutos(nome,key){
          this.compra.produtos[key].carregamento = true
          axios.post(`${API_BASE_URL}/get/productscompra`,{name:nome}).then(res => {
            this.compra.produtos[key].carregamento = false
            this.compra.produtos[key].produtosList = res.data
            if(nome == ''){
              this.compra.produtos[key].carregamento = false
              this.compra.produtos[key].produtosList = null 
              this.compra.produtos[key].price = 0
              this.compra.produtos[key].estoque = 0 
              this.compra.produtos[key].estoquecount = 0 
              this.compra.produtos[key].pivot.subtotal = 0 
            }
          })
        },
        clickName(name,key){
          this.compra.produtos[key].nome = name
          this.compra.produtos[key].produtosList = null
          this.getProduto(this.compra.produtos[key].nome,key)
        },
        getProduto(product,key){
          if(product){
            axios.get(`${API_BASE_URL}/get/productscompraname/${product}`).then(res => {
              this.compra.produtos[key].id = res.data[0].id
              this.compra.produtos[key].name = res.data[0].name
              this.compra.produtos[key].price = res.data[0].price
              this.compra.produtos[key].estoque = res.data[0].estoque   
              this.compra.produtos[key].estoquecount = res.data[0].estoque   
              this.calculateSubTotal(key)
            })
          }
        },
        
        onSubmit(){
          this.$validator.validate().then(res=> {
              if(res) {
                  axios.put(`${API_BASE_URL}/compras/${this.$route.params.id}`,this.compra).then((res) => {
                      let usuario = res.data.resultado.user_id
                      if(usuario === 1) {
                          return this.$router.push('/compras')
                      }else {
                          return  this.$router.push('/compras')
                      }
                  }).catch(error => {
                    if (error.response.status === 422) {
                      this.errorsRequest = error.response.data.errors;
                    }else {
                      this.$noty.info('houve um problema na edição')
                    }
                  });
                }
            })
        },
        removeProduct(indexProduto){
          if(this.compra.produtos[indexProduto].id){
              this.loading = true
            axios.post(`${API_BASE_URL}/comprasprodutos`, {id: this.compra.produtos[indexProduto].id, compra_id: this.compra.id }).then(() => {
              this.$noty.success("Deletado com sucesso!!")
              this.compra.produtos.splice(indexProduto,1)
              this.loading = false
              $('.del').modal('hide');
            })
          }else {
            this.loading = true
            this.compra.produtos.splice(indexProduto,1)
            this.$noty.success("Deletado com sucesso!!")
            this.loading = false
            $('.del').modal('hide');
          }
        },
        adiciona(){
            if(this.compra.produtos.length <= 2) {
                this.compra.produtos.push({id:'',pivot:{subtotal:0},name:'',price:'',estoque : ''})
            }else {
                return this.compra.produtos
            } 
            this.$toasted.global.defaultSuccess()
        },
        remova(){
          if(this.compra.produtos.length > 1) {
            this.compra.produtos.pop({id:'',price:'',pivot:{subtotal:''}})
            this.$toasted.global.defaultSuccess()
          }
        },
        calculateSubTotal(key){
          this.compra.produtos[key].pivot.subtotal = this.compra.produtos[key].estoque * parseFloat(this.compra.produtos[key].price) || 0
        },
        formatarMoeda(moeda){
          moeda = parseFloat(moeda);
          moeda = moeda.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+,)/g, "$1.");
          return moeda;
        },
        incrementar(key){
          this.compra.produtos[key].estoque ++
          this.calculateSubTotal(key)
        },
        decrementar(key){
          while (this.compra.produtos[key].estoque > this.compra.produtos[key].estoquecount) {
            return this.compra.produtos[key].estoque --
          }
          this.calculateSubTotal(key)
        },
    },
  computed:{
    totalizar() {
      return  this.compra.produtos.reduce((total,detalheCompra) => {
          return this.compra.total =  parseFloat(total) + parseFloat(detalheCompra.pivot.subtotal) || 0
      },0)
    },
  },
}
</script>

<style>
 #autocompletar{
  color:blueviolet;
  font-weight: bold;
}
#autocompletar:hover{
  background-color: blueviolet;
  color: aliceblue;
}

</style>