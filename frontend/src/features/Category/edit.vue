<template>
  <div class="form-group">
    <h4 cabecalho="Produto">Categorias</h4>
    <nav aria-label="breadcrumb mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
        <li class="breadcrumb-item"><router-link to="/categories">Categorias</router-link></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
      </ol>
    </nav>

    <div class="form-group">
      <form class="form-group" @submit.prevent="onSubmit">
        <div class="row">
          <div class="form-group col-6">
            <label class="col-form-label col-form-label-sm" >Nome da Categoria</label>
            <input type="text" class="form-control form-control-sm col-md-12" name="name" v-model="category.name" :disabled="loading">
          </div>
          
          <div class="form-group col-4">
            <label class="col-form-label col-form-label-sm">Status</label>
              <select class="form-control form-control-sm" v-model="category.status" :disabled="loading">
                <option selected disabled value=null>Selecione</option>
                <option value=Ativo>Ativo</option>
                <option value=Inativo>Inativo</option>
              </select>
          </div>
          </div>
            <div class="form-group">
              <button type="submit" class="btn btn-sm btn-success" :disabled="loading">
                <i v-if="loading" class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true"></i>Atualizar
              </button>
            </div>
      </form>
    </div>
  </div>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapState} from 'vuex'
import axios from 'axios'
export default {
    data(){
      return{
        loading:false,
        category:{}
      }
    },
    created () {
      this.getBlogById(this.$route.params.id)
    },
    computed:{
        ...mapState(['list']),
       
    },
    methods:{
         onSubmit(){
            this.$validator.validate().then(res=> {
              if(res) {   
              this.loading = true
                this.$store.dispatch('Category/updateList',this.category).then(() => {
                      this.$noty.success("Cadastrado com sucesso!!") 
                      setTimeout(() => {
                          this.$router.push('/categories')
                      },3000)
                  }).catch(() => {
                      this.$noty.info("Houve um problema com o seu formulério. Por favor, tente novamente.");
                })
              }
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