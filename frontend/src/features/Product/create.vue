<template>
<main>
  <h4 cabecalho="Produto">Produtos</h4>
  <nav aria-label="breadcrumb mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
      <li class="breadcrumb-item"><router-link to="/products">Produtos</router-link></li>
      <li class="breadcrumb-item active" aria-current="page">Criar</li>
    </ol>
  </nav>
  <form @submit.prevent="onSubmit">
      <div class="row ">
        <div class="form-group col-md-4">
          <label class="col-form-label col-form-label-sm">Nome</label>
          <input type="text" name="name" v-model="product.name" @input="product.name = $event.target.value.toUpperCase()"
           v-validate = "'required'" data-vv-as="Nome" :class="['form-control form-control-sm', {'is-invalid': errors.has('name')}]">
          <div v-show="errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
        </div>
        <div class="form-group col-md-4">
          <label class="col-form-label col-form-label-sm">Descrição</label>
          <input type="text" name="description" v-model="product.description"  v-validate = "'required'" data-vv-as="Descrição"
           :class="['form-control form-control-sm', {'is-invalid': errors.has('description')}]">
          <div v-show="errors.has('description')" class="invalid-feedback">{{ errors.first('description') }}</div>
        </div>     
        <div class="form-group col-md-4">
          <label class="col-form-label col-form-label-sm">Categorias</label>
          <select  v-model="product.category_id"  name="category_id" v-validate = "'required'" data-vv-as="Categoria" 
          :class="['form-control form-control-sm', {'is-invalid': errors.has('category_id')}]">
            <option  disabled selected value="">selecione</option>
            <option  v-for="(category, key) in categories" v-show="category.status == 'Ativo'" :key="key" :value="category.id">{{category.name}}</option>
          </select>
          <div v-show="errors.has('category_id')" class="invalid-feedback">{{ errors.first('category_id') }}</div>
        </div> 
      </div>
        
      <div class="row">
        <div class="form-group col-md-4">
          <strong>Imagem</strong>
          <input type="file" name="imagem" v-validate="'required'" data-vv-as="Imagem"  :class="['form-control form-control-sm form-control form-control-sm-sm', { 'is-invalid':errors.has('imagem')}]" class="form-control form-control-sm col-md-auto" id="imagem" v-on:change="uploadImagem">
          <span v-show="errors.has('imagem')" class="invalid-feedback">
            {{ errors.first('imagem') }}
          </span>
        </div>  
            
        <div class="form-group col-md-4">
          <label class="col-form-label col-form-label-sm">Preço</label>
          <money v-model="product.price" v-bind="money" class="form-control form-control-sm col-md-auto"></money>
        </div>  

        <div class="form-group col-md-4">
          <label class="col-form-label col-form-label-sm">Estoque</label>
          <input type="number" name="estoque" v-model="product.estoque" v-validate = "'required'" data-vv-as="Estoque" :class="['form-control form-control-sm', {'is-invalid': errors.has('estoque')}]">
          <div v-show="errors.has('estoque')" class="invalid-feedback">{{ errors.first('estoque') }}</div>
        </div>  

       <div class="form-group col-md-4">
          <label class="col-form-label col-form-label-sm">Status</label>
          <select class="form-control form-control-sm col-12" name="status_id" v-model="product.status" v-validate = "'required'" data-vv-as="Status" :class="['form-control form-control-sm', {'is-invalid': errors.has('status_id')}]">
            <option selected disabled value=null>Selecione</option>
            <option value=Ativo>Ativo</option>
            <option value=Inativo>Inativo</option>
          </select>
          <div v-show="errors.has('status_id')" class="invalid-feedback">{{ errors.first('status_id') }}</div>
      </div>
    </div>
    <button type="submit" class="btn btn-sm btn-info" :disabled="loading"><i v-if="loading" class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true"></i>Cadastrar</button>
  </form>
</main>
</template>
<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import axios from 'axios'
import {API_BASE_URL} from '../../config/Api'
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
            categories:[],
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
        this.getCategorias()
        this.$store.dispatch('Category/setList')
        this.$store.dispatch('Product/getProducts')
    },
    methods:{
      getCategorias(){
            axios.get(`${API_BASE_URL}/get/categories`).then(res => {
              this.categories = res.data
            })
        },
        ...mapActions('Product',['postProducts']),
        uploadImagem(e) {
          let arquivo = e.target.files ?? e.dataTransfer.files
          if(!arquivo.length){
            return
          }
          let reader = new FileReader()
          reader.onload = (e) => {
            this.product.imagem = e.target.result
          }
         return reader.readAsDataURL(arquivo[0])
        },
        onSubmit(){
          this.$validator.validate().then(res=> {
            if(res) {   
                this.loading = true
                this.$store.dispatch('Product/postProducts',this.product).then(() => {
                this.loading = false
                this.$noty.success("Cadastrado com sucesso!!") 
                this.$router.push('/products')
                }).catch(() => {
                  this.$noty.info("Houve um problema com o seu formulário. Por favor, tente novamente.");
                })
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
