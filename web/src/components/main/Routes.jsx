import React from 'react'
import {Switch,Route,Redirect} from 'react-router-dom'

import Home from '../home/Home'
import CategoryList from '../CategoryList/index'
import ProductList from '../ProductList/index'
import ProductCreate from '../ProductCreate/create'
import ClientList from '../ClientList/index'
import ClientCreate from '../ClientCreate/create'
import Sale from '../Sale/index'
import SaleCreate from '../SaleCreate/create'
import CategoryCreate from '../CategoryCreate/create'
import CategoryEdit from '../CategoryEdit'


function Routes(){
    return (

        <Switch>
        <Route exact path='/'component={Home}></Route> {/**exact ->exatamente uma barra */}
        <Route path='/categories' component={CategoryList}></Route>
        <Route path='/products' component={ProductList}></Route>
        <Route path="/productcreate" component={ProductCreate}/>
        <Route path='/clients' component={ClientList}></Route>
        <Route path='/clientcreate' component={ClientCreate}/>
        <Route path='/sales' component={Sale}></Route>
        <Route path="/salescreate" component={SaleCreate}/>
        <Route path='/create' component={CategoryCreate}></Route>
        <Route path='/edit/:id' component={CategoryEdit} />    
        <Redirect from='*' to='/'/>
        </Switch>
        )
}
export default Routes
