import axios from 'axios'

 const getSales = ({commit}) => {
   axios.get('http://127.0.0.1:8000/api/sales')
   .then(resposta => {
       console.log(resposta.data)
       commit('GET_SALES',resposta.data)
   })
}

const postSales = ({commit},sale) => {
    axios.post('http://127.0.0.1:8000/api/sales',sale)
  
        .then(() => { 
            commit('POST_SALE',sale)
        })
}


export default {
    getSales,
    postSales,
   
}
