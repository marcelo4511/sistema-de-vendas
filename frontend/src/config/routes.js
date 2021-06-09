
import Vue from 'vue'
import VueRouter from 'vue-router'
// Page

import Login from '../features/Authenticate/Login/Login'
import Register from '../features/Authenticate/Login/Register'

import Product from '../features/Product/index'
import ProductCreate from '../features/Product/create'
import ProductEdit from '../features/Product/edit'
import Home from '../template/Home'
import BI from '../features/BI/dashboard'
import Category from '../features/Category/index'
import CategoryEdit from '../features/Category/edit'
import CategoryCreate from '../features/Category/create'
import Client from '../features/Client/index'
import ClientCadastro from '../features/Client/create'
import ClientAtualiza from '../features/Client/edit'
import Provider from '../features/Provider/index'
import ProviderCadastro from '../features/Provider/create'
import ProviderAtualiza from '../features/Provider/edit'
import BillsToPay from '../features/BillsToPay/index'
import BillsToPayCreate from '../features/BillsToPay/create'
import Delay from '../features/BillsToPay/delay'
import Today from '../features/BillsToPay/today'
import BillsToReceive from '../features/BillsToReceive/index'
import BillsToReceiveCreate from '../features/BillsToReceive/create'
import Movimentacao from '../features/Movimentacao/index'
import Compras from '../features/Compra/index'
import ComprasCreate from '../features/Compra/store'
import CompraEdit from '../features/Compra/edit'

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
    name:'provider',
    path:'/providers',                                                                                                                                                                                                                       
    component:Provider,
    meta: {
        auth: true
    },
},{
    name:'providerstore',
    path:'/providerstore',                                                                                                                                                                                                                       
    component:ProviderCadastro,
    meta: {
        auth: true
    },
},{
    name:'provideredit',
    path:'/provideredit/:provider/edit',                                                                                                                                                                                                                       
    component:ProviderAtualiza,
    params:true,
    meta: {
        auth: true
    },
},{
    name:'billstopay',
    path:'/billstopay',                                                                                                                                                                                                                       
    component:BillsToPay,
    meta: {
        auth: true
    },
},{
    name:'billstopaystore',
    path:'/billstopaystore',                                                                                                                                                                                                                       
    component:BillsToPayCreate,
    meta: {
        auth: true
    },
},{
    name:'delay',
    path:'/delay',                                                                                                                                                                                                                       
    component:Delay,
    meta: {
        auth: true
    },
},{
    name:'today',
    path:'/today',                                                                                                                                                                                                                       
    component:Today,
    meta: {
        auth: true
    },
},{
    name:'billstoReceive',
    path:'/billstoReceive',                                                                                                                                                                                                                       
    component:BillsToReceive,
    meta: {
        auth: true
    },
},{
    name:'billstoReceivestore',
    path:'/billstoReceivestore',                                                                                                                                                                                                                       
    component:BillsToReceiveCreate,
    meta: {
        auth: true
    },
},{
    name:'movimentacao',
    path:'/movimentacao',                                                                                                                                                                                                                       
    component:Movimentacao,
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
    name:'dashboard',
    path:'/dashboard',                                                                                                                                                                                                                       
    component:BI,
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
    name:'compras',
    path:'/compras',
    component:Compras,
    meta: {
        auth: true
    },
},{
    name:'comprascreate',
    path:'/compras/store',
    component:ComprasCreate,
    meta: {
        auth: true
    },
},{
    name:'comprasedit',
    path:'/comprasedit/:id/edit',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
    component:CompraEdit,
    params:true,
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
