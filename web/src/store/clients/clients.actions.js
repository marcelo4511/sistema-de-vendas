export const ADD_CLIENT = "ADD_CLIENT"
export const GET_CLIENTS = "GET_CLIENTS"

export const addClient = (client) => ({
    type:"ADD_CLIENT",
    payload:client,
})

export const setClients = (clients) => ({
    type:"GET_CLIENTS",
    payload:clients
})