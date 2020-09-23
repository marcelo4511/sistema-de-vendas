import axios from 'axios'

 const setList = ({commit}) => {
   axios.get('http://127.0.0.1:8000/api/categories')
   .then(resposta => {
       console.log(resposta.data)
       commit('SET_LIST',resposta.data)
   })
}

const showList = async( { commit }, category) => {
    await axios.get(`http://127.0.0.1:8000/api/categories/${category.id}`,category)
    .then(resposta =>{
        console.log(resposta.data)
    })
   commit('SHOW_LIST', category);
}

const postList = ({commit},category) => {
    axios.post('http://127.0.0.1:8000/api/categories',category)
  
        .then(() => { 
            commit('POST_LIST',category)
        })
}

const removeList = ({commit}, category) => {
    axios.delete(`http://127.0.0.1:8000/api/categories/${category.id}`)
       .then((response) =>{
           commit('REMOVE_LIST', response.data)
       })
}
const updateList = async( { commit }, category) => {
     await axios.put(`http://127.0.0.1:8000/api/categories/${category.id}`,category)
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
