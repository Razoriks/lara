<script setup>
import { onBeforeMount, ref, watch } from "vue";
import AuthenticatedLayout from "../layouts/AuthenticatedLayout.vue";
import { useUserApi } from "../composables/api/useUser.api";
import TransactionList from "../components/TransactionList.vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const { loading, loadTransactions } = useUserApi();

const pageSort = ref(route.query?.sort);
const pageOrder = ref(route.query?.order);
const searchQuery = ref(route.query?.description);

const transactions = ref(null);

const fetchTransactions = async (query = {}) => {
    try {
        transactions.value = await loadTransactions(query);
    } catch (error) {}
};

const toggleOrder = () => {
    const newOrder = pageOrder.value == "desc" ? "asc" : "desc";

    pageOrder.value = newOrder;

    router.push({ query: { ...route.query, order: newOrder } });
};

const search = () => {
    const description = searchQuery.value ?? null;

    router.push({ query: { ...route.query, description } });
};

watch(
    () => route.query,
    () => fetchTransactions(route.query)
);

onBeforeMount(() => {
    fetchTransactions(route.query);
});
</script>
<template>
    <AuthenticatedLayout>
        <form
            class="my-3 d-flex gap-2 align-items-end"
            @submit.prevent="search"
        >
            <div class="">
                <label class="form-label"> Поиск по описанию </label>
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Поиск"
                    class="form-control"
                />
            </div>
            <div>
                <button class="btn btn-primary" :disabled="loading">
                    Найти
                </button>
            </div>
        </form>

        <template v-if="transactions">
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Сумма</th>
                            <th scope="col">Тип</th>
                            <th scope="col">Описание</th>
                            <th scope="col">
                                <div
                                    class="cursor-pointer"
                                    @click="toggleOrder"
                                >
                                    <i
                                        v-if="pageOrder == 'asc'"
                                        class="bi bi-caret-up-fill"
                                    ></i>
                                    <i v-else class="bi bi-caret-down-fill"></i>

                                    <span> Дата </span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <TransactionList :transactions="transactions" />
                    </tbody>
                </table>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style>
.cursor-pointer {
    cursor: pointer;
}
</style>
