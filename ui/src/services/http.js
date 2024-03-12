import axios from 'axios';

export default function () {
    const token = localStorage.getItem("token");

    const instance = axios.create({
        baseURL: import.meta.env.VITE_API_URL,
        timeout: 10000
    });

    if (token) {
        instance.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    }

    instance.interceptors.response.use(
        response => response,
        error => {
            // Handle token expiration or unauthorized access
            // Redirect user to login page
            if (error.response && error.response.status === 401) {
                window.location.pathname = '/login'
                alert('Session expired!')
            }

            if (error.response && error.response.status === 500) {
                window.location.pathname = '/login'
                alert('Bad gateway!')
            }

            return Promise.reject(error);
        }
    );

    return instance;
}