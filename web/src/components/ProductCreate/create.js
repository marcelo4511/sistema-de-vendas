import React, { useEffect, useState } from 'react'
import {useHistory} from 'react-router-dom'
import Noty from 'noty'
import '../../../node_modules/noty/lib/noty.css'
import '../../../node_modules/noty/lib/themes/mint.css'
import axios from 'axios'

const ProductCreate = () => {

    const history = useHistory()
    const inputs = document.querySelectorAll(".input");
    const [name,setName] = useState('')
    const [description,setDescription] = useState('')
    const [price,setPrice] = useState('')
    const [amount, setAmount] = useState('')
    const [subtotal,setSubtotal] = useState('')
    const [category_id,setCategories] = useState('')
    const [Value,setValue] = useState([])
    const [status,setStatus] = useState('')
  
    useEffect(() => {
        const getCategories = async () => {
            const result =  await axios.get('http://localhost:8000/api/categories')
            setValue(
                result.data.map(({ name,id,status }) => ({ label: name, value:id,teste:status }))
              );
            console.log(result.data.map(({ name,status }) => ({ category_id:name,teste:status, })))
        }
        getCategories()
    },[])

    const onChange = (e) => {
        setCategories(e.currentTarget.value);
    };
    const handleSubmit = async event => {
        event.preventDefault()
       
        let validado = true;
        let msg = "";
        inputs.forEach(input => {
            if(input.value === ""){
                input.style.borderColor = 'red';
                validado = false;
                msg = "Todos os campos são obrigatórios!"
            }else{
                input.style.borderColor = '#001EBA';
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

          await axios.post('http://localhost:8000/api/products',{
                name,
                description,
                price,
                amount,
                subtotal,
                category_id:category_id,
                status
            }).then(res => {
                console.log(res.data)
                new Noty({
                    type: 'success',
                    layout: 'topRight',
                    text: "Produto cadastrado com sucesso !!",
                    timeout: 3000
                }).show();

            setTimeout(() => {

                history.push('/products')
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
            <h1>Cadastro de Produtos</h1>
            
            <form className="form-group m-3">

                <label htmlFor="">Nome</label>
                <input type="text" value={name} onChange={e => setName(e.target.value)}className="form-control col-6 input" required/>

                <label htmlFor="">Descrição</label>
                <input type="text" value={description} onChange={e => setDescription(e.target.value)} className="form-control col-6 input" required/>

                <label htmlFor="">Preço</label>
                <input type="text" value={price} onChange={e => setPrice(e.target.value)} className="form-control col-6 input" />

                <label htmlFor="">desconto</label>
                <input type="text" value={amount} onChange={e => setAmount(e.target.value)} className="form-control col-6 input"/>

                <label htmlFor="">Subtotal</label>
                <input type="text" value={subtotal} onChange={e => setSubtotal(e.target.value)} className="form-control col-6 input"/>

                <label htmlFor="">Categorias</label>
                <select name="category_id" type="number" value={category_id}
                onChange={onChange} className="form-control col-6 input">
                <option value="" disabled >Selecione uma opcao</option>
                {Value.map(({ label, value,teste }) => (
                <option key={value} value={value} {...teste === 'Inativo' ? 'hidden' : false}>{teste}</option> ))}
                </select>

                <label htmlFor="">Status</label>
                <select name="status" value={status} id="status" onChange={e => setStatus(e.target.value)} className="form-control col-6 input">
                <option  value=""disabled >Selecione uma opcao</option>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>

                <button className="btn btn-info m-4" type="submit" onClick={e => handleSubmit(e)}>Cadastrar</button>
            </form>

            
        </div>
    )
}



export default ProductCreate