import React, { useEffect, useState } from 'react'
import {useHistory, useParams} from 'react-router-dom'
import Noty from 'noty'
import '../../../node_modules/noty/lib/noty.css'
import '../../../node_modules/noty/lib/themes/mint.css'
import axios from 'axios'

const CategoryEdit = () => {

    const history = useHistory()
    const { id } = useParams()
    const [name,setName] = useState('')
    const [status,setStatus] = useState('')
  

    const handleSubmit = async event => {
        event.preventDefault()
        
            await axios.put(`http://localhost:8000/api/categories/${id}`,{
                name,
                status
            }).then(res => {
                console.log(res.data)
                new Noty({
                    type: 'success',
                    layout: 'topRight',
                    text: "Categoria atualizada com sucesso!!",
                    timeout: 3000
                }).show();

            setTimeout(() => {

                history.push('/categories')
            },3000)
            })

    }

    useEffect(() => {
          axios.put(`http://localhost:8000/api/categories/${id}`)
        .then(res => {
            
            const category = res.data
            setName(category.name)
           setStatus(category.status)
        })    
        
        
    },[id])
    return (
        <div>
            <h1>Cadastro de categorias</h1>
            
            <form className="form-group m-3">
                <label htmlFor="">Nome</label>
                <input type="text" value={name} onChange={e => setName(e.target.value)}className="form-control col-6"/>

                <label htmlFor="">Status</label>
                <select name="" value={status} id="" onChange={e => setStatus(e.target.value)} className="form-control col-6">
                <option value="" disabled hidden>Selecione uma opcao</option>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>

                <button className="btn btn-info m-4" type="submit" onClick={e => handleSubmit(e)}>Cadastrar</button>
            </form>

            
        </div>
    )
}



export default CategoryEdit