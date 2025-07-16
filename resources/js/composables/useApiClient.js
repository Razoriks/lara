import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";

export function useApiClient() {
    const router = useRouter();

    const loading = ref(false);
    const error = ref(null);

    const apiClient = axios.create({
        timeout: 10000,
        withCredentials: true,
    });

    apiClient.interceptors.request.use((config) => {
        const token = localStorage.getItem("auth_token");

        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }

        return config;
    });

    const execute = async (method, url, data = null, params = null) => {
        loading.value = true;

        try {
            const response = await apiClient({ method, url, data, params });

            return response.data;
        } catch (err) {
            error.value = err.response?.data?.message || err.message;

            switch (err.response.status) {
                case 401:
                    alert("Не удалось авторизоваться!");
                    localStorage.removeItem("auth_token");
                    router.push("/login");
                    break;
                default:
                    alert(error.value);
            }

            throw err;
        } finally {
            loading.value = false;
        }
    };

    return { apiClient, execute, loading, error };
}
