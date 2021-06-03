<template>
<div>
  <h4 cabecalho="Produto">Categorias</h4>
  <nav aria-label="breadcrumb mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
      <li class="breadcrumb-item"><router-link to="/categories">Categorias</router-link></li>
      <li class="breadcrumb-item">Criar</li>
    </ol>
  </nav>

    <div class="form-group">
      <div>
        <form class="form-group"  @submit.prevent="onSubmit">
          <div class="row">
            <div class="form-group col-6">
              <label class="col-form-label col-form-label-sm">Nome da Categoria</label>
              <input type="text" class="form-control form-control-sm col-md-12" name="name" v-model="category.name"
              v-validate = "'required'" data-vv-as="Nome" :class="['form-control form-control-sm', {'is-invalid': errors.has('name')}]">
              <div v-show="errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
            </div>
      
            <div class="form-group col-4">
              <label class="col-form-label col-form-label-sm">Status</label>
                <select v-model="category.status" name="status"
                v-validate = "'required'" data-vv-as="status" :class="['form-control form-control-sm', {'is-invalid': errors.has('status')}]">
                  <option selected disabled value=null>Selecione</option>
                  <option value=Ativo>Ativo</option>
                  <option value=Inativo>Inativo</option>
                </select>
                <div v-show="errors.has('status')" class="invalid-feedback">{{ errors.first('status') }}</div>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-sm btn-success" :disabled="loading"><i v-if="loading" class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true"></i>Salvar</button>
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
        loading:false,
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
        this.$validator.validate().then(res=> {
          if(res) {   
          this.loading = true
          this.$store.dispatch("Category/postList",this.category)
          try{
              this.$noty.success("Cadastrado com sucesso!!") 
              setTimeout(() => {
                this.$router.push('/categories')
                this.loading = false
              },3000)
                }catch(e) {
                  this.$noty.info("Houve um problema com o seu formulério. Por favor, tente novamente.",e);
                }
              }
            }) 
          },
       },
 
  computed: {
    ...mapState('Category',{list:state => state.list}),
  
  }
}
</script>

<style>
    
</style>