import React from 'react'
import { createDrawerNavigator } from '@react-navigation/drawer';
import { NavigationContainer } from '@react-navigation/native';

const Drawer = createDrawerNavigator();

import Home from './src/components/Home/index'
import Categories from './src/components/Categories/index'

export default function Routes(){
    return (
        <NavigationContainer>
        <Drawer.Navigator initialRouteName="Home">
          <Drawer.Screen name="Home" component={Home} />
          <Drawer.Screen name="Categorias" component={Categories} />
          <Drawer.Screen name="Produtos" component={Categories} />
          <Drawer.Screen name="Clientes" component={Categories} />
          <Drawer.Screen name="Vendas" component={Categories} />
        </Drawer.Navigator>
      </NavigationContainer>
    )
}