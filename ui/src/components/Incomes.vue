<template>
    <Toolbar title="Expenses" classes="bg-blue-100 text-blue-400" />

    <Date />

    <ul class="list-status">
        <li :class="{ 'status': true, 'active-status': status === 'pending' }" @click="status = 'pending'">Pending</li>
        <li :class="{ 'status': true, 'active-status': status === 'accepted' }" @click="status = 'accepted'">Accepted</li>
        <li :class="{ 'status': true, 'active-status': status === 'rejected' }" @click="status = 'rejected'">Rejected</li>
    </ul>

    <Loading v-if="!isLoaded" />

    <ListTransactions v-if="isLoaded" :transactions="currentIncomes" />
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import http from '../services/http';
import Date from './Date.vue';
import ListTransactions from './ListTransactions.vue';
import Loading from './Loading.vue';
import Toolbar from './Toolbar.vue';

const isLoaded = ref(false)

const transactions = ref([])
const currentIncomes = ref([])
const status = ref('accepted')

onMounted(() => {
    http().get('/incomes')
        .then((response) => {
            transactions.value = response.data
            currentIncomes.value = transactions.value.filter((income) => (income.check.status === status.value))
        })
        .catch((error) => {
            console.log(error)
        })
        .finally(() => (isLoaded.value = true))
})

watch(status, (newStatus) => {
    currentIncomes.value = transactions.value.filter((income) => (income.check.status === newStatus))
})

</script>