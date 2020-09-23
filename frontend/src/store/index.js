import Vue from 'vue'
import Vuex from 'vuex'

import Category from '../features/Category/store'
import Client from '../features/Client/store'
import Product from '../features/Product/store'
import Sale from '../features/Sale/store'
import Loja from '../config/loja'

Vue.use(Vuex)

const modules = {
    Category,
    Client,
    Product,
    Sale,
    Loja
}

export default new Vuex.Store({
    modules
})