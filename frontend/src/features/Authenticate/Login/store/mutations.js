import axios from 'axios'
const setUserData = (state, userData) => {
    state.user = userData
    localStorage.setItem('user', JSON.stringify(userData))
    axios.defaults.headers.common.Authorization = `Bearer ${userData.token}`
  },     
   clearUserData = () => {
    localStorage.removeItem('user')
    location.reload()
  } 
export default{
  setUserData,
  clearUserData
}