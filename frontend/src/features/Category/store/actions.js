import axios from 'axios'
import { API_BASE_URL } from '../../../config/Api'

 const setList = ({commit}) => {
   axios.get(`${API_BASE_URL}/categories`)
   .then(resposta => {
       console.log(resposta.data)
       commit('SET_LIST',resposta.data)
   })
}

const showList = async( { commit }, category) => {
    await axios.get(`${API_BASE_URL}/categories/${category.id}`,category)
    .then(resposta =>{
        console.log(resposta.data)
    })
   commit('SHOW_LIST', category);
}

const postList = ({commit},category) => {
    axios.post(`${API_BASE_URL}/categories`,category)
  
        .then(() => { 
            commit('POST_LIST',category)
        })
}

const removeList = ({commit}, category) => {
    axios.delete(`${API_BASE_URL}/categories/${category.id}`)
       .then((response) =>{
           commit('REMOVE_LIST', response.data)
       })
}
const updateList = async( { commit }, category) => {
     await axios.put(`${API_BASE_URL}/categories/${category.id}`,category)
     .then(resposta =>{
         console.log(resposta.data)
     })
    commit('UPDATE_LIST', category);
}

export default {
    setList,
    showList,
    postList,
    updateList,
    removeList
}
