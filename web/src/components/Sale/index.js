import Axios from 'axios'
import React, { useEffect, useState } from 'react'
import {Link} from 'react-router-dom'
import axios from 'axios'
import Noty from 'noty'

function Sale(){

    const [products,setProducts] = useState([])
    useEffect(() => {
        const getProducts = async () => {
            const result = await Axios.get('http://localhost:8000/api/products')
            setProducts(result.data)
            console.log(result.data)
        }
        getProducts()
    },[])

    function removeProduct(id) {
        axios.delete(`http://localhost:8000/api/products/${id}`)
        .then((result) => {
            new Noty({
                type: 'success',
                layout: 'topRight',
                text: "Deletado com sucesso!",
                timeout: 3000
            }).show();
            //history.push('/categories')
        })
    }
    return (
        <div>
            <h1>Cadastro de produtos</h1>

            <Link to="/salescreate">
                <button className="btn btn-info m-2" renderAs="button">
                    <span>Cadastrar</span>
                </button>
            </Link>

            <table className="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    {
                    products.map((product,i) => {

                    return <tr key={i}>
                        <td>{product.name}</td>
                        <td>{product.description}</td>
                        <td>{product.price}</td>
                        <td>{product.amount}</td>
                        <td>{product.subtotal}</td>
                        <td>{product.categories.name}</td>
                        <td>{product.status}</td>
                        <td>
                            <button className="btn btn-warning m-1"><i className="fa fa-pencil"></i></button>
                            <button className="btn btn-danger" onClick={e => {removeProduct(product.id)}}><i className="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    })
                    }
                </tbody>
            </table>
        </div>
    )
}

export default Sale