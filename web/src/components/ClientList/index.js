
import React, { useEffect, useState } from 'react'
import {Link} from 'react-router-dom'
import axios from 'axios'

function ClientList(){

    const [clients,setClients] = useState([])
   
    useEffect(() => {
        const getClients = async() => {
            const resultadoDaApi = await axios.get('http://localhost:8000/api/clients')
            setClients(resultadoDaApi.data)
            console.log(resultadoDaApi.data)
        }
        getClients()
    },[])
    return (
        <div>
            <h1>Cadastro de Clientes</h1>

            <Link to="/clientcreate">
                <button className="btn btn-info m-2">
                    <span>Cadastrar</span>
                </button>
            </Link>

            <table className="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Celular</th>
                        <th>Data de nascimento</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                {
                    clients.map((client,i) => {

                    return <tr key={i}>
                        <td>{client.name}</td>
                        <td>{client.email}</td>
                        <td>{client.celular}</td>
                        <td>{client.date_nasc}</td>
                        <td>{client.status}</td>
                        <td>
                            <button className="btn btn-warning m-1"><i className="fa fa-pencil"></i></button>
                            <button className="btn btn-danger" ><i className="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    })
                    }
                </tbody>
            </table>
        </div>
    )
}

export default ClientList