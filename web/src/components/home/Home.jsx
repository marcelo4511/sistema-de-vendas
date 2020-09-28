import React from 'react'

import Main from '../template/Main'
import './index.css'
import Dashboard from '../Dashboard/Dashboard'

export default props =>

<Main icon="home" title="inicio"
    subtitle="Segundo projeto do capitulo reactJS">
    <div className="display-4">Bem vindo!</div>
    <hr/>
    <p className="mb-8">Sistema para exemplificar a contrução
    de um cadastro desenvolvido em react</p>
    <Dashboard/>
   
</Main>