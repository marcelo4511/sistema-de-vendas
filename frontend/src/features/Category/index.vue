<template>
<div>
  <h4 cabecalho="Produto">Categorias</h4>
    <nav aria-label="breadcrumb mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
        <li class="breadcrumb-item active" aria-current="page">Categorias</li>
      </ol>
    </nav>
    <div class="form-group">
        <button class="btn btn-sm btn-primary"><router-link tag="span" to="categories/create">Cadastrar</router-link></button>
        <input class="form-control form-control-sm col-md-3 mb-3" type="search" style="float: right;"  placeholder="Buscar">
    </div>
    <div class="table table-responsive">
      <table class="table table-sm">
        <thead class="text-center">
          <tr>
              <th scope="col">Nome</th>
              <th scope="col">Status</th>
              <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr v-for="(category,i) in categories" :key="i">
              <td>{{category.name}}</td>
              <td>{{category.status}}</td>
              <td>
                <router-link :to="`/categoryedit/${category.id}/edit`" class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></router-link>
                <button @click="removeList(category)" class="btn btn-sm btn-danger ml-2"><i class="fa fa-trash"></i></button>
              </td>
          </tr>
        </tbody>
      </table>
    </div>
    <infinite-loading spinner="spiral" id="espiral" @infinite="infiniteHandler">
        <div class="text-red" slot="no-more">No more users</div>
        <div class="text-red" slot="no-results">No more users</div>
    </infinite-loading>
  </div>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
import axios from 'axios'
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapState, mapActions} from 'vuex'
import swal from 'sweetalert'
export default {
 data(){
      return{
       categories: [],
        page: 2,
        lastPage: 0,
      }
    },
  name:'categories', components: {
    InfiniteLoading,
  },
  created(){
    this.fetchUsers()
  },
 methods:{
   ...mapActions('Category',['postList','setList','updateList','removeList']),

        getCategories(){
           axios.get(`http://localhost:8000/api/categories?page=${this.page}`).then(res => {
           this.categories.data.push(...res.data)
           this.categories.meta = res.data.meta
           })
        },
        fetchUsers: function() {
          return  axios.get(`http://localhost:8000/api/categories?page=${this.page}`);   
        },
          infiniteHandler: function($state) {
          setTimeout(function () {
            this.fetchUsers()
                .then(response => {
                    if (response.data.data.length > 0) {
                      this.lastPage = response.data.data.last_page;
                      response.data.data.forEach(message => {
                        this.categories.push(message);
                      });
                      if (this.page -1 === this.lastPage) {
                        this.page = 2;
                        $state.complete();
                      } else {
                        this.page += 1;
                      }
                      $state.loaded();
                    } else {
                      this.page = 2;
                      $state.complete();
                    }
                })
                .catch(() => console.log());
            }.bind(this), 1000);
      },
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
  }
}
</script>

<style>
    div #espiral{
      color: firebrick;
    }
</style>