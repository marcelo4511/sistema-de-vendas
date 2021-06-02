<template>
<div class="form-row">

   <div class="card border border-black shadow-lg p-2 bg-white rounded" style="width: 70rem;height:30rem">
    <div class="card-body" v-for="(u,k) in perfil" :key="k"> 
      <div class="col-12 d-flex justify-content-between">
        <p class="font-weight-bold">{{u.user.name}}</p>
        <p >Data da criação: {{u.user.created_at | formatDateTime}}</p>
      </div>
      <div class="col-12 d-flex justify-content-between"> 
        <img class="img-thumbnail" width="400" height="auto" src=".././assets/logo.png" alt="Card image cap">
        <div class="ml-5">
          <div class="form-row">
            <div class="form-group col-4">
              <label class="col-form-label col-form-label-sm font-weight-bold" for="">Email</label>
              <span class=" form-control form-control-sm  border-0">{{u.user.email}}</span>
            </div>

            <div class="form-group col-4">
              <label class="col-form-label col-form-label-sm font-weight-bold" for="">Data de Nascimento</label>
              <span class=" form-control form-control-sm border-0">{{u.data_nasc | formatDate}}</span>
            </div>

            <div class="form-group col-4">
              <label class="col-form-label col-form-label-sm font-weight-bold" for="">Genero</label>
              <span class=" form-control form-control-sm border-0">{{u.gender}}</span>
            </div>

            <div class="form-group col-4">
              <label class="col-form-label col-form-label-sm font-weight-bold" for="">Telefone</label>
              <span class=" form-control form-control-sm border-0">{{u.phone}}</span>
            </div>

            <div class="form-group col-6">
              <label class="col-form-label col-form-label-sm font-weight-bold" for="">Sobre</label>
              <span class=" form-control form-control-sm border-0">{{u.about}}</span>
            </div>
          </div>
        </div>

      </div>
   
      <div class="form-row">
        <h4 class="col-form-label col-form-label-sm font-weight-bold">Estatisticas :</h4>
      </div>

      <div class="form-row border border-black p-2 mb-2">
        <div class="form-group col-12 col-md-4 col-lg-4">
          <label class="col-form-label col-form-label-sm" ><b>Vendas</b> </label><br/><br/>
          <span class="alert alert-dark mr-2" style="color:black;"><b>{{realizadas}}</b></span>
          <span class="alert alert-danger mr-2" style="color:red;"><b>{{andamento}}</b></span>
          <span class="alert alert-success" style="color:green;"><b >{{concluidas}}</b></span>
        </div>

        <div class="form-group col-12 col-md-4 col-lg-4">
          <label class="col-form-label col-form-label-sm" ><b>Compras</b> </label><br/><br/>
          <span class="alert alert-dark mr-2" style="color:black;"><b>{{realizadas}}</b></span>
          <span class="alert alert-danger mr-2" style="color:red;"><b>{{andamento}}</b></span>
          <span class="alert alert-success" style="color:green;"><b >{{concluidas}}</b></span>
        </div>

        <div class="form-group col-12 col-md-4 col-lg-4">
          <label class="col-form-label col-form-label-sm" ><b>Lucro</b> </label><br/><br/>
          <span class="alert alert-dark mr-2" style="color:black;"><b>{{realizadas}}</b></span>
          <span class="alert alert-danger mr-2" style="color:red;"><b>{{andamento}}</b></span>
          <span class="alert alert-success" style="color:green;"><b >{{concluidas}}</b></span>
        </div>
      </div>

      <div class="form-row">
        <span class="alert alert-light mr-2"  style="color:black;"><b>Realizadas</b></span> 
        <span class="alert alert-light mr-2" style="color:red;"><b>Em andamento</b></span> 
        <span class="alert alert-light" style="color:green;"><b>Concluidas</b></span>
      </div>
    </div>
   </div>
</div>
</template>

<script>
import axios from 'axios'
export default {
data(){
  return {
   perfil:null,
   andamento:null,
   realizadas:null,
   concluidas:null
  }
},
created(){
  this.getUsuario()
  this.getAndamento()
  this.getRealizadas()
  this.getConcluidas()
},
 methods:{
   getUsuario() {

     axios.get(`http://localhost:8000/api/usuario`).then(res => {
       this.perfil = res.data
       console.log(res.data)
     })
   },
   getAndamento(){
     axios.get(`http://localhost:8000/api/salesemandamento`).then(res => {
       this.andamento = res.data.length
       console.log(this.andamento)
     })
   },
   getRealizadas(){
     axios.get(`http://localhost:8000/api/saleusuario`).then(res => {
       this.realizadas = res.data.length
     //  console.log(this.concluido)
     })
   },
   getConcluidas(){
     axios.get("http://localhost:8000/api/saleaprovadas").then(res => {
       this.concluidas = res.data.length

       console.log(this.c)
     })
   }
 },
}
</script>

<style>
</style>