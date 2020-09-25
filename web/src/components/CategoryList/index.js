import React, { useEffect, useState } from 'react'
import axios from 'axios'
import {Link, useHistory} from 'react-router-dom'
import Noty from 'noty'
import '../../../node_modules/noty/lib/noty.css'
import '../../../node_modules/noty/lib/themes/mint.css'
import './index.css'

const CategoryList = () => {

    const history = useHistory()
    const [category,setCategory] = useState([])
    const [search,setSearch] = useState('')
    const [filtersCategories,setFiltersCategories] = useState([])
    const [loading,setLoading] = useState(false)

    useEffect(() => {
        setLoading(true)
       const getData = async () => {
           const result = await axios.get('http://localhost:8000/api/categories')
           setCategory(result.data)
           setLoading(false)
       }
       getData()
    },[])

    useEffect(() => {
        setFiltersCategories(
          category.filter((country) =>
            country.name.toLowerCase().includes(search.toLowerCase())
          )
        );
      }, [search, category]);
    

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

    if(loading) {
        return <p><i class="fa fa-clock-o" aria-hidden="true"></i>Carregando Categorias</p>
    }
    return (
        <div>
            <h1 className="m-2">Cadastro de categorias</h1>
            <div className="search">

            <Link to="/create">
                <button className="btn btn-info m-3">
                    <span>Cadastrar</span>
                </button>
            </Link>
            <input type="text" className="form-control col-3 m-3 input" value={search} onChange={e => setSearch(e.target.value)} placeholder="pesquisar..."/>
            </div>


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
                        filtersCategories.map((cat,i) => {
                                
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
