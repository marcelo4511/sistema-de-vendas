<template>
  <aside >
     <ul class="title">
      <div v-for="(u,k) in user" :key="k">
        
      <div v-if="u.type_user_id == 1">
       <router-link tag="span" to="/home">
        <li><i class="fa fa-home m-3"></i> Home</li>
       </router-link>
       <div class="dropdown">
        <span style="color:white;" class="drops btn btn-write dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span style="color:white;"><i class="fa fa-cog m-2"></i> Configurações</span>
        </span>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <div id="teste">
            <router-link tag="span" to="/providers">
              <li style="color:black;"><i class="fa fa-truck m-3" aria-hidden="true"></i> Fornecedor</li>
            </router-link>
            <router-link tag="span" to="/clients">
              <li style="color:black;"><i class="fa fa-user-friends m-3" aria-hidden="true"></i> Clientes</li>
            </router-link>
            <router-link tag="span" to="/products">
              <li style="color:black;"><i class="fa fa-shopping-bag m-3" aria-hidden="true"></i> Produtos</li>
            </router-link>
            <router-link tag="span" to="/categories">
              <li style="color:black;"><i class="fas fa-box m-3"></i> Categorias</li>
            </router-link> 
            <router-link tag="span" to="/users">
              <li style="color:black;"><i class="fa fa-user-friends m-3" aria-hidden="true"></i> Usuários</li>
          </router-link>
          </div>
        </div>
      </div>

       <div class="dropdown">
        <span style="color:white;" class="drops btn btn-write dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span style="color:white;"><i class="fa fa-dollar-sign m-2" aria-hidden="true"></i> Financeiro</span>
        </span>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <div id="teste">
            <router-link tag="span" to="/billstopay">
              <li style="color:black;"><i class="fa fa-money-check-alt m-3" aria-hidden="true"></i> Contas a pagar</li>
            </router-link>
            <router-link tag="span" to="/billstoreceive">
              <li style="color:black;"><i class="fa fa-credit-card m-3" aria-hidden="true"></i> Contas a receber</li>
            </router-link>
            <router-link tag="span" to="/movimentacao">
              <li style="color:black;"><i class="fa fa-chart-line m-3"></i> Fluxo de caixa</li>
            </router-link> 
          </div>
        </div>
      </div>
       <router-link tag="span" to="/sales">
         <li><i class="fa fa-shopping-cart m-3"></i>Vendas</li>
       </router-link>
    </div>

    <div v-if="u.type_user_id == 2">
      <router-link tag="span" to="/aprovadas">
        <li><i class="fa fa-shopping-cart"></i>Vendas</li>
      </router-link>
    </div>

    <div v-if="u.type_user_id == 3">
      <div class="dropdown title">
        <span style="color:white;" class="drops btn btn-write dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span style="color:white;"><i class="fa fa-cog m-2"></i> Configurações</span>
        </span>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <div id="teste">
            <router-link tag="span" to="/products">
              <li style="color:black;"><i class="fa fa-shopping-bag m-3" aria-hidden="true"></i> Produtos</li>
            </router-link>
          </div>
        </div>
      </div>
      <router-link tag="span" to="/vendas">
      <li><i class="fa fa-shopping-cart"></i>Vendas</li>
      </router-link>
    </div>
  </div>
</ul>
</aside>
</template>

<script>
  import {mapGetters, mapState} from 'vuex'
export default {
  props:{
    hideToggle:Boolean
  },
  computed:{ 
    ...mapGetters('User',[
      'isLogged'
    ]),
   ...mapState('User',{user:state => state.user}),
 },
  methods: {
    logout () {
       this.$store.dispatch('User/logout')
    },
  },
}
</script>
<style>
  aside{
    grid-area: lado;
      background-color:black;
  }
  aside ul{
    margin-top: 100px;
    
  }
  aside .dropdown span{
    display: flex;
    font-family: Arial, Helvetica, sans-serif;
    justify-content: flex-start;
    align-items: center;
    justify-content: flex-start;
    text-align: center;
    font-size: 25px;
    height: 80px;
    font:100;
    padding: 10px;
    color:blanchedalmond;
    text-decoration: none;
    cursor: pointer;
  }
  aside .dropdown:hover{
    background-color: blue;
    color: blanchedalmond;
    transition: 3ms;
    text-decoration: none;
  }
  aside ul li {
    display: flex;
    font-family: Arial, Helvetica, sans-serif;
    justify-content: flex-start;
    align-items: center;
    justify-content: flex-start;
    text-align: center;
    font-size: 25px;
    height: 80px;
    padding: 10px;
    color:blanchedalmond;
    text-decoration: none;
    cursor: pointer;
  }
  aside ul li:hover{
    background-color: blue;
    color: blanchedalmond;
    transition: 3ms;
    text-decoration: none;
  }
    aside ul li a{
    text-decoration: none;
  }
  aside #teste li:hover{
    background: #fff;
  }

  @media(max-width:768px) {
    aside {
      display: flex;
      justify-content: flex-start;
      align-items: center;
    }
    aside a {
      display: inline;
      padding: 10px;
      margin:0px;
      color: black;
    }
    aside{
      justify-content: space-around;
    }
  }
</style>