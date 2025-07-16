import { useApiClient } from "../useApiClient";

export function useUserApi() {
    const { loading, error, execute } = useApiClient();

    const loadHomeData = () => execute("get", `/api/home`);

    const loadTransactions = (query = null) => {
        return execute("get", `/api/transactions`, null, query);
    };

    return { loading, error, loadHomeData, loadTransactions };
}
