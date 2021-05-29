

<template>
<div class="d-flex align-itens-center">
   <div class="card border border-black shadow-lg p-3 mb-2 bg-white rounded" style="width: 50rem;height:30rem">
    <div class="card-body">
      <div class="text-center">
        <h4><i class="fa fa-user">  </i> Sistema de vendas </h4>
      </div>
        <form @submit.prevent="register">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label class="col-form-label col-form-label-sm">Nome</label>
              <input type="text" name="name" v-model="form.name" required class=" form-control form-control-sm ">
            </div>

            <div class="form-group col-md-4">
              <label class="col-form-label col-form-label-sm">Email</label>
              <input type="email" name="email" v-model="form.email" required class=" form-control form-control-sm ">
            </div>

            <div class="form-group col-md-4">
                  <label class="col-form-label col-form-label-sm">TIpo de usuário</label>
                  <select class=" form-control form-control-sm col-12" v-model="form.type_user_id">
                      <option selected disabled value=null>Selecione</option>
                      <option  v-for="(category, key) in typeuser" :key="key" :value="category.id">{{category.descricao}}</option>
                  </select>
                </div>
          </div>

              <div class="form-row">
                <div class="form-group col-md-4">
                  <label class="col-form-label col-form-label-sm">Senha</label>
                  <input type="password" name="password" v-model="form.password" required class=" form-control form-control-sm">
                </div>

                <div class="form-group col-md-4">
                    <label class="col-form-label col-form-label-sm">Confirmação senha</label>
                    <input type="password" name="password_conformation" v-model="form.password_conformation" required class=" form-control form-control-sm">
                </div>
                <div class="form-group col-md-4"> 
                <label class="col-form-label col-form-label-sm">Data de nascimento</label>
                <input type="date" name="date" v-model="form.data_nasc" required class=" form-control form-control-sm ">
              </div>
                
              </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="col-form-label col-form-label-sm">Gênero</label>
                <select class=" form-control form-control-sm col-12" v-model="form.gender">
                    <option selected disabled value=null>Selecione</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label class="col-form-label col-form-label-sm">Telefone</label>
                <input type="text" name="email" v-model="form.phone" required class=" form-control form-control-sm ">
              </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label class="col-form-label col-form-label-sm">Sobre</label>
              <textarea type="text" name="name" v-model="form.about" required class=" form-control form-control-sm "></textarea>
            </div>
          </div>
            <button class="btn btn-sm btn-primary">Entrar</button><br><br>
        </form>
      </div>
  </div>
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
 
</style>