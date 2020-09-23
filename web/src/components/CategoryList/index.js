import React, { useEffect, useState } from 'react'
import axios from 'axios'
import {Link, useHistory} from 'react-router-dom'
import Noty from 'noty'
import '../../../node_modules/noty/lib/noty.css'
import '../../../node_modules/noty/lib/themes/mint.css'

const CategoryList = () => {

    const history = useHistory()

    const [category,setCategory] = useState([])

    useEffect(() => {
       const getData = async () => {
           const result = await axios.get('http://localhost:8000/api/categories')
           setCategory(result.data)
       }
       getData()
    },[])

    function editCategory(id){
        history.push({pathname:'/edit/' + id})
    }

    const  deleteCategory = (id) => {
        
        axios.delete(`http://localhost:8000/api/categories/${id}`)
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
            <h1 className="m-2">Cadastro de categorias</h1>

            <Link to="/create">
                <button className="btn btn-info m-2" renderAs="button">
                    <span>Cadastrar</span>
                </button>
            </Link>

            <table className="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    {
                        category.map((cat,i) => {
                                
                        return    <tr key={i}>
                        <td>{cat.name}</td>
                        <td>{cat.status}</td>
                        <td>
                            <button className="btn btn-warning m-1" onClick={e => {editCategory(cat.id)}}><i className="fa fa-pencil"></i></button>
                            <button className="btn btn-danger" onClick={e => {deleteCategory(cat.id)}}><i className="fa fa-trash"></i></button>
                        </td>
                    </tr>
                        })}
                </tbody>
            </table>
        </div>
    )
}



export default CategoryList