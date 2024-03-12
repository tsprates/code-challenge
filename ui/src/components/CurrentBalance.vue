<template>
    <div class="max-w-screen-md mx-auto">
        <div class="bg-blue-100 text-blue-500 p-4 px-4 flex flex-row items-end justify-between">
            <div class="flex flex-col items-start justify-between gap-2">
                <h2 class="text-xs font-semibold text-blue-300">Current Balance</h2>
                <span v-if="currentBalance >= 0 || currentBalance === '-'" class="text-2xl font-semibold text-blue-400">${{ currentBalance
                    }}</span>
                <span v-else class="text-4xl font-semibold text-red-400">-${{ Math.abs(currentBalance) }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import http from '../services/http';

const currentBalance = ref('-')

onMounted(() => {
    http().get('/balance')
        .then((response) => (currentBalance.value = response.data.balance.toFixed(2)))
        .catch((error) => (console.log(error)))
})
</script>