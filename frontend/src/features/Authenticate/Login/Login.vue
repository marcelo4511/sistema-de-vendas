

<template>
<div class="d-flex align-itens-center">
   <div class="card border border-black shadow-lg p-3 mb-2 bg-white rounded" style="width: 50rem;height:20rem">
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
            <p>Se você ainda não é um usuário <router-link to="/register"><span class="ml-3">Registrar</span> </router-link></p>
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