
import React from 'react'
import {Link} from 'react-router-dom'
//import {useDispatch,useSelector} from 'react-redux'
//import {getClients} from '../../store/clients/ClientsReducer'

function ClientList(){

    
    //const [clients,setClients] = useState([])
   
    return (
        <div>
            <h1>Cadastro de Clientes</h1>

            <Link to="/clientcreate">
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
              //      clients.map((client,i) => {
//
  //                  return <tr key={i}>
    //                    <td>{client.name}</td>
      //                  
         //               <td>{client.status}</td>
    //</tbody>                <td>
         //                   <button className="btn btn-warning m-1"><i className="fa fa-pencil"></i></button>
          //                  <button className="btn btn-danger" ><i className="fa fa-trash"></i></button>
           //             </td>
            //        </tr>
            //        })
                    }
                </tbody>
            </table>
        </div>
    )
}

export default ClientList