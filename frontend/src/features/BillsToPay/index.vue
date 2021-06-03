<template>
<div>
    <h4 cabecalho="Produto">Contas a Pagar</h4>
        <nav aria-label="breadcrumb mb-4">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Contas a Pagar</li>
            </ol>
        </nav>
    <router-link to="/billstopaystore" tag="span"><button class="btn btn-sm btn-primary">Cadastrar</button></router-link>
    <input class="form-control form-control-sm col-md-3 mb-3" type="search" style="float: right;" name="nome" placeholder="Buscar">
  
   <div class="table table-responsive">
        <table class="table table-sm">
            <thead class="text-center">
                <tr>
                    <th scope="col">Descrição</th>
                    <th scope="col">Valor a pagar</th>
                    <th scope="col">Data do vencimento</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Comprovante</th>
                    <th scope="col">Situação</th>
                    <th scope="col">Açôes</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr v-for="(provider,k) in providers" :key="k" >
                    <td>{{provider.descricao}}</td>
                    <td>{{provider.valor | money}}</td>
                    <td>{{provider.dt_vencimento | momentDate}}</td>
                    <td>{{provider.user.name}}</td>
                    <td v-if="provider.comprovante"><button class="btn btn-sm btn-primary"><i class="fa fa-camera"></i></button></td>
                    <td v-else></td>
                   <td>{{provider.situacao.descricao}}</td>

                    <td class="align-middle" width="20%">   
                    <div v-show="provider.situacao_id == 1">
                        <button class="btn btn-sm btn-warning m-1"  data-toggle="modal" :data-target="`#pagar${provider.id}`" ><i class="fa fa-pen"></i></button>
                        <button  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>  
                        <button  class="btn btn-sm btn-success m-1" @click="aprovar(provider)"><i class="fa fa-check "></i></button>

                        <modal :title="`Atualizar Registro`" :name="`pagar${provider.id}` ">
                            <div class="modal-body text-left" >
                                <div class="form-group mb-3">
                                    <label>Descrição</label>
                                    <input name="descricao" :data-vv-scope="`pagar-${provider.id}`" v-model="provider.descricao" :disabled="loading" data-vv-as="Data de Pagamento" v-validate="'required'" :class="['form-control form-control-sm', {'is-invalid': errors.has(`dataNota`)}]"  type="text">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Valor</label>
                                    <input name="descricao" :data-vv-scope="`pagar-${provider.id}`" v-model="provider.valor" :disabled="loading" data-vv-as="Data de Pagamento" v-validate="'required'" :class="['form-control form-control-sm', {'is-invalid': errors.has(`dataNota`)}]"  type="text">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Data Pagamento</label>
                                    <input name="dataNota" :data-vv-scope="`pagar-${provider.id}`" v-model="provider.dt_vencimento" :disabled="loading" data-vv-as="Data de Pagamento" v-validate="'required'" :class="['form-control form-control-sm', {'is-invalid': errors.has(`dataNota`)}]"  type="date">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Comprovante</label>
                                    <input type="file" class="form-control form-control-sm" v-on:change="uploadImagem">
                                </div>
                            <button class="btn btn-sm btn-success" @click="getAtualizaProvider(provider.id)">Atualizar</button>
                            </div>
                        </modal>
                    </div>
                    <div v-show="provider.situacao_id == 2">
                        <span class="text-success"><b>Baixado</b> </span>
                    </div>
                </td>
                </tr>
            </tbody>
        </table>
   </div>
</div>
</template>

<script>
import moment from 'moment'
import {API_BASE_URL} from '../../config/Api'
import 'vuejs-noty-fa/dist/vuejs-noty-fa.css'
import axios from 'axios'
import {mapActions} from 'vuex' 
import swal from 'sweetalert'
export default {
    components:{
        Modal: () => import('../Modal/modal.vue')
    },
    data(){
        return {
            loading:false,
            provider:{
                descricao:'',
                valor:'',
                dt_vencimento:'',
            },
        providers:[],
        }
    },
    created(){
        this.$store.dispatch('Provider/getProvider')
        this.getProvider()
        this.get(this.$route.params.id)
    },
    
    methods:{
        ...mapActions('Provider',['getProvider']),
        getProvider(){
            axios.get(`${API_BASE_URL}/billstopay`).then(res => {
                this.providers = res.data
            })
        },
        getAtualizaProvider(id){
            axios.put(`${API_BASE_URL}/billstopay/${id}`).then(res => {
                this.providers.push(res.data)
            })
                return this.$forceUpdate();  
        },
        get(id) {
            axios.get(`${API_BASE_URL}/billstopay/${id}`)
            .then((response) => {
              this.provider = response.data
            })
            .catch(() => {
          })
        },
        removeClient(provider){
            swal({
            title: "Você está certo disso ?",
            text: "Depois de excluído, você não será capaz de recuperar este arquivo!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                axios.delete(`${API_BASE_URL}/fornecedores/${provider.id}`)
            .then(res => {
                this.providers.splice(res.data.id,1)
                swal("Fornecedor deletado com sucesso!", {
                icon: "success",
                });
            })
                } else {
                    swal("seu dado está a salvo");
                }
            });
               
        },
        postMovimentacao(provider){
            provider.tipo_movimentacao_id = 2
            axios.post(`${API_BASE_URL}/movimentacao/`,provider).then(() => {
            })
        },
        uploadImagem(e) {
          let arquivo = e.target.files ?? e.dataTransfer.files
          if(!arquivo.length){
            return
          }

          let reader = new FileReader()
          reader.onload = (e) => {
            this.provider.comprovante = e.target.result
          }
          console.log(reader)
         return reader.readAsDataURL(arquivo[0])
        },
        aprovar(provider){
            swal({
            title: "Tela de venda para aprovação",
            text: "Depois de aprovado, você não será capaz de modificar essa venda!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                axios.post(`${API_BASE_URL}/billstopay/aprovar/${provider.id}`).then(() => {
                    swal("Venda aprovada!", {
                        icon: "success",
                });
                return location.reload()
            })
            } else {
                swal("Venda continua a esperar o pagamento");
            }
            });
            return   this.postMovimentacao(provider)
        },
    },
    computed:{
        pesquisar(){
           return this.providers.filter(providers => {
                return providers.descricao.includes(this.buscar)
            })
        }
    },
    filters:{
        money(value){
            if(value){
                return value = parseFloat(value).toLocaleString('pt-BR',{style:'currency',currency:'BRL'}) 
            }
        },
        momentDate(date){
            if(date){
                return date ? moment(date).format('DD/MM/YYYY') : null
            }
        },
  },
}
</script>

<style>

</style>