<template>
  <div>
      <h4 cabecalho="Produto">Clientes</h4>
        <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
            <li class="breadcrumb-item"><router-link to="/clients">Clientes</router-link></li>
           
            <li class="breadcrumb-item active" aria-current="page">Criar</li>
        </ol>
        </nav>
      <form @submit.prevent="onSubmit" class="form-group">

        <div class="row">  
            <div class="form-group col-md-3">
                <label for="">Nome</label>
                <input type="text" class="form-control" v-model="client.name" required>
            </div>

            <div class="form-grouṕ col-md-3">
                <label for="">CPF</label>
                <input type="text" class="form-control" v-model="client.cpf" @blur="verificaCpf()" required>
            </div>
          
            <div class="form-group col-md-3">
                <label for="">Email</label>
                <input type="email" class="form-control" v-model="client.email" required>
            </div>

            <div class="form-group col-md-3">
                <label for="">Data de nascimento</label>
                <input type="date" class="form-control" v-model="client.date_nasc" required>
            </div>

        </div>

        <div class="row">

           
            <div class="form-group col-sm-3">
                <label for="">CEP</label>
                <input type="text" class="form-control" v-model="client.cep" required>
            </div>

            <div class="form-group col-md-1">
                <label class="hidden" style="color:#fff;">Buscar</label>
                 <button type="button" class="form-control btn btn-primary col-md-auto" value="Buscar" @click.prevent="apicep"><i class="fa fa-search"></i></button>
            </div>

            <div class="form-group col-md-4">
                <label for="">Endereço</label>
                <input type="text" class="form-control" v-model="client.street" readonly required>
            </div>

            <div class="form-group col-md-2">
                <label for="">Bairro </label>
                <input type="text" class="form-control" v-model="client.heigthboard" readonly required>
            </div>

            <div class="form-group col-md-2">
                <label for="">Numero </label>
                <input type="text" class="form-control" v-model="client.number" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Complemento</label>
                <input type="text" class="form-control" v-model="client.complement">
            </div>

            <div class="form-group col-md-4"> 
                <label for="">Cidade</label>         
                <input type="text" class="form-control" v-model="client.city" readonly required>
            </div>

            <div class="form-group col-md-4">
                <label for="">Estado</label>
                <input type="text" class="form-control" v-model="client.state" readonly required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Telefone</label>
                <input type="text" class="form-control" @keyup="phoneValidator()" v-model="client.fone" required>
            </div>

            <div class="form-group col-md-4">
                <label for="">Celular</label>
                <input type="text" class="form-control" @keyup="phoneValidator()" v-model="client.celular" required>
            </div>

            <div class="form-group col-md-4">
                <label for="">Status</label>
                <select class="form-control" name="" id="" v-model="client.status">
                    <option selected disabled value=null>Selecione</option>
                    <option value=Ativo>Ativo</option>
                    <option value=Inativo>Inativo</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-10">
                <router-link to="/clients" tag="span"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>voltar</router-link>

            <button class="btn btn-success" style="float:right;" type="submit">Atualizar</button>
            </div>
        </div>
      </form>
  </div>
</template>

<script>
import axios from 'axios'
export default {
    
    name:'clientedit',

     created(){
        this.getClient()
    },

    data(){
        return{
           
            client:{}
        }
    },

    methods:{

        apicep(){
            fetch(`https://viacep.com.br/ws/${this.cep}/json/`)
            .then(response => response.json())
            .then(response => {
                    this.bairro = response.bairro
                    this.cidade = response.localidade
                    this.rua = response.logradouro
                    this.estado = response.uf
                    if(response.erro == true) {
                        alert('CEP inválido')
                    }
                    console.log(response)})
                    .catch((err) => {
                        console.log(err)
                        alert('cpf invalido')
                    })
            console.log(this.cep)
        },

        phoneValidator () {
            var x = this.client.telefone.replace(/\D/g, '').match(/(\d{0,2})(\d{0,4})(\d{0,4})/);
            this.client.telefone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        },

        celValidator(){
             var x = this.client.celular.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            this.client.celular = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        },    
        
        verificaCpf(){
            if(this.client.cpf.length < 14){
            alert('CPF inválido!')
            }
        },

        getClient(){
            axios.get(`http://localhost:8000/api/clients/${this.$route.params.client}`)
            .then(res => {
                this.client = res.data
            })
        },

        onSubmit(){
            axios.put(`http://localhost:8000/api/clients/${this.$route.params.client}`,this.client)
                .then(res => {
                     console.log(res.data)
                    this.$toasted.global.defaultSuccess()
                    setTimeout(() => {
                        this.$router.push('/clients')
                    },3000)
                }).catch(e => {
                    this.$toasted.global.defaultError()
                console.log('errrou',e)
            })
        }
    }

}
</script>

<style>
    span{
        cursor: pointer;
    }
</style>