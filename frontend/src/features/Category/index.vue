<template>
<div>
  <h4 cabecalho="Produto">Categorias</h4>
    <nav aria-label="breadcrumb mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
        <li class="breadcrumb-item active" aria-current="page">Categorias</li>
      </ol>
    </nav>
    <div class=" border border-black shadow p-3 bg-white rounded" >
        <div class="form-row d-flex justify-content-between">
          <button class="btn btn-sm btn-primary"><router-link tag="span" @click="loadingCreate == true" :disabled="loadingCreate" to="categories/create"><i class="fa fa-plus"></i>Cadastrar</router-link></button>
           <select name="" id="" class="form-control form-control-sm col-3" v-model="status" @change="get">
            <option selected value="">Status</option>
            <option value="Ativo">Ativo</option>
            <option value="Inativo">Inativo</option>
          </select>
            <input type="text" placeholder="Nome" class="form-control form-control-sm col-3" v-model="name" @keyup="get">
            <input class="form-control form-control-sm col-md-2" style="float:right;" type="search" name="nome" placeholder="Buscar" v-model="search" @input="get">
        </div>
        <div class="table-responsive scroll" id="infinite-list" ref="scroll" style="overflow-y:auto;height:300px;margin-top:3vh;">
            <table class="table table-hover table-bordered table-sm" > 
                <thead class="thead-light text-center">
                    <tr>
                        <th scope="col" class="col-form-label col-form-label-sm">Nome</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Status</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="category of categories" :key="category.id">
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{category.name}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{category.status}}</td>
                      
                        <td>
                            <div>
                                <router-link :to="`/categoryedit/${category.id}/edit`" class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></router-link>
                                <button @click="removeList(category)" class="btn btn-sm btn-danger ml-2"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr><td colspan="3" align="center" ><i v-if="loading" class="mt-2 spinner-border spinner-border spinner text-primary" role="status" aria-hidden="true"></i></td></tr>
                    <tr><td colspan="3" v-if="loading == false && categories.length == 0" align="center" style="border:0;margim-bottom:2px;"><label class="col-form-label col-form-label-sm">Nenhum registro encontrado.</label></td></tr>
                </tbody>
            </table> 
        </div>
    </div>
    
  </div>
</template>

<script>
import {API_BASE_URL} from '../../config/Api'
import axios from 'axios'
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapState, mapActions} from 'vuex'
import swal from 'sweetalert'
export default {
 data(){
    return{
      loading: true,
      loadingCreate:false,
      categories: [],
      totalPages:null,
      page: null,
      name:'',
      status:'',
      search:'',
      lastPage: 0,
    }
  },
  mounted() {
    this.getCategories()
    this.get()
    const listaCategorias = document.querySelector('#infinite-list');
    listaCategorias.addEventListener('scroll', () => {
      if(listaCategorias.scrollTop + listaCategorias.clientHeight >= listaCategorias.scrollHeight) {
        this.getCategories();
      }
    });
  },
 methods:{
   ...mapActions('Category',['postList','setList','updateList','removeList']),

        getCategories(){
          this.loading = false;
          setTimeout(() => {
              axios.get(`${API_BASE_URL}/categories?page=${this.page+1}&search=${this.search}&name=${this.name}&status=${this.status}`).then(res => {
                const toFilter = [...this.categories, ...res.data.data]
                const filtered = toFilter.reduce((items, current) => {
                    const x = items.find(item => item.id === current.id);
                    return !x ? items.concat([current]) : items
                }, []);
                  this.categories = filtered
                 this.page = res.data.current_page
                  console.log(res.data)
              })
            }, 1000);
           this.loading = true
        },
        
        get(){
          axios.get(`${API_BASE_URL}/categories?page=${this.page+1}&search=${this.search}&name=${this.name}&status=${this.status}`).then(res => {
              document.getElementById('infinite-list').scrollTop = 0
                this.categories = res.data.data
                this.page = res.data.current_page
                this.totalPages = res.data.last_page
                this.loading = false
              })
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
  .scroll::-webkit-scrollbar {
    height: 10px;
    width: 10px;
  }

.scroll::-webkit-scrollbar-track {
  background: #f1f1f1;
}

.scroll::-webkit-scrollbar-thumb {
  background: linear-gradient(to right, #1e469a, #49a7c1);;
  border-radius: 10px;
}
</style>