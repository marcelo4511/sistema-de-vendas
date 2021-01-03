<template>
  <table>
    <thead>
      <th>Email</th>
      <th>Nome</th>
      <th>Telefone</th>
    </thead>
    <tbody>
      
        <td>{{user.email}}</td>
        <td>{{user.name}}</td>
        <td>{{user.phone}}</td>
      
    </tbody>
  </table>
</template>

<script>
import axios from 'axios'
//import {mapGetters,mapState}from 'vuex'
export default {
data(){
  return{
    user:{
      email:'',
      name:'',
      phone:''
    }
  }
},
created() {
  this.getUser()
},

 methods:{
   getUser() 
   {
      axios.get(`http://localhost:8000/api/user/${this.$route.params.user}`).then(res => {
        this.user = res.data
      })
   }
 }
}
</script>

<style>

</style>