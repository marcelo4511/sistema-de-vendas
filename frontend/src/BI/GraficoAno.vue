<template>
<div class="card col-4 mr-1 shadow p-1 bg-white rounded mb-2">
  <div class="card-body ">
    <span v-if="!loading">TOTAL DE VENDAS ANUAIS : <b>R$ {{formatarMoeda(total)}}</b> </span>  
    <span v-else class="text-center"><i class="spinner-border spinner-border spinner text-primary"></i></span>
  </div>
</div>
</template>

<script>
import {API_BASE_URL} from '../config/Api'
import axios from 'axios'
import moment from 'moment'
export default {

  data: function() {
    return {
      loading:false,
      height:220,
      total: 0,
       payload: {
        ano: moment().year(),
      },
    }
  },
  created(){
      this.get()
      this.$root.$on('selecionar' ,(payload) => {
      this.payload.ano = payload.ano
      this.get()
    }) 
  },
  methods:{
      get() {
        this.loading = true
        this.height = 220;
          axios.post(`${API_BASE_URL}/bi/grafico/anual`,{payload:this.payload}).then(res => {
              this.total  =res.data
              this.loading = false
          }).then(() => {
            this.height = 219;
          })
      },
       formatarMoeda(moeda){
            moeda = parseFloat(moeda);
            moeda = moeda.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+,)/g, "$1.");
            return moeda;
        },
  }
}
</script>

<style>

</style>