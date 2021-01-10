<template>
  <div id="app">
       
    
     <Nav v-show="isLogged"/>
     <Header v-show="isLogged"/>
     <Main/>
     <Footer v-show="isLogged"/>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import Nav from './template/Nav'
  import Main from './template/Main'
  import Header from './template/Header'
  import Footer from './template/Footer'

export default {
  components: { Main,Nav,Header,Footer},
  
   computed: {
    ...mapGetters('User',[
      'isLogged'
    ])
  },
  
  methods: {
    logout () {
       this.$store.dispatch('User/logout')
    }
  }
}
</script>

<style>

* {
		font-family: "Lato", sans-serif;
    margin:0;
    padding: 0;
	}


  #app {
    display:grid;
    grid-template-rows: 60px 1fr 30px;
		grid-template-columns: 300px 1fr;
    height: 100vh;
    width: 100vw;
    grid-template-areas: 
    "header header"
    "lado main"
    "lado footer"
    ;
    
  }
 #app.hide-menu {
		grid-template-areas:
			"header header"
			"main main"
      "main footer"
			;
	}
aside .lado{
  grid-area: lado;
}
header header{
  grid-area: header;
}
main .main {
  grid-area: main;
}
footer .footer {
  grid-area: footer;
}

@media(max-width: 768px){
  #app {
    grid-template-rows:
    50px
    300px
    1fr;

    grid-template-columns:  1fr;
    grid-template-areas: 
     "header"
     "lado "
     "main "
     "footer"
    ;
  }
}

@media(max-width:640px){
  #app {
    grid-auto-rows: 100;
    grid-template-rows:
   
    50px,
    10px,
    1fr;

    grid-template-columns:  1fr;

    grid-template-areas: 
    "header"
    "main"
    "footer"
  }
}

</style> 