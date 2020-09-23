import Axios from "axios"
//import axios from 'axios'
import {ADD_CLIENT} from "./clients.actions"
import {GET_CLIENTS} from "./clients.actions"

const initialState = []

export default function (state = initialState,action) {
    switch(action.type){
        case ADD_CLIENT:{
            return {...state,clients:[state.clients,action.payload]}
        }
        case GET_CLIENTS:{
            return {state,
                clients:action.payload}
        }
        default:
            return state
    }
}



export const getClients = () => {
    return (dispatch) => {
        Axios.get('http://localhost:8000/api/clients')
        .then(res => {
            dispatch({type: 'GET_CLIENTS',payload:res.data})
            console.log(res.data)
        }).catch(console.log)
    }
}

export const addProducts = (client) => {
    return (dispatch) => {
        Axios.post('http://localhost:8000/api/clients',client)
        .then((res) => dispatch(ADD_CLIENT(res.data))).catch(console.log())
    }
}