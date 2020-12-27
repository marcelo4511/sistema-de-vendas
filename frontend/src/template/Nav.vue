<template>
  <aside >
     <ul class="title">
       <div v-for="(u,k) in user" :key="k">

         <div v-if="u.type_user_id == 1">

       <router-link tag="span" to="/home">
        <li><i class="fa fa-home"></i> Home</li>
       </router-link>

       <router-link tag="span" to="/clients">
          <li><i class="fa fa-user-friends" aria-hidden="true"></i> Clientes</li>
        </router-link>

        <router-link tag="span" to="/products">
          <li><i class="fa fa-shopping-bag" aria-hidden="true"></i> Produtos</li>
        </router-link>

       <router-link tag="span" to="/categories">
       <li><i class="fas fa-box"></i> Categorias</li>
       </router-link>

       <router-link tag="span" to="/sales">
         <li><i class="fa fa-shopping-cart"></i>Vendas</li>
       </router-link>
  
        <router-link tag="span" to="/users">
          <li><i class="fa fa-user-friends" aria-hidden="true"></i> Usuários</li>
        </router-link>
         </div>

          <div v-if="u.type_user_id == 2">
            <router-link tag="span" to="/aprovadas">
              <li><i class="fa fa-shopping-cart"></i>Vendas</li>
            </router-link>
            </div>

            <div v-if="u.type_user_id == 3">
            <router-link tag="span" to="/products">
          <li><i class="fa fa-shopping-bag" aria-hidden="true"></i> Produtos</li>
        </router-link>

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
    aside ul li {
      display: flex;
      font-family: Arial, Helvetica, sans-serif;
      justify-content: flex-start;
      align-items: center;
      text-align: end;
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