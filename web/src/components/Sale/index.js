import Axios from 'axios'
import React, { useEffect, useState } from 'react'
import {Link} from 'react-router-dom'
import jsPDF from 'jspdf'
import 'jspdf-autotable' 

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

    function handlePrint(){
        Axios.get("http://localhost:8000/api/sales")
            .then(function(res){
            console.log(res.data)
            })

            let columns = [
            {title:"Clientes",dataKey:"name"},
            {title:"Data da Venda",dataKey:"dataVenda"},
            {title:"Total das Vendas R$",dataKey: "total"}
            ];
            
            var doc = new jsPDF('p','pt');
            doc.text('Relatório das vendas realizadas',10,12)
            doc.autoTable(columns,sales);
            doc.save("relatorio.pdf");
    }

    
    return (
        <div>
            <h1>Cadastro de Vendas</h1>

            <Link to="/salescreate">
                <button className="btn btn-info m-2">
                    <span>Cadastrar</span>
                </button>
            </Link>
            <input type="text" className="form-control col-3 m-3 input"  placeholder="pesquisar..."/>

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
            <button onClick={handlePrint} className="btn btn-danger m-2"><i className="fa fa-print"></i> Baixar relatório total</button>
        </div>
    )
}

export default Sale