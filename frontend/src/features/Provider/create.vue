<template>
  <div>
      <h4 cabecalho="Produto">Fornecedores</h4>
        <nav aria-label="breadcrumb mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                <li class="breadcrumb-item"><router-link to="/providers">Fornecedores</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Criar</li>
            </ol>
        </nav>
      <form @submit.prevent="onSubmit" class="form-group">
        <div class="row">  
            <div class="form-group col-md-6 col-lg-3">
                <label for="">Nome/Razão Social</label>
                <input type="text" class="form-control form-control-sm" v-model="provider.name" required>
            </div>
            <div class="form-grouṕ col-md-6 col-lg-3">
                <label for="">CNPJ/CPF</label>
                <input type="text" class="form-control form-control-sm" v-model="provider.cnpj_cpf" v-mask="['###.###.###-##', '##.###.###/####-##']" required>
            </div>
            <div class="form-group col-md-6 col-lg-3">
                <label for="">Email</label>
                <input type="email" class="form-control form-control-sm" v-model="provider.email" required>
            </div>
            <div class="form-group col-md-6 col-lg-3">
                <label for="">Nome responsável</label>
                <input type="text" class="form-control form-control-sm" v-model="provider.responsavel" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3 col-sm-3">
                <label for="">CEP</label>
                <input type="text" class="form-control form-control-sm"  v-model="provider.cep"  v-mask = "'#####-###'" required>
            </div>
            <div class="form-group col-9 col-md-2 col-lg-1">
                <label class="hidden" style="color:#fff;">Buscar</label>
                 <button type="button" class="form-control form-control-sm btn btn-primary col-lg-auto" value="Buscar" @click.prevent="apicep"><i class="fa fa-search"></i></button>
            </div>
            <div class="form-group col-md-7 col-lg-4">
                <label for="">Endereço</label>
                <input type="text" class="form-control form-control-sm" v-model="provider.street" readonly required>
            </div>
            <div class="form-group col-md-6 col-lg-2">
                <label for="">Bairro </label>
                <input type="text" class="form-control form-control-sm" v-model="provider.heigthboard" readonly required>
            </div>
            <div class="form-group col-md-6 col-lg-2">
                <label for="">Numero </label>
                <input type="text" class="form-control form-control-sm" v-model="provider.number" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3 col-lg-4">
                <label for="">Complemento</label>
                <input type="text" class="form-control form-control-sm" v-model="provider.complement">
            </div>
            <div class="form-group col-md-3 col-lg-4"> 
                <label for="">Cidade</label>         
                <input type="text" class="form-control form-control-sm" v-model="provider.city" readonly required>
            </div>
            <div class="form-group col-md-6 col-lg-4">
                <label for="">Estado</label>
                <input type="text" class="form-control form-control-sm" v-model="provider.state" readonly required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3 col-lg-4">
                <label for="">Contato 1</label>
                <input type="text" @input="phoneValidator()" class="form-control form-control-sm" v-model="provider.fone" required>
            </div>
            <div class="form-group col-md-3 col-lg-4">
                <label for="">Contato 2</label>
                <input type="text" class="form-control form-control-sm" @input="celValidator()" v-model="provider.celular" required>
            </div>
            <div class="form-group col-md-6 col-lg-4">
                <label for="">Status</label>
                <select class="form-control form-control-sm" name="" id="" v-model="provider.status">
                    <option selected disabled value=null>Selecione</option>
                    <option value=Ativo>Ativo</option>
                    <option value=Inativo>Inativo</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-10 col-lg-10">
                <router-link to="/providers" tag="span"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>voltar</router-link>
                <button class="btn btn-sm btn-success" style="float:right;" type="submit">Salvar</button>
            </div>
        </div>
      </form>
  </div>
</template>

<script>
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import {mapActions,mapState} from 'vuex'
import {mask} from 'vue-the-mask'
export default {
     directives: {mask},
    name:'providerstore',

    data(){
        return{
            provider:{
                name:'',
                cnpj_cpf:'',
                responsavel:'',
                email:'',
                cep:'',
                street:'',
                number:'',
                complement:'',
                city:'',
                state:'',
                heigthboard:'',
                fone:'',
                celular:'',
                status:'',
            }
        }
    },

    methods:{
        ...mapActions('Provider',['postProvider']),
        apicep(){
            fetch(`https://viacep.com.br/ws/${this.provider.cep}/json/`).then(response => response.json()).then(response => {
                    this.provider.heigthboard = response.bairro
                    this.provider.city = response.localidade
                    this.provider.street = response.logradouro
                    this.provider.state = response.uf
                if(response.erro == true) {
                    alert('CEP inválido')
                }
            })
            .catch((err) => {
                console.log(err)
                alert('CEP inválido')
            })
        },
        
        phoneValidator () {
            var x = this.provider.fone.replace(/\D/g, '').match(/(\d{0,2})(\d{0,4})(\d{0,4})/);
            this.provider.fone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        },

        celValidator(){
             var x = this.provider.celular.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            this.provider.celular = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        },    
        onSubmit(){
            this.$store.dispatch('Provider/postProvider',this.provider)
            try {
                this.$noty.success("Cadastrado com sucesso!!") 
                    setTimeout(() => {
                        this.$router.push('/providers')
                },3000)    
            }catch(e) {
                this.$noty.info("Houve um problema com o seu formulério. Por favor, tente novamente.",e);
            }
        },
    },
    computed:{
        ...mapState('Provider',{providers:state => state.providers}),
    },
    watch:{
        'provider.name': function(name){
            if(name) {
                return this.provider.name = name[0].toUpperCase() + name.substr(1)  
            }else if(name == undefined){
                return null
            }
        }
    },
}
</script>

<style>
    span{
        cursor: pointer;
    }
</style>