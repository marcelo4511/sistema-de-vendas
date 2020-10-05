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
                <input type="text" class="form-control" v-model="client.cpf" @blur="verificaCpf()" v-mask = "'###.###.###-##'" required>
            </div>
          
            <div class="form-group col-md-3">
                <label for="">Email</label>
                <input type="email" class="form-control" v-model="client.email" required>
            </div>

            <div class="form-group col-md-3">
                <label for="">Data de nascimento</label>
                <input type="date" class="form-control" v-model="client.data_nasc" required>
            </div>

        </div>

        <div class="row">

           
            <div class="form-group col-sm-3">
                <label for="">CEP</label>
                <input type="text" class="form-control"  v-model="client.cep"  v-mask = "'#####-###'" required>
            </div>

            <div class="form-group col-md-1">
                <label class="hidden" style="color:#fff;">Buscar</label>
                 <button type="button" class="form-control btn btn-primary col-md-auto" value="Buscar" @click.prevent="apicep"><i class="fa fa-search"></i></button>
            </div>

            <div class="form-group col-md-4">
                <label for="">Endereço</label>
                <input type="text" class="form-control" v-model="client.rua" readonly required>
            </div>

            <div class="form-group col-md-2">
                <label for="">Bairro </label>
                <input type="text" class="form-control" v-model="client.bairro" readonly required>
            </div>

            <div class="form-group col-md-2">
                <label for="">Numero </label>
                <input type="text" class="form-control" v-model="client.numero" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Complemento</label>
                <input type="text" class="form-control" v-model="client.complemento">
            </div>

            <div class="form-group col-md-4"> 
                <label for="">Cidade</label>         
                <input type="text" class="form-control" v-model="client.cidade" readonly required>
            </div>

            <div class="form-group col-md-4">
                <label for="">Estado</label>
                <input type="text" class="form-control" v-model="client.estado" readonly required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Telefone</label>
                <input type="text" @input="phoneValidator()" class="form-control" v-model="client.telefone" required>
            </div>

            <div class="form-group col-md-4">
                <label for="">Celular</label>
                <input type="text" class="form-control" @input="celValidator()" v-model="client.celular" required>
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

            <button class="btn btn-success" style="float:right;" type="submit">Salvar</button>
            </div>
        </div>
      </form>
  </div>
</template>

<script>
import {mapActions,mapState} from 'vuex'
import {mask} from 'vue-the-mask'
export default {
     directives: {mask},
    name:'clientstore',

    data(){
        return{
            client:{

            name:'',
            cpf:'',
            data_nasc:'',
            email:'',
            cep:'',
            rua:'',
            numero:'',
            complemento:'',
            cidade:'',
            estado:'',
            bairro:'',
            telefone:'',
            celular:'',
            status:'',

            }
        }
    },

    methods:{
        ...mapActions('Client',['postClient']),

        apicep(){
            fetch(`https://viacep.com.br/ws/${this.client.cep}/json/`)
            .then(response => response.json())
            .then(response => {
                    this.client.bairro = response.bairro
                    this.client.cidade = response.localidade
                    this.client.rua = response.logradouro
                    this.client.estado = response.uf
                    if(response.erro == true) {
                        alert('CEP inválido')
                    }
                    console.log(response)})
                    .catch((err) => {
                        console.log(err)
                        alert('CEP inválido')
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
        onSubmit(){
            this.$store.dispatch('Client/postClient',{

                name:this.client.name,
                cpf:this.client.cpf,
                email:this.client.email,
                date_nasc:this.client.data_nasc,
                cep:this.client.cep,
                street:this.client.rua,
                number:this.client.numero,
                complement:this.client.complemento,
                city:this.client.cidade,
                state:this.client.estado,
                heigthboard:this.client.bairro,
                fone:this.client.telefone,
                celular:this.client.celular,
                status:this.client.status
            })
                
                try {
                    console.log()   
                    this.$toasted.global.defaultSuccess()
                        setTimeout(() => {
                            this.$router.push('/clients')
                    },3000)    
                }catch(e) {
                    this.$toasted.global.defaultError()
                console.log('errrou',e)
                }
        },
    },
    computed:{
        ...mapState('Client',{clients:state => state.clients}),
  
    }
}
</script>

<style>
    span{
        cursor: pointer;
    }
</style>