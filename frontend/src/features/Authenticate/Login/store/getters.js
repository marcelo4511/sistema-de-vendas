import state from "./state"
const isLogged = state => !!state.user
!!state.user
export default{
    isLogged,
}