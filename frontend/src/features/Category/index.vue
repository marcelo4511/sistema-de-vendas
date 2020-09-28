<template>
<div>
  <h4 cabecalho="Produto">Categorias</h4>
<nav aria-label="breadcrumb mb-4">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
  
    <li class="breadcrumb-item active" aria-current="page">Categorias</li>
  </ol>
</nav>
<div class="form-group">
    <button class="btn btn-primary"><router-link tag="span" to="categories/create">Cadastrar</router-link></button>
 
  <input class="form-control col-md-3 mb-3" type="search" style="float: right;" name="nome" placeholder="Buscar" v-model="pesquisa">

</div>

  <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(category,i) in pesquisar" :key="i">
                    <td>{{category.name}}</td>
                    <td>{{category.status}}</td>
                    <td>
                        
                        <router-link :to="`/categoryedit/${category.id}/edit`" class="btn btn-warning"><i class="fa fa-pen"></i></router-link>
                        <button @click="removeList(category)" class="btn btn-danger ml-2"><i class="fa fa-trash"></i></button>
                    </td>
                  
                </tr>
                </tbody>
            </table>
        
  </div>
</template>

<script>

import {mapState, mapActions, mapGetters} from 'vuex'
import swal from 'sweetalert'
export default {
 data(){
      return{
        name:'',
        pesquisa:''
        
      }
    },
  name:'categories',
  created(){
    this.$store.dispatch('Category/setList')
  },
 methods:{
   ...mapActions('Category',['postList','setList','updateList','removeList']),

  
        editList(){
          const update = {
            id:this.list.id,
            name:this.list.name,
            status:this.list.status
          }
          this.updateList(update)
        },
        removeList(category){
           swal({
            title: "Você está certo disso ?",
            text: "Depois de excluído, você não será capaz de recuperar este arquivo!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
              if(willDelete) {
                this.$store.dispatch('Category/removeList',category)
                  swal("Cliente deletado com sucesso!", {
                icon: "success",
                });
              }else {
                swal("seu dado está a salvo");
              }
          })
        }  
      },
 
  computed: {
    ...mapState('Category',{list:state => state.list}),
    ...mapGetters('Category',['total']),
        pesquisar:function() {
            return this.list.filter(l => {
                return l.name.includes(this.pesquisa)
            })
        },
  }
}
</script>

<style>
    
</style>