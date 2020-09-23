const SET_LIST = (state,list) => {
    state.list = list
}

const SHOW_LIST = (state,category) => {
    state.list.find(l => l.id === category.id)
}
const POST_LIST = (state, l) => {
    state.list.push(l)
}

const REMOVE_LIST = (state, category) => {
    var remove = state.list.find(l => l.id == category)
    state.list.splice(remove,1)

}

const UPDATE_LIST = (state,category) => {
     state.list.forEach(l => l.id === category.id)
           
}
export default{
    SET_LIST,
    SHOW_LIST,
    POST_LIST,
    UPDATE_LIST,
    REMOVE_LIST
}