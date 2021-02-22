import axios from 'axios' 

const getClient = ({commit}) => {
    axios.get('http://127.0.0.1:8000/api/clients')
    .then(res => {
        commit('GET_CLIENT',res.data)
    })
}

const postClient = ({commit},client) => {
    axios.post('http://127.0.0.1:8000/api/clients',client)
    .then(() => {
        commit('POST_CLIENT',client)
    })
}

const updateClient = async ({commit},client) => {
   await axios.put(`http://127.0.0.1:8000/api/clients/${client.id}`,client)
   .then(resposta =>{
   return resposta.data
})
    commit('UPDATE_CLIENT',client)
}

export default {
    getClient,
    postClient,
    updateClient
}