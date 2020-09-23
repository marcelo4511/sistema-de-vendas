import React, { useState } from 'react'
import {useHistory} from 'react-router-dom'
import Noty from 'noty'
import '../../../node_modules/noty/lib/noty.css'
import '../../../node_modules/noty/lib/themes/mint.css'
import axios from 'axios'

const CategoryCreate = () => {

    const history = useHistory()
    const caixas = document.querySelectorAll(".caixa");
    const [name,setName] = useState('')
    const [status,setStatus] = useState('')
  

    const handleSubmit = async event => {
        event.preventDefault()
       
        let validado = true;
        let msg = "";
        caixas.forEach(caixa => {
            if(caixa.value === ""){
                caixa.style.borderColor = 'red';
                validado = false;
                msg = "Todos os campos são obrigatórios!"
            }else{
                caixa.style.borderColor = '#001EBA';
            }
        })

        if(validado === false){
            new Noty({
                type: 'error',
                layout: 'topRight',
                text: msg,
                timeout: 4000
            }).show();

         }else{

          await axios.post('http://localhost:8000/api/categories',{
                name,
                status
            }).then(res => {
                console.log(res.data)
                new Noty({
                    type: 'success',
                    layout: 'topRight',
                    text: "Categoria cadastrada com sucesso !!",
                    timeout: 3000
                }).show();

            setTimeout(() => {

                history.push('/categories')
            },3000)
            }).catch(err => {
                new Noty({
                    type: 'error',
                    layout: 'topRight',
                    text: "Não foi possível cadastrar a sua Enquete.",
                    timeout: 4000
                }).show();
                console.log(err);
            })
        }
    }
    return (
        <div>
            <h1>Cadastro de categorias</h1>
            
            <form className="form-group m-3">
                <label htmlFor="">Nome</label>
                <input type="text" value={name} onChange={e => setName(e.target.value)}className="form-control col-6 caixa" />

                <label htmlFor="">Status</label>
                <select name="" value={status} id="" onChange={e => setStatus(e.target.value)} className="form-control col-6 caixa" >
                <option value="" disabled>Selecione uma opcao</option>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>

                <button className="btn btn-info m-4" type="submit" onClick={e => handleSubmit(e)}>Cadastrar</button>
            </form>

            
        </div>
    )
}



export default CategoryCreate