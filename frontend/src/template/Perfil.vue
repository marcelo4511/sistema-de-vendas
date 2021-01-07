<template>
<div>
  <div class="card">
    <div class="card-body" v-for="(u,k) in perfil" :key="k"> 
      <div class="d-flex justify-content-between">
        <h5 class="card-title font-weight-bold">{{u.user.name}}</h5>
        <p style="width:100px;font-size:10px;">Data da criação: {{u.user.created_at | formatDateTime}}</p>
      </div>
      <div class="d-flex justify-content-between"> 
        <div>
          <img class="rounded-circle" src=".././assets/logo.png" alt="Card image cap">
          <p class="card-text" style="margin-left:50px;margin-top:25px;font-weight: bolder;">{{u.user.tipo_usuario.descricao}}</p>
        </div>

        <div>
          <div class="form-row">
            <div class="form-group col-6">
              <label class="font-weight-bold" for="">Email</label>
              <span class="form-control border-0">{{u.user.email}}</span>
            </div>

            <div class="form-group col-6">
              <label class="font-weight-bold" for="">Data de Nascimento</label>
              <span class="form-control border-0">{{u.data_nasc | formatDate}}</span>
            </div>

            <div class="form-group col-6">
              <label class="font-weight-bold" for="">Genero</label>
              <span class="form-control border-0">{{u.gender}}</span>
            </div>

            <div class="form-group col-6">
              <label class="font-weight-bold" for="">Telefone</label>
              <span class="form-control border-0">{{u.phone}}</span>
            </div>

            <div class="form-group col-6">
              <label class="font-weight-bold" for="">Sobre</label>
              <span class="form-control border-0">{{u.about}}</span>
            </div>
          </div>
        </div>

      </div>

      <p class="font-weight-bold" style="margin-bottom:-30px">Estatisticas :</p>
      <div class="venda">
        <p style="margin-bottom:-30px;">Vendas</p>
        <span class="estat1">{{realizadas}}</span> <span class="estat2">{{andamento}}</span> <span class="estat3">{{concluidas}}</span>
      </div>

      <div style="margin-top:-30px">

      <span class="estat1">Realizadas</span> <span class="estat2"> Em andamento</span> <span class="estat3">concluidas</span>
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
 img{
   width: 150px;
   height: 150px;
   background-color: black;
 }

 .venda{
  margin-top: 10px;
   height: 30px;
   margin-bottom: 120px;
 }
 .estat1{
  
   padding: 5px;
   border-radius:  4px;
   background-color: blue;
   color:white;
 }

 .estat2{
   
   height: 20px;
   padding: 5px;
   border-radius:  4px;
   background-color: #120a128f;
   color:white;
 }

 .estat3{
   
   padding: 5px;
   border-radius:  4px;
   background-color: green;
   color:white;
 }
</style>