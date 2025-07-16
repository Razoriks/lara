<script setup>
import { onBeforeMount, onBeforeUnmount, ref } from "vue";
import AuthenticatedLayout from "../layouts/AuthenticatedLayout.vue";
import { useUserApi } from "../composables/api/useUser.api";
import formatCurrency from "../utils/formatCurrency";
import TransactionList from "../components/TransactionList.vue";

const { loading, loadHomeData } = useUserApi();

const refreshInterval = ref(null);
const data = ref(null);

const fetchHomeData = async () => {
    try {
        data.value = await loadHomeData();
    } catch (error) {}
};

const startAutoRefresh = () => {
    refreshInterval.value = setInterval(fetchHomeData, 5000);
};

onBeforeMount(() => {
    fetchHomeData();
    startAutoRefresh();
});

onBeforeUnmount(() => {
    clearInterval(refreshInterval.value);
});
</script>
<template>
    <AuthenticatedLayout>
        <template v-if="data">
            <div class="my-3">
                <div class="fs-4 fw-semibold py-2">
                    Баланс: {{ formatCurrency(data.balance) }}
                </div>
            </div>

            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Сумма</th>
                            <th scope="col">Тип</th>
                            <th scope="col">Описание</th>
                            <th scope="col">Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        <TransactionList :transactions="data.transactions" />
                    </tbody>
                </table>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
