import axios from 'axios' 

const getProvider = ({commit}) => {
    axios.get('http://127.0.0.1:8000/api/fornecedores')
    .then(res => {
        commit('GET_CLIENT',res.data)
    })
}

const postProvider = ({commit},fornecedor) => {
    axios.post('http://127.0.0.1:8000/api/fornecedores',fornecedor) 
    .then(() => {
        commit('POST_CLIENT',fornecedor)
    })
}

const updateProvider = async ({commit},fornecedor) => {
   await axios.put(`http://127.0.0.1:8000/api/fornecedores/${fornecedor.id}`,fornecedor)
   .then(resposta =>{
   return resposta.data
})
    commit('UPDATE_CLIENT',fornecedor)
}

export default {
    getProvider,
    postProvider,
    updateProvider
}