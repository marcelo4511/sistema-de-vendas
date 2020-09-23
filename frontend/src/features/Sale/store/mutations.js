const GET_SALES = (state,sales) => {
    state.sales = sales
}

const POST_SALES = (state, sale) => {
    state.sales.push(sale)
}


const REMOVE_LIST = (state, category) => {
    var naoaguento = state.list.find(l => l.id == category)
    state.list.splice(naoaguento,1)

}

const UPDATE_LIST = (state,category) => {
     state.list.forEach(l => l.id === category.id)
           
}
export default{
    GET_SALES,
    POST_SALES,
    UPDATE_LIST,
    REMOVE_LIST
}