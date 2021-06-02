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
            <button class="btn btn-sm btn-primary "><router-link tag="span" to="products/create"><i class="fa fa-plus mr-2"></i> Cadastrar</router-link></button>
            <input type="text" class="form-control form-control-sm col-4" placeholder="Nome" v-model="filtro.name" @keyup="filter">
            <select name="category_id" id="category_id" class="form-control form-control-sm col-4" v-model="filtro.category_id" @change="filter">
                <option selected :value="0">Categorias</option>
                <option v-for="categoria in categories" :value="categoria.id" :key="categoria.id">{{categoria.name}}</option>
            </select>
            <input class="form-control form-control-sm col-md-2" type="search" name="nome" placeholder="Buscar">
        </div>
        <div class="table-responsive scroll" ref="scroll" style="overflow-y:auto;height:300px;margin-top:1vh;">
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
                    <tr v-for="product of produtos" :key="product.id">
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{product.name}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{product.description}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{product.categories.name}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{product.price | formatPrice}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{product.estoque}}</td>
                        <td class="align-middle" style="font-size: 1em; height:10px;">{{product.status}}</td>
                        <td>
                            <div>
                                <router-link :to="`/products/${product.id}/edit`" class="btn btn-sm btn-warning m-1"><i class="fa fa-pen"></i></router-link>
                                <button class="btn btn-sm btn-danger" @click="removeClient(product)"> <i class="fa fa-trash"></i> </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table> 
            <div v-show="loading && produtos.length == 0" style="text-align:center;"><label class="col-form-label col-form-label-sm">Nenhum registro encontrado.</label> </div>
        </div>
    </div>
</main>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapState,mapActions,mapGetters} from 'vuex'
import axios from 'axios'
import swal from 'sweetalert'
import {API_BASE_URL} from '../../config/Api'
import '../../estilos/styles.css'
export default {
    name:'product',
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
        this.listar()
        this.getProduto()
        this.$store.dispatch('Product/getProducts'),
        this.$store.dispatch('Category/setList')
    },
    methods:{
        ...mapActions('Product',['getProducts','putProducts','deleteProducts']),

       removeClient(product){
            swal({
            title: "Você está certo disso ?",
            text: "Depois de excluído, você não será capaz de recuperar este arquivo!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                axios.delete(`${API_BASE_URL}/products/${product.id}`)
            .then(() => {
                    document.location.reload(true);
                    swal("Produto deletado com sucesso!", {
                    icon: "success",
                });
            })
            } else {
                swal("seu dado está a salvo");
            }
            });
               
        },
        mostrar(product){
         const url = `${API_BASE_URL}/products/${product.id}`
            axios.get(url).then(resposta => {
                resposta.data
            })
        },
        listar(){
            axios.get(`${API_BASE_URL}/categories`).then(res => {
                this.categories = res.data.data
            })
        },
        filter(){
            this.loading = true
            axios.post(`${API_BASE_URL}/filtro`,this.filtro).then(res => {
                this.produtos = res.data
            })
        },
        getProduto(){
            axios.get(`${API_BASE_URL}/products`).then(res => {
                this.produtos = res.data
            })
        }
    },
    
    computed:{
        ...mapState('Category',{list:state => state.list}),
        ...mapState('User',{user:state => state.user}),
        ...mapGetters('User',['isLogged']),
    },
}
   
</script>