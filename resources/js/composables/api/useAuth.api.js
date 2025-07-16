import { useApiClient } from "../useApiClient";

export function useAuthApi() {
    const { loading, error, execute } = useApiClient();

    const login = (email, password) =>
        execute("POST", `/api/login`, { email, password });

    const logout = () => execute("POST", `/api/logout`);

    return { loading, error, login, logout };
}
