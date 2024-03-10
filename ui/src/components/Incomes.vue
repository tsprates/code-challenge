<template>
    <Toolbar title="Expenses" classes="bg-blue-100 text-blue-400" />
    
    <Date />
    
    <Loading v-if="!isLoaded" />

    <ListTransactions v-if="isLoaded" :transactions="transactions" />
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
    http.get('/incomes')
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