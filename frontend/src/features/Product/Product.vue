<template>

<main>
<h4 cabecalho="Produto">Produtos</h4>
<nav aria-label="breadcrumb mb-4">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
  
    <li class="breadcrumb-item active" aria-current="page">Produtos</li>
  </ol>
</nav>
<div class="display">

  <form @submit.prevent="salvar">
      <div class="row ">
          <div class="form-group col-md-3">
            <label for="">Nome</label>
            <input class="form-control col-md-auto " type="text" name="name " required v-model="product.name" @input="product.name = $event.target.value.toUpperCase()">
          </div>
          
      
          <div class="form-group col-md-3">
            <label for="">Descrição</label>
            <input type="text" name="description" class="form-control col-md-auto" required v-model="product.description">
          </div>     

          <div class="form-group col-md-3">
            <label for="">Categorias</label>
            <select  v-model="product.category_id" required class="form-control col-md-auto">
                    <option  disabled selected value="">selecione</option>
                    <option  v-for="(category, key) in list" v-show="category.status == 'Ativo'" :key="key" :value="category.id">{{category.name}}</option>
            </select>
          </div> 

        <div class="form-group col-md-3">
         <label for="">Imagem</label>
         <input type="url" name="imagem" class="form-control col-md-auto" required  v-model="product.imagem">
        </div>  
      </div>
        
          
      <div class="row">
            
        <div class="form-group col-md-3">
         <label for="">Preço</label>
         <input type="text" name="price" v-money="money" class="form-control col-md-auto" required @change="quantificar(product)" v-model="product.price">
        </div>  
        

       <div class="form-group col-md-3">
        <label for="">Quantidade</label>
        <input type="decimal" name="amount" required  class="form-control col-md-auto" @change="quantificar(product)" v-model="product.amount">
       </div>   
     
      <div class="form-group col-md-3">
        <label for="">Subtotal</label>
        <input type="text" name="subtotal" required v-money="money" class="form-control col-md-auto" @change="quantificar(product)" v-model="product.subtotal">
      </div> 

       <div class="form-group col-md-3">
                <label for="">Status</label>
                <select class="form-control col-12" v-model="product.status">
                    <option selected disabled value=null>Selecione</option>
                    <option value=Ativo>Ativo</option>
                    <option value=Inativo>Inativo</option>
                </select>
            </div>
        </div>
      
      <button v-if="isEdit === false" type="submit" class="btn btn-info">Cadastrar</button>
      <button v-else-if="isEdit === true" type="button" class="btn btn-sucundary" @click="Atualizar">Atualizar</button>
  </form>
  
     
      <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control col-3 mt-5" placeholder="Buscar" style="float:right;" v-model="pesquisa" >
          </div>
      </div>

    <table class="table table-sm"> 
        <thead>
            <tr>
                <th scope="col">Imagem</th>
                <th scope="col">Nome</th>
                <th scope="col">Descrição</th>
                <th scope="col">Categorias</th>
                <th scope="col">Preco</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Status</th>
                <th scope="col">Ação</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="product of pesquisar" :key="product.id">
                <td><img :src=product.imagem alt=""></td>
                <td>{{product.name}}</td>
                <td>{{product.description}}</td>
                <td>{{product.categories.name}}</td>
                <td>R$ {{product.price}}</td>
                <td>{{product.amount}}</td>
                <td>R$ {{product.subtotal}}</td>
                <td>{{product.status}}</td>
                
                <td>
                    <button class="btn btn-warning mr-1" @click="editProduct(product)"> <i class="fa fa-pen"></i> </button>
                    <button class="btn btn-danger" @click="deleteProduct(this.product)"> <i class="fa fa-trash"></i> </button>
                </td>
            </tr>
        </tbody>
        <hr>
        <tfoot>
            <tr>
                <th scope="col">Total</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th scope="">R$ {{totalizar}}</th>
            </tr>
        </tfoot>
    </table> 
</div>

    </main>
</template>

<script>

import {mapState,mapActions} from 'vuex'
import axios from 'axios'
import {VMoney} from 'v-money'
import '../../estilos/styles.css'
export default {
    name:'product',
    data(){
        return {
            product:{
                category_id:'',
                name:'',
                description:'',
                image:'',
                subtotal:'',
                amount:'',
                status:''
            },
            produtos:[],
            //categories:[],
            update:{},
            isEdit:false,
            pesquisa:[], 
            total:0,
            count:0,

            money: {
            decimal: ',',
            thousands: '.',
            //prefix: 'R$ ',
            precision: 2,
            masked: false 
        },
      };
      
    },
      directives: {money: VMoney},

    created(){
        //this.listar()
        this.$store.dispatch('Product/getProducts'),
        this.$store.dispatch('Category/setList')// dispatch loading

    },
    methods:{
        ...mapActions('Product',['postProducts','getProducts','putProducts','deleteProducts']),

        salvar(){
                this.$store.dispatch('Product/postProducts',{   
                     name:this.product.name,
                     description:this.product.description,
                     imagem:this.product.imagem,
                     category_id:this.product.category_id,
                     amount:this.product.amount,
                     price:this.product.price,
                     subtotal:this.product.subtotal,
                     status:this.product.status
                })
                try {
                    this.product = this.$store.dispatch('Product/getProducts')
                    this.$toasted.global.defaultSuccess()
                    this.$store.dispatch('Product/getProducts')
                    
                } catch{
                    alert('houve um erro')
                }
            },

        editProduct(product){   
                this.isEdit = true
                this.product = product      
            },

        Atualizar() {
             this.$store.dispatch(`Product/putProducts`,
                    
                    this.product

                    )
                    try{ 
                        this.produtos = this.$store.dispatch('Product/getProducts')
                        //this.product = {}
                        this.isEdit = false
                        this.$toasted.global.defaultSuccess()
                    }
                    catch{
                    this.$toasted.global.defaultError()
                }
        },
        deleteProduct(product){
            this.$store.dispatch('Product/deleteProducts',product)
            try {
                this.$toasted.global.defaultSuccess()
                this.$store.dispatch('Product/getProducts')
            }catch(err){
                console.log(err)
            }
        },
        mostrar(product){
         const url = `http://localhost:8000/api/products/${product.id}`
            axios.get(url).then(resposta => {
                resposta.data
                console.log(resposta.data)
            })
        },
        quantificar(product) {
            product.subtotal = parseFloat(product.price) * parseInt(product.amount)
        },
        
    },
    
    
    computed:{
        ...mapState('Category',{list:state => state.list}),
        ...mapState('Product',{products:state => state.products}),

        pesquisar:function() {
            return this.products.filter(product => {
                return product.name.includes(this.pesquisa)
            })
        },
        totalizar:function() {
             return  this.products.reduce((total,product) => {
                return (parseFloat(total) + parseFloat(product.subtotal)).toFixed(2).replace('.',',')
            },0)
        },
    },
    
}
   
</script>

<style>
   img{
       width: 100px;
       height: 100px;
   }
</style>