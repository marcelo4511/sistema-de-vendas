<template>

<main>
    <h4 cabecalho="Produto">Produtos</h4>
    <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
        
            <li class="breadcrumb-item active" aria-current="page">Produtos</li>
        </ol>
    </nav>
    
    <div class="row">
       
    </div>
    <div class="row">
        <div class="col-md-12 d-flex justify-content-beetween">
        
            
            <div class="d-flex justify-content-start">

            <input type="text" class="form-control mr-1" placeholder="Buscar por nome do produto" v-model="filtro.name" @keyup="filter">
            <select name="category_id" id="categort_id" class="form-control" style="margin-right:600px;" v-model="filtro.category_id" @change="filter">
                <option v-for="l in categories" :value="l.id" :key="l.id">{{l.name}}</option>
            </select>
            </div>
 
        <div class="d-flex justify-content-end">

        <div v-for="(u,k) in user" :key="k">
            <button class="btn btn-primary " v-show="u.type_user_id  == 1"><router-link tag="span" to="products/create">Cadastrar</router-link></button>
        </div>
        </div>
        </div>
    </div>

    <table class="table responsive-sm"> 
        <thead>
            <tr>
                <th scope="col">Imagem</th>
                <th scope="col">Nome</th>
                <th scope="col">Descrição</th>
                <th scope="col">Categorias</th>
                <th scope="col">Preco</th>
                <th scope="col">Estoque</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="product of produtos" :key="product.id">
                <td><img :src=product.name alt="imagem"></td>
                <td>{{product.name}}</td>
                <td>{{product.description}}</td>
                <td>{{product.categories.name}}</td>
                <td>{{product.price}}</td>
                <td>{{product.estoque}}</td>
                <td>{{product.status}}</td>
                
                <td v-for="(u,k) in user" :key="k">
                    <div v-show="u.type_user_id === 1">
                        <router-link :to="`/products/${product.id}/edit`" class="btn btn-warning m-1"><i class="fa fa-pen"></i></router-link>
                        <button class="btn btn-danger" @click="removeClient(product)"> <i class="fa fa-trash"></i> </button>
                    </div>
                </td>
            </tr>
        </tbody>
        <hr>
    </table> 

</main>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapState,mapActions,mapGetters} from 'vuex'
import axios from 'axios'
import swal from 'sweetalert'
import '../../estilos/styles.css'
export default {
    name:'product',
    data(){
        return {
            product:{
                category_id:'',
                name:'',
                description:'',
                image:'',
                subtotal:'',
                amount:'',
                status:''
            },
            filtro:{
                name:null,
                category_id:null,
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
        this.$store.dispatch('Category/setList')// dispatch loading

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
                axios.delete(`http://localhost:8000/api/products/${product.id}`)
            .then(res => {
                this.products.splice(res.data.id,1)
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
         const url = `http://localhost:8000/api/products/${product.id}`
            axios.get(url).then(resposta => {
                resposta.data
            })
        },
        listar(){
            axios.get('http://localhost:8000/api/categories').then(res => {
                this.categories = res.data.data
            })
        },
        filter(){
            axios.post('http://localhost:8000/api/filtro',this.filtro).then(res => {
                this.produtos = res.data
            })
        },
        getProduto(){
            axios.get('http://localhost:8000/api/products').then(res => {
                this.produtos = res.data
            })
        }
    },
    
    
    computed:{
        ...mapState('Category',{list:state => state.list}),
       // ...mapState('Product',{products:state => state.products}),

        ...mapState('User',{user:state => state.user}),
        ...mapGetters('User',['isLogged']),

     //   pesquisar:function() {
        //    return this.products.filter(product => {
        //        return product.description.includes(this.pesquisa)
        //    })
      //  },
    },
    
}
   
</script>

<style>
   img{
       width: 100px;
       height: 100px;
   }

</style>