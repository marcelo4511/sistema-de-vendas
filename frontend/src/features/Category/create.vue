<template>
<div>
  <h4 cabecalho="Produto">Categorias</h4>
<nav aria-label="breadcrumb mb-4">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
    <li class="breadcrumb-item active" aria-current="page">Categorias</li>
    <li class="breadcrumb-item"><router-link to="/categories/create">Criar</router-link></li>
  </ol>
</nav>

<div class="form-group">
  <div class="m-3">
    <form class="form-group"  @submit.prevent="onSubmit">
      <div class="row">
        <div class="form-group col-6">
          <label for="" class="label label-default">Nome da Categoria</label>
          <input type="text" class="form-control form-control-sm col-md-12 mr-5" name="name" v-model="category.name">
        </div>
  
        <div class="form-group col-4">
          <label for="">Status</label>
            <select class="form-control form-control-sm" v-model="category.status">
              <option selected disabled value=null>Selecione</option>
              <option value=Ativo>Ativo</option>
              <option value=Inativo>Inativo</option>
            </select>
        </div>
              
        </div>
          <div class="form-group">
            <button type="submit" class="btn btn-sm btn-success  mt-4">Salvar</button>
          </div>
    </form>
  </div>
</div>

  
  </div>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapState,mapActions} from 'vuex'

export default {
 data(){
      return{
        category:{
          name:'',
          status:''
        },
      }
    },
  name:'categories',
  
 methods:{
   ...mapActions('Category',['postList']),
      onSubmit() {
        this.$store.dispatch("Category/postList",{
          name:this.category.name,
          status:this.category.status
        })
        try{
          this.$noty.success("Cadastrado com sucesso!!") 
       setTimeout(() => {
         this.$router.push('/categories')
       },3000)
         } catch(e) {
            this.$noty.info("Houve um problema com o seu formulério. Por favor, tente novamente.",e);
         }
        },
       },
 
  computed: {
    ...mapState('Category',{list:state => state.list}),
  
  }
}
</script>

<style>
    
</style>