

<template>
<div class="d-flex justify-content-md-center">
   <div class="card">
    <div class="card-body">
      <div class="text-center">
        <h4><i class="fa fa-user"></i> Sistema de vendas </h4>
      </div>
        <form @submit.prevent="login">
          <div >
            <label>Email</label>
            <input type="email" name="email" v-model="email" required class="form-control form-control-sm"><br>
            <label>Senha</label>
            <input type="password" name="password" v-model="password" required class="form-control form-control-sm"><br>
            <button class="btn btn-sm btn-primary" :disabled="loading">Entrar</button><br><br>
            <p>Se você ainda não é um usuário <router-link to="/register">Registrar</router-link></p>
          </div>
        </form>
      </div>
  </div>
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
      this.$store.dispatch('User/login', {
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
 
</style>