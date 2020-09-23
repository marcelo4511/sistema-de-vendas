<template>
  <div id="app" :class="{'hide-menu': isMenuVisible}">
       
     <Nav/>
     <Header />
     <Main/>
     <Footer/>
  </div>
</template>

<script>
 import Nav from './template/Nav'
 import Main from './template/Main'
 import Header from './template/Header'
 import Footer from './template/Footer'
 import {mapState} from 'vuex'
export default {
  components: { Main,Nav,Header,Footer},
  computed: mapState(['isMenuVisible']),
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
    ;
  }
}

@media(max-width:576px){
  #app {
    grid-auto-rows: 100;
    grid-template-rows:
   
    320px
    1fr;

    grid-template-columns:  1fr;

    grid-template-areas: 
    "header"
    "lado "
     "main"
  }
}

</style> 