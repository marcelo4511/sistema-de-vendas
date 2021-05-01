<template>
  <header>
    <div>
      <div class="dropdown" >
        <button class="drops btn btn-write dropdown-toggle" type="button" id="dropdownMenuButton" style="color:white;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span style="color:white;" v-for="(u,k) in user" :key="k">{{u.name}}</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
          <div v-for="(u,k) in user" :key="k">
            <div v-show="u.type_user_id === 1">
              <router-link to="/home" class="d-flex justify-content-beetween dropdown-item m-0">Home</router-link> 
            </div>
          </div>
          <router-link to="/" class="d-flex justify-content-beetween dropdown-item" v-if="!isLogged">Login</router-link>
          <span class="d-flex justify-content-beetween dropdown-item" @click="sair()">Sair
          </span>
        </div>
      </div>
    </div>
  </header>
</template>

<script>

import {mapGetters,mapState} from 'vuex'
export default {
 
  computed:{
     ...mapState('User',{user:state => state.user}),
    ...mapGetters('User',[
      'isLogged'
    ])
 },
  methods: {
    sair () {
      this.$noty.success('Até logo!')
      this.$store.dispatch('User/logout')
    }
  }
}
</script>

<style>

    header{
      width:100vw;
        grid-area: header;
      background: linear-gradient(to right, #1e469a, #49a7c1);
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }
      .drops{
          background-color: linear-gradient(to right, #1e469a, #49a7c1);
          font-style: inherit;
      }
    p{
      height: 70px;
    }
    header div{
      display: flex;
      align-items: center;
      text-align: center;
      justify-content: flex-end;
      margin-right: 30px;
      margin-top: 5px;
    }
</style>






