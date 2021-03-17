

<template>
   <div class="plano-de-fundo">
    <fieldset class="form-group col-md-6">
      <h4 class="titulo"><i class="fa fa-user">  </i> Sistema de vendas </h4>
    <form @submit.prevent="login">
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" v-model="email" required class="form-control"><br>
        <label>Senha</label>
        <input type="password" name="password" v-model="password" required class="form-control"><br>
        <button class="btn btn-primary" :disabled="loading">Entrar</button><br><br>
        <p>Se você ainda não é um usuário <router-link to="/register">Registrar</router-link></p>
      </div>
    </form>
      </fieldset>
  </div>
</template>

<script>
export default {
  data () {
    return {
      email: '',
      password: '',
      loading:null
    }
  },

  methods: {
    login () {
      this.loading = true
      
      this.$store
        .dispatch('User/login', {
          email: this.email,
          password: this.password
        })
       .then(()=>{
         this.$noty.success('Bem vindo ao sistema!')
           this.$router.push('/perfil')
       }).catch(err => {
         console.log(err)
         this.$noty.info('houve um problema na altenticação')
         this.loading = false
       })
    },
  },
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