<template>
<div>
    <h4 cabecalho="Produto">Fornecedores</h4>
        <nav aria-label="breadcrumb mb-4">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Fornecedores</li>
            </ol>
        </nav>
    <router-link to="/providerstore" tag="span"><button class="btn btn-sm btn-primary">Cadastrar</button></router-link>
    <input class="form-control form-control-sm col-md-3 mb-3" type="search" style="float: right;" name="nome" placeholder="Buscar" v-model="buscar">
  
   <div class="table table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Nome/Razão Social</th>
                    <th scope="col">CNPJ/CPF</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contato</th>
                    <th scope="col">Status</th>
                    <th scope="col">Açôes</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr v-for="(provider,k) in pesquisar" :key="k" >
                    <td>{{provider.name}}</td>
                    <td>{{provider.cnpj_cpf}}</td>
                    <td>{{provider.email}}</td>
                    <td>{{provider.celular}}</td>
                    <td>{{provider.status}}</td>
                    <td class="align-middle" width="10%">  
                        <router-link :to="`/provideredit/${provider.id}/edit`" class="btn btn-sm btn-warning  m-1"><i class="fa fa-pen"></i></router-link>
                        <button  class="btn btn-sm btn-danger" @click="removeClient(provider)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
   </div>
</div>
</template>

<script>
import {API_BASE_URL} from '../../config/Api'
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import axios from 'axios'
import {mapActions} from 'vuex' 
import swal from 'sweetalert'
export default {
    data(){
        return {
            provider:{
                name:'',
                cnpj_cpf:'',
                email:'',
                cep:'',
                fone:'',
                celular:'',
                status:''
            },
        providers:[],
            buscar:[]
        }
    },
    created(){
        this.$store.dispatch('Provider/getProvider')
        this.getProvider()
    },
    
    methods:{
        ...mapActions('Provider',['getProvider']),
        getProvider(){
            axios.get(`${API_BASE_URL}/fornecedores`).then(res => {
                this.providers = res.data
            })
        },
        removeClient(provider){
            swal({
            title: "Você está certo disso ?",
            text: "Depois de excluído, você não será capaz de recuperar este arquivo!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                axios.delete(`http://localhost:8000/api/fornecedores/${provider.id}`)
            .then(res => {
                this.providers.splice(res.data.id,1)
                swal("Fornecedor deletado com sucesso!", {
                icon: "success",
                });
            })
            } else {
                swal("seu dado está a salvo");
            }
            });
               
        },
    },
    computed:{
     //   ...mapState('Provider',{providers:state => state.providers}),
        pesquisar:function(){
           return this.providers.filter(providers => {
                return providers.name.includes(this.buscar)
            })
        }
    }
}
</script>

<style>

</style>