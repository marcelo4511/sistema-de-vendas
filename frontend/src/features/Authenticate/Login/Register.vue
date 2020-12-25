

<template>

   <div class="plano-de-fundo">
    <fieldset class="form-group col-md-6">
      <h4 class="titulo"><i class="fa fa-user">  </i> Sistema de vendas </h4>
    <form @submit.prevent="register">
      <div class="form-group">
        <label>Nome</label>
        <input type="text" name="name" v-model="form.name" required class="form-control"><br>
        <label>Email</label>
        <input type="email" name="email" v-model="form.email" required class="form-control"><br>
         <label>Confirmação senha</label>
        <input type="password" name="password_conformation" v-model="form.password_conformation" required class="form-control"><br>
        <label>Senha</label>
        <input type="password" name="password" v-model="form.password" required class="form-control"><br>
        <button class="btn btn-primary">Entrar</button><br><br>
      </div>
    </form>
      </fieldset>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data () {
    return {
      form:{
        name:'',
        email: '',

      password: '',
      password_confirmation:''
      }
    }
  },

  methods: {
    register () {
        axios.post('http://localhost:8000/api/register',this.form).then(res => {
          console.log(res.data)
          this.$router.push('/')
          this.$noty.success("Usuário cadastrado com sucesso!.");
        })
    }
  }
}
</script>

<style>
  div .plano-de-fundo{
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    margin-left: 150px;
  }
  div .plano-de-fundo p{
    display: flex;
    justify-content: center;
    align-items: center;
  }
  div .titulo{
    display: flex;
    align-items: center;
    margin: 20px;
    justify-content: center;
  }
</style>