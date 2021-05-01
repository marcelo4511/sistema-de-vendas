<template>
  <div class="form-group">
    <h4 cabecalho="Produto">Categorias</h4>
    <nav aria-label="breadcrumb mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
        <li class="breadcrumb-item"><router-link to="/categories">categorias</router-link></li>
      
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
            <button type="submit" class="btn btn-sm btn-success  mt-4">Atualizar</button>
          </div>
    </form>
  </div>
</div>

  <router-link to="/categories" tag="span"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>voltar</router-link>
</div>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapState} from 'vuex'
import axios from 'axios'
export default {
    data(){
      return{
        category:{}
        }
      
    },
     created () {
    this.getBlogById(this.$route.params.id)
    //this.$store.dispatch('Category/showList',this.category)
    },
    computed:{
        ...mapState(['list']),
       
    },
    methods:{
         onSubmit(){
          this.$store.dispatch('Category/updateList',this.category).then(() => {
                this.$noty.success("Cadastrado com sucesso!!") 
                setTimeout(() => {
                    this.$router.push('/categories')
                },3000)
            }).catch(() => {
                this.$noty.info("Houve um problema com o seu formulério. Por favor, tente novamente.");
          })
        },
      
        getBlogById: function (id) {
            axios.get('http://localhost:8000/api/categories/' + id)
            .then((response) => {
              this.category = response.data
            })
            .catch(() => {
          })
        }
    }  
}
</script>

<style>

</style>