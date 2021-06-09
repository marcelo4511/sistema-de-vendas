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
            <input type="text" :class="errorsBack.name ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm'" name="name" v-model="category.name" :disabled="loading">
            <span class="invalid-feedback" v-if="errorsBack.name">
              {{  errorsBack.name[0]  }}<br>
            </span> 
          </div>
          
          <div class="form-group col-4">
            <label class="col-form-label col-form-label-sm">Status</label>
              <select :class="errorsBack.name ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm'" v-model="category.status" :disabled="loading">
                <option selected disabled value=null>Selecione</option>
                <option value=Ativo>Ativo</option>
                <option value=Inativo>Inativo</option>
              </select>
              <span class="invalid-feedback" v-if="errorsBack.status">
                {{  errorsBack.status[0]  }}<br>
              </span> 
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
import { API_BASE_URL } from '../../config/Api'
import {mapState} from 'vuex'
import axios from 'axios'
export default {
    data(){
      return{
        errorsBack:[],
        loading:false,
        category:{}
      }
    },
    created () {
      this.getCategories(this.$route.params.id)
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
                  }).catch((error) => {
                    this.loading = false
                    if(error.response.status == 422){
                      return this.errorsBack = error.response.data.errors
                    }
                  this.$noty.info("Houve um problema com o seu formulério. Por favor, tente novamente.");
                })
              }
          })
        },
      
        getCategories(category) {
          axios.get(`${API_BASE_URL}/categories/${category}`).then((response) => {
            this.category = response.data
          })
        }
    }  
}
</script>

<style>

</style>