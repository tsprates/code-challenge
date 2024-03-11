<template>
    <Toolbar title="Expenses" classes="bg-blue-100 text-blue-400" />

    <Date />

    <Loading v-if="!isLoaded" />

    <ListTransactions v-if="isLoaded" :transactions="transactions" />
    <!-- <button type="button" class="rounded-full bg-blue-500 text-white fixed bottom-4 right-4 p-2"><svg xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
    </button> -->
</template>

<script setup>
import { onMounted, ref } from 'vue';
import http from '../services/http';
import Date from './Date.vue';
import ListTransactions from './ListTransactions.vue';
import Loading from './Loading.vue';
import Toolbar from './Toolbar.vue';

const isLoaded = ref(false)

const transactions = ref([])

onMounted(() => {
    http().get('/expenses')
        .then((response) => {
            transactions.value = response.data
            console.log(transactions.value)
        })
        .catch((error) => {
            console.log(error)
        })
        .finally(() => (isLoaded.value = true))
})

</script>