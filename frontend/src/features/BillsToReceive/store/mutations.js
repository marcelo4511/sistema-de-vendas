const GET_CLIENT = (state,fornecedores) => {
    state.fornecedores = fornecedores
}

const POST_CLIENT = (state,billstoreceive) => {
    state.billstoreceives.push(billstoreceive)
}

const UPDATE_CLIENT = (state,fornecedor) => {
    state.fornecedores.forEach(element => element.id === fornecedor.id)
}
export default {
    GET_CLIENT,
    POST_CLIENT,
    UPDATE_CLIENT
}