<template>

<main>
<h4 cabecalho="Produto">Produtos</h4>
<nav aria-label="breadcrumb mb-4">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
  
    <li class="breadcrumb-item active" aria-current="page">Produtos</li>
  </ol>
</nav>


  <form @submit.prevent="onSubmit" enctype="multipart/form-data">
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
         <input type="url" name="imagem" id="imagem" class="form-control col-md-auto" required  v-model="product.imagem">
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
        <input type="text" name="subtotal" required class="form-control col-md-auto" @change="quantificar(product)" v-model="product.subtotal">
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
  
    
    </main>
</template>
<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapState,mapActions} from 'vuex'
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
            prefix: 'R$ ',
            precision: 2,
            masked: false 
        },
      };
      
    },
      directives: {money: VMoney},

    created(){
        this.$store.dispatch('Category/setList')
        this.$store.dispatch('Product/getProducts')

    },
    methods:{
        ...mapActions('Product',['postProducts']),

        onFileChange(event){
           this.product.imagem = event.target.files[0];
          },
          
        onSubmit(){
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
           //let formData = new FormData()
            //formData.append('imagem', this.product)
               // this.$store.dispatch('Product/postProducts',formData,{
                //   headers: {
            //  'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
           // }
             //   })
                try {
                    this.$noty.success("Cadastrado com sucesso!!") 
                    this.$router.push('/products')
                } catch{
                   this.$noty.info("Houve um problema com o seu formulério. Por favor, tente novamente.");
                }
            },
        quantificar(product) {
            product.subtotal = parseFloat(product.price) * parseFloat(product.amount) || 0
        },
        
    },
    
    
    computed:{
        ...mapState('Product',{products:state => state.products}),
        ...mapState('Category',{list:state => state.list}),

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
