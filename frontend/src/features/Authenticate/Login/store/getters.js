import state from "./state"


  const isLogged = state => !!state.user
console.log(!!state.user)
export default{
    isLogged,
}