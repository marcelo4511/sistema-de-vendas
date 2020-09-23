import {createStore,combineReducers, applyMiddleware} from 'redux'
import ClientsReducer from './clients/ClientsReducer'
import thunk from 'redux-thunk'
const rootReducer = combineReducers({

    clients:ClientsReducer
})

const store = createStore(rootReducer,applyMiddleware(thunk))
//export const store= createStore(ClientsReducer,applyMiddleware(thunk))

export default store