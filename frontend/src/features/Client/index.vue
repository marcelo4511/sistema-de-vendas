<template>
<div>
    <h4 cabecalho="Produto">Clientes</h4>
        <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
           
            <li class="breadcrumb-item active" aria-current="page">Clientes</li>
        </ol>
        </nav>
  <router-link to="/clientstore" tag="span"><button class="btn btn-primary">Cadastrar</button></router-link>

     <input class="form-control col-md-3 mb-3" type="search" style="float: right;" name="nome" placeholder="Buscar" v-model="buscar">
  
  <table class="table table-sm">
      <thead>
          <tr>
              <th scope="col">Nome</th>
              <th scope="col">CPF</th>
              <th scope="col">Email</th>
              <th scope="col">Celular</th>
              <th scope="col">Status</th>
              <th scope="col">Açôes</th>
                
          </tr>
      </thead>
      <tbody>
          <tr v-for="(client,k) in pesquisar" :key="k" >
              <td>{{client.name}}</td>
              <td>{{client.cpf}}</td>
              <td>{{client.email}}</td>
              <td>{{client.celular}}</td>
              <td>{{client.status}}</td>

              <td>  
                    
                    <router-link :to="`/clientedit/${client.id}/edit`" class="btn btn-warning"><i class="fa fa-pen"></i></router-link>
                    <button  class="btn btn-danger ml-2" @click="removeClient(client)"><i class="fa fa-trash"></i></button>
              </td>
          </tr>

      </tbody>
  </table>
</div>
</template>

<script>
import axios from 'axios'
import {mapActions, mapState} from 'vuex' 
import swal from 'sweetalert'
export default {
    data(){
        return {
            client:{
                name:'',
                cpf:'',
                email:'',
                cep:'',
                fone:'',
                celular:'',
                status:''
            },
           
            buscar:[]
        }

    },
    created(){
        this.$store.dispatch('Client/getClient')
    },
    methods:{
        ...mapActions('Client',['getClient']),

        removeClient(client){
            swal({
            title: "Você está certo disso ?",
            text: "Depois de excluído, você não será capaz de recuperar este arquivo!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                axios.delete(`http://localhost:8000/api/clients/${client.id}`)
            .then(res => {
                this.clients.splice(res.data.id,1)
                swal("Cliente deletado com sucesso!", {
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
        ...mapState('Client',{clients:state => state.clients}),
        pesquisar:function(){
           return this.clients.filter(client => {
                return client.name.includes(this.buscar)
            })
        }
    }
}
</script>

<style>

</style>