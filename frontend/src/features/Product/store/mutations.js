const GET_PRODUCTS = (state,products) => {
    state.products = products
}

const POST_PRODUCTS = (state, product) => {
    state.products.push(product)
}


const DELETE_PRODUCTS = (state, product) => {
    var remove = state.products.find(p => p.id == product)
    state.products.splice(remove,1)

}

const PUT_PRODUCTS = (state,product) => {
     state.products.forEach(produc => produc.id === product.id)
           
}
export default{
    GET_PRODUCTS,
    POST_PRODUCTS,
    PUT_PRODUCTS,
    DELETE_PRODUCTS
}