<template>
    <Toolbar />

    <Loading v-if="!isLoaded" />

    <TotalBalance v-if="isLoaded" :current_balance="currentBalance" :total_income="totalIncome"
        :total_expense="totalExpense" />

    <ListTransactions v-if="isLoaded" :transactions="transactions">
        <h3 class="text-md uppercase">Transactions</h3>
    </ListTransactions>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import http from '../services/http';
import ListTransactions from './ListTransactions.vue';
import Loading from './Loading.vue';
import Toolbar from './Toolbar.vue';
import TotalBalance from './TotalBalance.vue';

const isLoaded = ref(false)

const totalIncome = ref('-')
const totalExpense = ref('-')
const currentBalance = ref('-')

const transactions = ref([])

onMounted(() => {
    http.get('/transactions')
        .then((response) => {
            transactions.value = response.data.transactions
            totalIncome.value = (response.data.total_income).toFixed(2)
            totalExpense.value = (response.data.total_expense).toFixed(2)
            currentBalance.value = (response.data.total_income - response.data.total_expense).toFixed(2)
        })
        .catch((error) => {
            console.log(error)
        })
        .finally(() => (isLoaded.value = true))
})

</script>