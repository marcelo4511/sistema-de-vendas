<template>

<main>
    <h4 cabecalho="Produto">Produtos</h4>
    <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
            <li class="breadcrumb-item active" aria-current="page">Produtos</li>
        </ol>
    </nav>
    <div class=" border border-black shadow p-3 mb-2 bg-white rounded">
        <div class="form-row d-flex justify-content-between">
            <button class="btn btn-sm btn-primary mb-1"><router-link tag="span" to="products/create"><i class="fa fa-plus mr-2"></i> Cadastrar</router-link></button>
            <input type="text" class="form-control form-control-sm col-md-4 mb-1" placeholder="Nome" v-model="filtro.name" @keyup="getCategorias">
            <select name="category_id" id="category_id" class="form-control form-control-sm col-md-4 mb-1" v-model="filtro.category_id" @change="getCategorias">
                <option selected :value="0">Categorias</option>
                <option v-for="categoria in categories" :value="categoria.id" :key="categoria.id">{{categoria.name}}</option>
            </select>
            <input class="form-control form-control-sm col-md-2 mb-1" type="search" name="nome" placeholder="Buscar">
        </div>
        <div class="table-responsive scroll" style="overflow-y:auto;height:300px;margin-top:2vh;">
            <table class="table table-hover table-bordered table-sm"> 
                <thead class="thead-light text-center">
                    <tr>
                        <th scope="col" class="col-form-label col-form-label-sm">Nome</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Descrição</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Categorias</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Preco</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Estoque</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Status</th>
                        <th scope="col" class="col-form-label col-form-label-sm">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="(product,indexProduto) of produtos" :key="product.id">
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{product.name}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{product.description}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{product.categories.name}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{product.price | formatPrice}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{product.estoque}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{product.status}}</td>
                        <td>
                            <div>
                                <router-link :to="`/products/${product.id}/edit`" class="btn btn-sm btn-warning ml-1"><i class="fa fa-pen"></i></router-link>
                                <button class="btn btn-sm btn-danger ml-1" data-toggle="modal" :data-target="`#produto${product.id}`"><i class="fa fa-trash"></i></button>
                                <modal class="del" :title="`Deseja remover o Produto`" :compl="`${product.name} ?`" :name="`produto${product.id}` ">
                                    <div class="modal-body text-left" >
                                        <button class="btn btn-sm btn-primary mr-2" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>  
                                        <button class="btn btn-sm btn-danger" @click="removeCategory(product.id,indexProduto)" :disabled="loading">
                                        <i v-if="!loading" class="fa fa-trash"></i>
                                        <i v-else class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true"></i>
                                        Deletar
                                        </button>
                                    </div>
                                </modal>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="loading"><td colspan="7" align="center" ><i  class="mt-2 spinner-border spinner-border spinner text-primary" role="status" aria-hidden="true"></i></td></tr>
                    <tr v-if="loading == false && produtos.length == 0"><td colspan="7"  align="center" style="border:0;margim-bottom:2px;"><label class="col-form-label col-form-label-sm">Nenhum registro encontrado.</label></td></tr>
                </tbody>
            </table> 
        </div>
    </div>
</main>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapState,mapActions,mapGetters} from 'vuex'
import axios from 'axios'
import $ from 'jquery'
import {API_BASE_URL} from '../../config/Api'
import '../../estilos/styles.css'
export default {
    name:'product',
    components:{
    Modal: () => import('../Modal/modal.vue')
  },
    data(){
        return {
            loading:false,
            product:{
                category_id:0,
                name:'',
                description:'',
                image:'',
                subtotal:'',
                amount:'',
                status:''
            },
            filtro:{
                name:null,
                category_id:0,
            },
        produtos:[],
        categories:[],
        update:{},
        isEdit:false,
        pesquisa:[], 
        searchCategory:[],
      };
    },

    created(){
        this.getCategorias()
        this.getProduto()
        this.$store.dispatch('Product/getProducts'),
        this.$store.dispatch('Category/setList')
    },
    methods:{
        ...mapActions('Product',['getProducts','putProducts','deleteProducts']),
        removeCategory(product,indexProduto){
          if(product){
            this.loading = true
            axios.delete(`${API_BASE_URL}/products/${product}`).then((res) => {
                if(res.data.status){
                    this.produtos.splice(indexProduto, 1);
                    this.$noty.success("Deletado com sucesso!!")
                    this.loading = false
                    $('.del').modal('hide');
                }else{
                    this.$noty.info("Houve erro na requisição!!")
                }
            })
          }
        },  
        getCategorias(){
            axios.get(`${API_BASE_URL}/get/categories`).then(res => {
                this.categories = res.data
            })
        },
        getProduto(){
            this.loading = true
            axios.post(`${API_BASE_URL}/filtro`,this.filtro).then(res => {
                this.produtos = res.data
            })
        },
    },
    
    computed:{
        ...mapState('Category',{list:state => state.list}),
        ...mapState('User',{user:state => state.user}),
        ...mapGetters('User',['isLogged']),
    },
}
   
</script>