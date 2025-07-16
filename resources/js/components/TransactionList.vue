<script setup>
import formatCurrency from "../utils/formatCurrency";
import formatDate from "../utils/formatDate";

defineProps({
    transactions: {
        type: Array,
        required: true,
        default: () => [],
    },
});
</script>
<template>
    <tr v-for="tr in transactions" :key="tr.id">
        <th scope="row">
            {{ tr.id }}
        </th>
        <td>{{ formatCurrency(tr.amount) }}</td>
        <td>
            {{ tr.type == 1 ? "Пополнение" : "Списание" }}
        </td>
        <td>
            {{ tr.description }}
        </td>
        <td>{{ formatDate(tr.created_at) }}</td>
    </tr>
</template>
