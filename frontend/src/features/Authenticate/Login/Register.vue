

<template>

   <div >
    <fieldset class="form-group">
      <h4 class="titulo"><i class="fa fa-user">  </i> Sistema de vendas </h4>
    <form @submit.prevent="register">

      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Nome</label>
          <input type="text" name="name" v-model="form.name" required class="form-control col-md-auto ">
        </div>

        <div class="form-group col-md-6">

          <label>Email</label>
          <input type="email" name="email" v-model="form.email" required class="form-control col-md-auto ">
        </div>
      </div>

          <div class="form-row">
            <div class="form-group col-md-6">

              <label for="">TIpo de usuário</label>
                <select class="form-control col-12" v-model="form.type_user_id">
                    <option selected disabled value=null>Selecione</option>
                    <option  v-for="(category, key) in typeuser" :key="key" :value="category.id">{{category.descricao}}</option>
                </select>
            </div>

            <div class="form-group col-md-6">

              <label>Confirmação senha</label>
                <input type="password" name="password_conformation" v-model="form.password_conformation" required class="form-control">
            </div>
          </div>

            <div class="form-group col-md-6">

              <label>Senha</label>
              <input type="password" name="password" v-model="form.password" required class="form-control">
            </div>

            <div class="form-row">
        <div class="form-group col-md-6"> 
          <label>Data de nascimento</label>
          <input type="date" name="date" v-model="form.data_nasc" required class="form-control col-md-auto ">
        </div>

        <div class="form-group col-md-6">

          <label>Gênero</label>
          <select class="form-control col-12" v-model="form.gender">
              <option selected disabled value=null>Selecione</option>
              <option value="Masculino">Masculino</option>
              <option value="Feminino">Feminino</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Sobre</label>
          <input type="text" name="name" v-model="form.about" required class="form-control col-md-auto ">
        </div>

        <div class="form-group col-md-6">

          <label>Telefone</label>
          <input type="text" name="email" v-model="form.phone" required class="form-control col-md-auto ">
        </div>
      </div>
        <button class="btn btn-primary">Entrar</button><br><br>
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
        type_user_id:'',
        password: '',
        password_confirmation:'',

        data_nasc:'',
        gender:'',
        about:'',
        phone:''
      },
      typeuser:[],
    }
  },
  created(){
    this.getTypeuser()
  },
  methods: {
    register () {
        axios.post('http://localhost:8000/api/register',this.form).then(res => {
          console.log(res.data)
          this.$router.push('/')
          this.$noty.success("Usuário cadastrado com sucesso!.");
        })
    },
    getTypeuser(){
      axios.get('http://localhost:8000/api/typeuser').then(res => {
        this.typeuser = res.data
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