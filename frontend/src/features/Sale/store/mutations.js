const GET_SALES = (state,sales) => {
    state.sales = sales
}

const POST_SALES = (state, sale) => {
    state.sales.push(sale)
}


const REMOVE_LIST = (state, sale) => {
    var remove = state.list.find(l => l.id == sale)
    state.list.splice(remove,1)

}

const UPDATE_LIST = (state,sale) => {
     state.list.forEach(l => l.id === sale.id)
           
}
export default{
    GET_SALES,
    POST_SALES,
    UPDATE_LIST,
    REMOVE_LIST
}