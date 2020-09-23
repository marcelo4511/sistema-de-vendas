import React from 'react'
import './Nav.css'


export default props =>
    <aside className="menu-area">
        <nav className="menu">
            {/**refatorar em casa */}
            <a href="/">
                <i className="fa fa-home"></i> Inicio
            </a>
            <a href="#/categories">
                <i className="fa fa-folder"></i> Categorias
            </a>
            
            <a href="#/clients">
                <i className="fa fa-user"></i> Clientes
            </a>

            <a href="#/products">
                <i className="fa fa-pencil"></i> Produtos
            </a>

            <a href="#/sales">
                <i className="fa fa-shopping-cart"></i> Vendas
            </a>
        </nav>
    </aside>