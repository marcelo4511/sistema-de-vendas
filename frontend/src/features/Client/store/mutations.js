const GET_CLIENT = (state,clients) => {
    state.clients = clients
}

const POST_CLIENT = (state,client) => {
    state.clients.push(client)
}

const UPDATE_CLIENT = (state,client) => {
    state.clients.forEach(element => element.id === client.id)
}
export default {
    GET_CLIENT,
    POST_CLIENT,
    UPDATE_CLIENT
}