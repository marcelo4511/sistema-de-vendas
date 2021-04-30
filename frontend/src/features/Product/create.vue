<template>

<main>
<h4 cabecalho="Produto">Produtos</h4>
<nav aria-label="breadcrumb mb-4">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
  
    <li class="breadcrumb-item active" aria-current="page">Produtos</li>
  </ol>
</nav>


  <form @submit.prevent="onSubmit">
      <div class="row ">
          <div class="form-group col-md-4">
            <label for="">Nome</label>
            <input class="form-control col-md-auto " type="text" name="name " v-model="product.name" @input="product.name = $event.target.value.toUpperCase()">
          </div>
          <div class="form-group col-md-4">
            <label for="">Descrição</label>
            <input type="text" name="description" class="form-control col-md-auto" v-model="product.description">
          </div>     
          <div class="form-group col-md-4">
            <label for="">Categorias</label>
            <select  v-model="product.category_id" class="form-control col-md-auto">
                    <option  disabled selected value="">selecione</option>
                    <option  v-for="(category, key) in list" v-show="category.status == 'Ativo'" :key="key" :value="category.id">{{category.name}}</option>
            </select>
          </div> 
      </div>
        
      <div class="row">
        <div class="form-group col-md-4">
          <strong>Imagem</strong>
          <input type="file" name="imagem" v-validate="'image'" data-vv-as="Imagem"  :class="['form-control form-control-sm', { 'is-invalid':errors.has('imagem')}]" class="form-control col-md-auto" id="imagem" v-on:change="salvaImagem">
          <span v-show="errors.has('imagem')" class="invalid-feedback">
            {{ errors.first('imagem') }}
          </span>
        </div>  
            
        <div class="form-group col-md-4">
         <label for="">Preço</label>
         <input type="text" name="price" v-money="money" class="form-control col-md-auto"  v-model="product.price">
        </div>  

        <div class="form-group col-md-4">
         <label for="">Estoque</label>
         <input type="number" name="estoque"  class="form-control col-md-auto"  v-model="product.estoque">
        </div>  

       <div class="form-group col-md-4">
          <label for="">Status</label>
          <select class="form-control col-12" v-model="product.status">
            <option selected disabled value=null>Selecione</option>
            <option value=Ativo>Ativo</option>
            <option value=Inativo>Inativo</option>
          </select>
      </div>
    </div>
    <button type="submit" class="btn btn-info" :disabled="loading">Cadastrar</button>
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
              imagem:'',
              price:'',
              estoque:'',
              status:''
            },
            produtos:[],
            loading:false,
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
        salvaImagem(e) {
          let arquivo = e.target.files ?? e.dataTransfer.files
          if(!arquivo.length){
            return
          }

          let reader = new FileReader()
          reader.onload = (e) => {
            this.imagem = e.target.result
          }

          reader.readAsDataURL(arquivo[0])
          console.log(arquivo)
        },
        onSubmit(){
          this.loading = true
          console.log('entrei')
          this.$validator.validate().then(res=> {
            if(res) {
              this.$store.dispatch('Product/postProducts',this.product).then(() => {
              this.loading = false
              this.$noty.success("Cadastrado com sucesso!!") 
              this.$router.push('/products')
              }).catch(() => {
                this.$noty.info("Houve um problema com o seu formulério. Por favor, tente novamente.");
              })
            } else {
              ///sdfwsf
              console.log('teste se entriou')
              }
            }) 
          }
    },
    computed:{
        ...mapState('Product',{products:state => state.products}),
        ...mapState('Category',{list:state => state.list.data}),
    },
    
}
   
</script>

<style>
   img{
       width: 100px;
       height: 100px;
   }
</style>
