import axios from 'axios';
import { useRouter } from 'vue-router';

export default function () {
    const router = useRouter();

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
                router.push({ name: 'login' })
                alert('Session expired!')
            }

            if (error.response && error.response.status === 500) {
                router.push({ name: 'login' })
                alert('Bad gateway!')
            }

            return Promise.reject(error);
        }
    );

    return instance;
}