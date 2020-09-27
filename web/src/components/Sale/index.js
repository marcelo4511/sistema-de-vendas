import Axios from 'axios'
import React, { useEffect, useState } from 'react'
import {Link} from 'react-router-dom'


function Sale(){

    const [sales,setSales] = useState([])
    useEffect(() => {
        const getSales = async () => {
            const result = await Axios.get('http://localhost:8000/api/sales')
            setSales(result.data)
            console.log(result.data)
        }
        getSales()
    },[])

    
    return (
        <div>
            <h1>Cadastro de Vendas</h1>

            <Link to="/salescreate">
                <button className="btn btn-info m-2" renderAs="button">
                    <span>Cadastrar</span>
                </button>
            </Link>

            <table className="table">
                <thead>
                    <tr>
                        <th>Clientes</th>
                        <th>Data da venda</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    {
                    sales.map((sale,i) => {

                    return <tr key={i}>
                        <td>{sale.name}</td>
                        <td>{sale.dataVenda}</td>
                        <td>{sale.total}</td>
                        <td>
                            <button className="btn btn-warning m-1"><i className="fa fa-pencil"></i></button>
                            <button className="btn btn-danger"><i className="fa fa-trash"></i></button>
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