import React, { useState } from 'react'
//import {useHistory} from 'react-router-dom'
//import {useDispatch,useSelector } from 'react-redux'

//import {saveClients} from '../../store/clients/ClientsReducer'
import '../../../node_modules/noty/lib/noty.css'
import '../../../node_modules/noty/lib/themes/mint.css'
import './index.css'
import axios from 'axios'

const ClientCreate = () => {

    //const history = useHistory()
    //const inputs = document.querySelectorAll(".input");
    const [name,setName] = useState('')
    const [cpf,setCpf] = useState('')
    const [email,setEmail] = useState('')
    const [date_nasc,setDatenasc] = useState('')
    const [cep, setCep] = useState('')
    const [street,setStreet] = useState('')
    const [number,setNumber] = useState("")
    const [complement,setComplement] = useState("")
    const [city,setCity] = useState("")
    const [state,setState] = useState("")
    const [heigthboard,setNeigthboard] = useState("")
    const [fone,setFone] = useState("")
    const [celular,setCelular] = useState("")
    const [status,setStatus] = useState('')

    //const client = useSelector((state) => state.client)
//    const dispatch = useDispatch()


    const onSave = async () => {
        //dispatch(saveClients())
    }

    function handleCep(){
        axios.get(`https://viacep.com.br/ws/${cep}/json/`)
        
        .then(res => {
              
            console.log(res.data)
        });
    }

    
    return (
        <div>
            <h1>Cadastro de Clientes</h1>
            
            <form className="form-group m-3">

                <div className="row m-2">
                <div className="form-group">
                <label htmlFor="">Nome</label>
                <input type="text" value={name} onChange={e => setName(e.target.value)}className="form-control col-11 input" required/>
                </div>

                <div className="form-group"> 
                <label htmlFor="">CPF</label>
                <input type="text" value={cpf} onChange={e => setCpf(e.target.value)}className="form-control col-11 input" required/>
                </div>

                <div className="form-group">
                <label htmlFor="">E-mail</label>
                <input type="text" value={email} onChange={e => setEmail(e.target.value)}className="form-control col-11 input" required/>
                </div>

                <div className="form-group">
                <label htmlFor="">Data de nascimento</label>
                <input type="text" value={date_nasc} onChange={e => setDatenasc(e.target.value)}className="form-control input" required/>
                </div>
                </div>

                <div className="row m-2">

                <div className="form-group">
                <label htmlFor="">CEP</label>
                <input type="text" value={cep} onChange={e => setCep(e.target.value)} className="form-control input" required/>
                </div>

                <div className="form-group">
                    <label htmlFor="" className="hidden">botao</label>
                    <button type="button" onClick={handleCep} className="btn btn-primary form-control col-8 ml-2 mr-4 fa fa-search"></button>
                </div>

                <div className="form-group">
                <label htmlFor="">Rua</label>
                <input type="text" value={street} onChange={e => setStreet(e.target.value)}className="form-control col-11 input" required/>
                </div>

                <div className="form-group">
                <label htmlFor="">Número</label>
                <input type="text" value={number} onChange={e => setNumber(e.target.value)} className="form-control col-11 input" required/>
                </div>

                <div className="form-group">
                <label htmlFor="">Complemento</label>
                <input type="text" value={complement} onChange={e => setComplement(e.target.value)} className="form-control col-6 input"/>
                </div>

                </div>

                <div className="row m-2">
                <div className="form-group">
                <label htmlFor="">Cidade</label>
                <input type="text" value={city} onChange={e => setCity(e.target.value)} className="form-control col-11 input"/>
                </div>

                <div className="form-group">
                <label htmlFor="">Estado</label>
                <input type="text" value={state} onChange={e => setState(e.target.value)} className="form-control col-11 input"/>
                </div>

                <div className="form-group">
                <label htmlFor="">Bairro</label>
                <input type="text" value={heigthboard} onChange={e => setNeigthboard(e.target.value)} className="form-control col-11 input"/>
                </div>

                <div className="form-group">
                <label htmlFor="">Telefone</label>
                <input type="text" value={fone} onChange={e => setFone(e.target.value)} className="form-control input"/>
                </div>

                </div>
            
                <div className="row m-2">

                <div className="form-group">
                <label htmlFor="">Celular</label>
                <input type="text" value={celular} onChange={e => setCelular(e.target.value)} className="form-control col-11 input"/>
                </div>


                <div className="form-group">
                <label htmlFor="">Status</label>
                <select name="" value={status} ied="" onChange={e => setStatus(e.target.value)} className="form-control input" required>
                <option value="" disabled >Selecione uma opcao</option>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
                </div>
                </div>


                <button className="btn btn-info m-4" type="submit" onClick={e => onSave(e)}>Cadastrar</button>
            </form>

            
        </div>
    )
}



export default ClientCreate