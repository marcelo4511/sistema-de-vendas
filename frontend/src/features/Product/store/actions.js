import axios from 'axios'

  const getProducts = ({commit}) => {
   axios.get('http://127.0.0.1:8000/api/products')
   .then(resposta => {
       console.log(resposta.data)
       commit('GET_PRODUCTS',resposta.data)
   })
}

const postProducts = ({commit},product) => {
    axios.post('http://127.0.0.1:8000/api/products',product)
  
        .then(() => { 
            commit('POST_PRODUCTS',product)
        })
}

const putProducts = ({commit},product) => {
    axios.put(`http://127.0.0.1:8000/api/products/${product.id}`,product)
    .then(() => {
        commit('PUT_PRODUCTS',product)
    })
}

const deleteProducts = ({commit},product) => {
    axios.delete(`http://127.0.0.1:8000/api/products/${product.id}`,product)
    .then((res) => {
        commit('DELETE_PRODUCTS',res.data)
    })
}


export default {
    getProducts,
    postProducts,
    putProducts,
    deleteProducts
}
