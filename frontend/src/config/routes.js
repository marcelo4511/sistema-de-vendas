
import Vue from 'vue'
import VueRouter from 'vue-router'
// Page

import Login from '../features/Authenticate/Login/Login'
import Register from '../features/Authenticate/Login/Register'

import Product from '../features/Product/index'
import ProductCreate from '../features/Product/create'
import ProductEdit from '../features/Product/edit'
import Home from '../template/Home'
import Category from '../features/Category/index'
import CategoryEdit from '../features/Category/edit'
import CategoryCreate from '../features/Category/create'
import Client from '../features/Client/index'
import ClientCadastro from '../features/Client/create'
import ClientAtualiza from '../features/Client/edit'
import Sales from '../features/Sale/index'
import SalesCreate from '../features/Sale/create'
import SalesEdit from '../features/Sale/edit'
import SalesShow from '../features/Sale/show'
import Vendas from '../features/Sale/vendas'
import Aprovadas from '../features/Sale/aprovadas'
import Users from '../features/User/index'
import Perfil from '../template/Perfil'
// 
Vue.use(VueRouter)
const routes = [
  {
    name: 'product',
    path: '/products',
    component:Product,
    meta: {
        auth: true, role:2
    },
},{
    name:'productCreate',
    path:'/products/create',                                                                                                                                                                                                                       
    component:ProductCreate,
    meta: {
        auth: true
    },
},{
    name:'productEdit',
    path:'/products/:product/edit',                                                                                                                                                                                                                       
    component:ProductEdit,
    params:true,
    meta: {
        auth: true
    },
},{
    name:'client',
    path:'/clients',                                                                                                                                                                                                                       
    component:Client,
    meta: {
        auth: true
    },
},{
    name:'clientstore',
    path:'/clientstore',                                                                                                                                                                                                                       
    component:ClientCadastro,
    meta: {
        auth: true
    },
},{
    name:'clientedit',
    path:'/clientedit/:client/edit',                                                                                                                                                                                                                       
    component:ClientAtualiza,
    params:true,
    meta: {
        auth: true
    },
},{
    name:'home',
    path:'/home',                                                                                                                                                                                                                       
    component:Home,
    meta: {
        auth: true
    },
},{
    name:'categories',
    path:'/categories',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
    component:Category,
    meta: {
        auth: true
    },
},{
    name:'categoryedit',
    path:'/categoryedit/:id/edit',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
    component:CategoryEdit,
    params:true,
    meta: {
        auth: true
    },                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
},{
    name:'categorycreate',
    path:'/categories/create',
    component:CategoryCreate,
    meta: {
        auth: true
    },
},{
    name:'sales',
    path:'/sales',
    component:Sales,
    meta: {
        auth: true
    },
},{
    name:'vendas',
    path:'/vendas',
    component:Vendas,
    meta: {
        auth: true
    },
},{
    name:'aprovadas',
    path:'/aprovadas',
    component:Aprovadas,
    meta: {
        auth: true
    },
},{
    name:'salescreate',
    path:'/sales/create',
    component:SalesCreate,
    meta: {
        auth: true
    },
},{
    name:'salesedit',
    path:'/salesedit/:id/edit',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
    component:SalesEdit,
    params:true,
    meta: {
        auth: true
    },                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
},{
    name:'salesshow',
    path:'/salesshow/:sale/show',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
    component:SalesShow,
    params:true,
    meta: {
        auth: true
    },                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
},{
    name:'users',
    path:'/users',
    component:Users,
    meta: {
        auth: true
    },                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
},{
    name:'perfil',
   path:'/perfil',                                                                                                                                                                                                             
    component:Perfil,
    params:true,
    meta: {
        auth: true
    },
},
//rotas nao autenticadas 

{
    path: '/',
    name: 'index',
    redirect: to => {
        const loggedIn = localStorage.getItem('user')
        if(to.matched.some(record => record.meta.auth) && loggedIn) {
            return '/perfil'
        } 

         if(!loggedIn) {
            return '/login'
        } 
    },
    meta: {
        auth: true
    }
},{
    name:'login',
    path:'/login',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
    component:Login,
    meta: {
        auth: false
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
},{
    name:'register',
    path:'/register',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
    component:Register ,
    meta: {
        auth: false
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
}]
const router = new VueRouter({
    mode: 'history',
    routes
  })

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem('user')
  
    if (to.matched.some(record => record.meta.auth) && !loggedIn) {
      next('/login')
      return
    }
    next()
  })

  export default router
