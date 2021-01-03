import axios from 'axios'
import { API_BASE_URL } from '../../../../config/Api'

const login =  ({ commit }, credentials) => {
    return  axios.post(`${API_BASE_URL}/login`,credentials)
      .then(({ data }) => {
        commit('setUserData', data)
      })
  },

   logout = ({ commit }) => {
    commit('clearUserData')
  }

  
export default {
    login,
    logout,
}