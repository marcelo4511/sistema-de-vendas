<template>

<main>
<h4 cabecalho="Produto">Produtos</h4>
  <nav aria-label="breadcrumb mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
      <li class="breadcrumb-item active" aria-current="page">Produtos</li>
    </ol>
  </nav>
  <form @submit.prevent="onSubmit">
      <div class="row ">
          <div class="form-group col-md-6">
            <label class="col-form-label col-form-label-sm">Nome</label>
            <input class="form-control form-control-sm col-md-auto " type="text" name="name " required v-model="product.name" @input="product.name = $event.target.value.toUpperCase()">
          </div>
          <div class="form-group col-md-6">
            <label class="col-form-label col-form-label-sm">Descrição</label>
            <input type="text" name="description" class="form-control form-control-sm col-md-auto" required v-model="product.description">
          </div>     
          <div class="form-group col-md-6">
            <label class="col-form-label col-form-label-sm">Categorias</label>
            <select v-model="product.category_id" required class="form-control form-control-sm col-md-auto">
              <option  disabled selected value="">selecione</option>
              <option  v-for="(category, key) in list" v-show="category.status == 'Ativo'" :key="key" :value="category.id">{{category.name}}</option>
            </select>
          </div> 
        <div class="form-group col-md-4">
          <label class="col-form-label col-form-label-sm">Imagem</label>
          <input type="file" name="imagem" class="form-control form-control-sm" v-on:change="uploadImagem" >
        </div>  

        <div class="form-group col-md-2" style="margin-top:30px;" v-if="product.imagem !== null">
          <a class="btn btn-sm btn-primary text-white mr-1" data-toggle="modal" :data-target="`#mostrar_imagem_${product.id}`"><i class="fa fa-camera"></i></a>
          <modal  :name="`mostrar_imagem_${product.id}` ">
            <div class="modal-body"  align="center" width="400px;">
              <div class="mx-auto">
                <embed  style="height:450px;width:450px;border: none;"  :src="product.imagem"/>
              </div>
            </div>
          </modal>
          <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" :data-target="`#deletar_imagem_${product.id}`"><i class="fas fa-trash"></i></button>
          <modal :title="'Deseja realizar a operação ?'" :name="`deletar_imagem_${product.id}` ">
              <div class="modal-body row text-left">
                  <div class="mx-auto">
                      <button  type="button" :class="['btn btn-sm btn-danger mr-1',{'disabled' : loading}]" @click="deleteFoto(product.id)">
                          <i v-if="loading" class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true"></i>
                          <i v-else class="fas fa-trash mr-2"></i>Deletar
                      </button>
                      <button class="btn btn-sm btn-primary" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                  </div>
              </div>
          </modal>
        </div>
      </div>
        
      <div class="row"> 
        <div class="form-group col-md-4">
         <label class="col-form-label col-form-label-sm">Preço</label>
         <money v-model="product.price" v-bind="money" class="form-control form-control-sm col-md-auto"></money>
        </div>  

        <div class="form-group col-md-4">
         <label class="col-form-label col-form-label-sm">Estoque</label>
         <input type="number" name="estoque"  class="form-control form-control-sm col-md-auto" required  v-model="product.estoque">
        </div>  

       <div class="form-group col-md-4">
          <label class="col-form-label col-form-label-sm">Status</label>
          <select class="form-control form-control-sm col-12" v-model="product.status">
              <option selected disabled value=null>Selecione</option>
              <option value=Ativo>Ativo</option>
              <option value=Inativo>Inativo</option>
          </select>
        </div>
      </div>
      <button type="submit" class="btn btn-sm btn-info" :disabled="loading"> 
        <i v-if="loading" class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true"></i>Atualizar
      </button>
    </form>
    </main>
</template>
<script>
import {mapState,mapActions} from 'vuex'
import axios from 'axios'
import {VMoney} from 'v-money'
import {API_BASE_URL} from '../../config/Api'
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import '../../estilos/styles.css'
export default {
   components:{
      Modal: () => import('../Modal/modal.vue')
    },
    name:'product',
    data(){
        return {
            product:{
                category_id:'',
                name:'',
                description:'',
                imagem:'',
                price:'',
                estoque:'',
                status:''
            },
            loading:false,
            produtos:[],
            categories:[],
            update:{},
            isEdit:false,
            pesquisa:[], 
            total:0,
            count:0,

            money: {
            decimal: ',',
            thousands: '.',
            precision: 2,
            masked: false 
        },
      };
      
    },
      directives: {money: VMoney},

    created(){
        this.getProduct()
        this.$store.dispatch('Category/setList')
    },
    methods:{
        ...mapActions('Product',['postProducts']),

        getProduct(){
          axios.get(`${API_BASE_URL}/products/${this.$route.params.product}`)
          .then(res => {
            this.product = res.data
          })
        },
        deleteFoto(id){
          this.loading = true
          axios.delete(`${API_BASE_URL}/productdeletefoto/${id}`).then(res => {
            this.loading = false
            if(res.data.success) {
              this.$noty.success("Imagem deletada com sucesso!!") 
              document.location.reload(true);
            }else if (res.data.error) {
              this.$noty.info("Houve um problema com o seu formulário. Por favor, tente novamente.");
                this.$forceUpdate();  
            }
          })
        },
        uploadImagem(e) {
          let arquivo = e.target.files ?? e.dataTransfer.files
          if(!arquivo.length){
            return
          }
          let reader = new FileReader()
          reader.onload = (e) => {
            this.product.imagem = e.target.result
          }
           console.log(reader)
         return reader.readAsDataURL(arquivo[0])
        },
        onSubmit(){
          this.loading = true
          axios.put(`${API_BASE_URL}/products/${this.$route.params.product}`,this.product).then(() => {
            this.$noty.success("Atualizado com sucesso!!") 
             setTimeout(() => {
              this.$router.push('/products')
            },3000)
              this.loading = false
            }).catch(() => {
              this.$noty.info("Houve um problema com o seu formulário. Por favor, tente novamente.");
          })
        },
    },
    
    computed:{
      ...mapState('Product',{products:state => state.products}),
      ...mapState('Category',{list:state => state.list.data}),
    },
    
}
   
</script>

<style>
   img{
       width: 100px;
       height: 100px;
   }
</style>
