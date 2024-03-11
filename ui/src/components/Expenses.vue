<template>
    <Toolbar title="Expenses" classes="bg-blue-100 text-blue-400" />

    <Date />

    <Loading v-if="!isLoaded" />

    <ListTransactions v-if="isLoaded" :transactions="transactions" />

    <AddButton @click="goToAddPurchase" />
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import http from '../services/http';
import AddButton from './AddButton.vue';
import Date from './Date.vue';
import ListTransactions from './ListTransactions.vue';
import Loading from './Loading.vue';
import Toolbar from './Toolbar.vue';

const router = useRouter()

const isLoaded = ref(false)

const transactions = ref([])

onMounted(() => {
    http().get('/expenses')
        .then((response) => (transactions.value = response.data))
        .catch((error) => (console.log(error)))
        .finally(() => (isLoaded.value = true))
})

const goToAddPurchase = () => {
    router.push({ name: 'addPurchase' })
}

</script>