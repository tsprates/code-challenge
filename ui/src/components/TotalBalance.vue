<template>
    <div class="max-w-screen-md mx-auto">
        <div class="bg-blue-300 text-white pt-8 pb-4 px-5 flex flex-row items-end justify-between">
            <div class="flex flex-col items-start justify-between">
                <h2 class="font-semibold text-sm">Current Balance</h2>
                <span v-if="current_balance >= 0" class="text-4xl font-semibold">${{ currentBalance }}</span>
                <span v-else class="text-4xl font-semibold text-red-400">-${{ currentBalance }}</span>
            </div>
            <div class="font-semibold text-lg w-1/3 md:text-center">{{ currentDate }}</div>
        </div>

        <div class="bg-blue-200 text-blue-500 px-4 py-6">
            <div class="flex flex-row items-center justify-between">
                <span>
                    <h4 class="font-semibold text-sm">Income</h4>
                    <span class="text-2xl font-semibold">${{ totalIncome }}</span>
                </span>
                <div class="flex flex-col items-center justify-center w-1/3 active:text-blue-500/50 hover:cursor-pointer"
                    @click="goToDepositCheck">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span class="text-xs uppercase">Deposit a check</span>
                </div>
            </div>
        </div>

        <div class="bg-blue-200/40 text-blue-500 px-4 py-6">
            <div class="flex flex-row items-center justify-between">
                <span>
                    <h4 class="font-semibold text-sm">Expense</h4>
                    <span class="text-2xl font-semibold">${{ totalExpense }}</span>
                </span>
                <div class="flex flex-col items-center justify-center w-1/3 active:text-blue-500/50 hover:cursor-pointer"
                    @click="goToAddPurchase">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span class="text-xs uppercase">Purchase</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import moment from 'moment';
import { defineProps, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter()

const { current_balance, total_income, total_expense } = defineProps(['current_balance', 'total_income', 'total_expense'])

const currentBalance = ref(parseFloat(current_balance).toFixed(2))
const totalIncome = ref(parseFloat(total_income).toFixed(2))
const totalExpense = ref(parseFloat(total_expense).toFixed(2))

const currentDate = moment().format('MMMM, YYYY')

const goToAddPurchase = () => router.push({ name: 'addPurchase' })
const goToDepositCheck = () => router.push({ name: 'depositCheck' })
</script>