import axios from 'axios' 
import {API_BASE_URL} from '../../../config/Api'
const getProvider = ({commit}) => {
    axios.get(`${API_BASE_URL}/fornecedores`).then(res => {
        commit('GET_CLIENT',res.data)
    })
}
const postProvider = ({commit},fornecedor) => {
    axios.post(`${API_BASE_URL}/fornecedores`,fornecedor) .then(() => {
        commit('POST_CLIENT',fornecedor)
    })
}
const updateProvider = async ({commit},fornecedor) => {
   await axios.put(`${API_BASE_URL}/fornecedores/${fornecedor.id}`,fornecedor).then(resposta =>{
   return resposta.data
})
    commit('UPDATE_CLIENT',fornecedor)
}

export default {
    getProvider,
    postProvider,
    updateProvider
}