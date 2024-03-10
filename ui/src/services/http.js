import axios from 'axios'


export default (function () {
    const token = localStorage.getItem("token")
    
    console.log(token)
    
    return axios.create({
        baseURL: 'http://localhost:8000/api',
        timeout: 1000,
        headers: { 'Authorization': `bearer ${token}` }
    })
}())