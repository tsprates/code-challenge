<template>
    <div class="bg-blue-300 text-white px-3 py-5 flex flex-row items-end justify-between">
        <div class="flex flex-col items-center justify-between">
            <h2 class="font-semibold text-sm">Current Balance</h2>
            <span class="text-4xl font-semibold">${{ current_balance }}</span>
        </div>
        <div class="font-bold text-lg">{{ moment().format('MMMM, YYYY') }}</div>
    </div>

    <div class="bg-blue-200 text-blue-500 px-3 py-5">
        <div class="flex flex-row items-center justify-between">
            <span>
                <h4 class="font-semibold text-sm">Income</h4>
                <span class="text-2xl font-semibold">${{ total_income }}</span>
            </span>
            <div class="flex flex-col items-center justify-center w-1/3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="text-xs uppercase">Deposit a check</span>
            </div>
        </div>
    </div>

    <div class="bg-blue-200/40 text-blue-500 px-3 py-5">
        <div class="flex flex-row items-center justify-between">
            <span>
                <h4 class="font-semibold text-sm">Expense</h4>
                <span class="text-2xl font-semibold">${{ total_expense }}</span>
            </span>
            <div class="flex flex-col items-center justify-center w-1/3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="text-xs uppercase">Purchase</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import moment from 'moment';
import { defineProps } from 'vue';

const { current_balance, total_income, total_expense } = defineProps(['current_balance', 'total_income', 'total_expense'])
</script>