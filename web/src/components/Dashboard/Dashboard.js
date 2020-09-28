import React from 'react'

function Dashboard(){
    return (
        <div className="row painel">
        <div className="card text-white bg-primary ml-3 card1">
           <div className="card-header">
              <div className="row">
                <h5>Vendas <i className="fa fa-shopping-cart"></i></h5>
                <h5 className="esp">0</h5>
              </div>
            </div>
          </div>
          <div className="card text-white bg-secondary ml-3 card2" >
            <div className="card-header">
              <div className="row">
                <h5>Produtos <i className="fa fa-folder"></i></h5>
                <h5 className="esp">0</h5>
              </div>
            </div>
        </div>
          <div className="card text-white bg-success ml-3 card3" >
             <div className="card-header">
              <div className="row">
                <h5>Clientes <i className="fa fa-user"></i></h5>
                <h5 className="esp">0</h5>
              </div>
            </div>
          </div>
        </div>
    )
}

export default Dashboard