import React, { useEffect, useState } from 'react'
import {useHistory} from 'react-router-dom'
import Noty from 'noty'
import '../../../node_modules/noty/lib/noty.css'
import '../../../node_modules/noty/lib/themes/mint.css'
import './index.css'
import axios from 'axios'

const SaleCreate = () => {

    const history = useHistory()
    const inputs = document.querySelectorAll(".input");
    const [datavenda,setDatavenda] = useState('')
    const [clients,setClients] = useState('')
    const [Value,setValue] = useState([])
    //const [product_id,setProduct] = useState('')
    const [Value1,setValue1] = useState([])
    const [detalhesItems,setDetalhesItems] = useState([
        {
            product_id:'',price:'',descount:'',subtotal:0
        }
    ])
    let [total,setTotal] = useState(detalhesItems.forEach((total,i) => {
       return total = total + i.subtotal
    }))
  
    useEffect(() => {
        const getClients = async () => {
            const result =  await axios.get('http://localhost:8000/api/clients')
            setValue(
                result.data.map(({ name,id }) => ({ label: name, value:id }))
              );
            console.log(result.data.map(({ name }) => ({ client_id:name })))
        }
        getClients()
    },[])

    useEffect(() => {
        const getProducts = async () => {
            const resultado = await axios.get('http://localhost:8000/api/products')
            setValue1 (
                resultado.data.map(({name,id}) => ({label:name,value:id}))
            )
            console.log(resultado.data.map(({name}) => ({product_id:name})))
        }
        getProducts()
    },[])

    const onChange = (e) => {
        setClients(e.currentTarget.value);
    };

    const handleAddDetails =(e) =>{
        setDetalhesItems([
            ...detalhesItems,
            {
                product_id:'',price:'',descount:'',subtotal:0
            }
        ])
    }

    const handleInputChange = (e, index) => {
        const { name, value } = e.target;
        const list = [...detalhesItems];
        list[index][name] = value;
        list.forEach((i,e) => {
            i.subtotal = i.price * i.descount
            console.log(i.subtotal)
        })
        setDetalhesItems(list);
      };
    
    const handleRemoveClick  = index => {
        const list = [...detalhesItems]
        list.splice(index,1)
        setDetalhesItems(list)
    } 
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

          await axios.post('http://localhost:8000/api/sales',{
                dataVenda:datavenda,
                total:total,
                client_id:clients,
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
                    text: "Não foi possível cadastrar a sua Venda.",
                    timeout: 4000
                }).show();
                console.log(err);
            })
        }
    }
    return (
        <div>
            <h1>Cadastro de Vendas</h1>
            
            <form className="form-group m-3">

                <label htmlFor="">Clientes</label>
                <select name="clients" type="number" value={clients}
                onChange={onChange} className="form-control col-6 input">
                <option value="" disabled >Selecione uma opção</option>
                {Value.map(({ label, value }) => (
                <option key={value} value={value}>{label}</option> ))}
                </select>

                <label htmlFor="">Descrição</label>
                <input type="date" value={datavenda} onChange={e => setDatavenda(e.target.value)} className="form-control col-6 input" required/>

            </form>

            <div>
                <fieldset>

            {detalhesItems.map((x, i) => {
                return (
                    <div className="row ml-4" key={i}>
              <div className="form-row mr-1">

              
            <select
              name="product_id"
              className="form-control col-3 mr-1"
              placeholder="Enter First Name"
              value={x.product_id}
              onChange={e => handleInputChange(e, i)}
              >
                  <option value="">selecione uma produto</option>
                  {Value1.map(({ label, value }) => (
                      <option key={value} value={value}>{label}</option> ))}
              </select>

            <input
              className="form-control col-3 mr-1"
              name="price"
              placeholder="preço"
              value={x.price}
              onChange={e => handleInputChange(e, i)}
              />

            <input
              className="form-control col-3 mr-1"
              name="descount"
              placeholder="Desconto"
              value={x.descount}
              onChange={e => handleInputChange(e, i)}
              />

            <input
              className="form-control col-2"
              name="subtotal"
              placeholder="subtotal"
              value={x.subtotal}
              onChange={e => handleInputChange(e, i)} disabled
              />

            </div>

                  
             <label htmlFor=""></label><br></br>
              {detalhesItems.length !== 1 && <button
                className="btn btn-danger"
                onClick={() => handleRemoveClick(i)}><i className="fa fa-trash"></i> Remove</button>}
              {detalhesItems.length - 1 === i && <button className="btn btn-primary" onClick={handleAddDetails}><i className="fa fa-plus">Adicionar</i></button>}
            
          </div>
        );
    })}
     <input value={total} onChange={e => setTotal(detalhesItems.reduce((total,i) => {
         return total = total+ i.subtotal
     }))}></input>

    </fieldset>
    
    </div>
    <button className="btn btn-info m-4" type="submit" onClick={e => handleSubmit(e)}>Cadastrar</button>
</div>
    )
}



export default SaleCreate