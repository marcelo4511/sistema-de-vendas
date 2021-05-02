const GET_CLIENT = (state,fornecedores) => {
    state.fornecedores = fornecedores
}

const POST_CLIENT = (state,billstopays) => {
    state.billstopays.push(billstopays)
}

const UPDATE_CLIENT = (state,fornecedor) => {
    state.fornecedores.forEach(element => element.id === fornecedor.id)
}
export default {
    GET_CLIENT,
    POST_CLIENT,
    UPDATE_CLIENT
}