import store from "./store/index.js";
import router from "./router/index.js";
import axios from "axios";


const axiosClient = axios.create({
    baseURL: 'http://localhost:8000/api',
})

axiosClient.interceptors.request.use(config => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`
    return config;
})

axiosClient.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.response.status === 401) {
        sessionStorage.removeItem('TOKEN')
        router.push({name: 'login'})
    }
    throw error;
})

export default axiosClient;
