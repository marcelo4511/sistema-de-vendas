<template>
<div>
  <h4 cabecalho="Produto">Usuários</h4>
<nav aria-label="breadcrumb mb-4">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
  
    <li class="breadcrumb-item active" aria-current="page">Usuários</li>
  </ol>
</nav>
<div class="form-group">
    <button class="btn btn-primary"><router-link tag="span" to="users/create">Cadastrar</router-link></button>
 
  <input class="form-control col-md-3 mb-3" type="search" style="float: right;" name="nome" placeholder="Buscar" v-model="search" @input="get">

</div>

  <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                      <th scope="col">Tipo de Usuário</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(user,i) in users" :key="i">
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                     <td>{{user.tipo_usuario.descricao}}</td>
                    <td>
                        <button class="btn btn-warning ml-2"><i class="fa fa-edit"></i></button>
                        <button @click="removeList(user)" class="btn btn-danger ml-2"><i class="fa fa-trash"></i></button>
                    </td>
                  
                </tr>
                </tbody>
            </table>
        
  </div>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import axios from 'axios'
import { API_BASE_URL } from '../../config/Api'
//import swal from 'sweetalert'
export default {
 data(){
      return{
       
        users:[],
        search:[]
      }
    },
  name:'users',
  created(){
    this.setUsers()
  },
 methods:{
    setUsers(){
        axios.get(`${API_BASE_URL}/users`).then(res => {
            this.users = res.data
        })
    },
        get(){
       
          axios.get(`${API_BASE_URL}/search?q=${this.search}`).then(res => {
              this.users = res.data
        })
        }
      },
}
</script>

<style>
    
</style>