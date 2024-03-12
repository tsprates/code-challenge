<template>
    <div class="max-w-screen-md mx-auto p-3 text-blue-500">
        <slot></slot>
        <h4 v-if="transactions.length === 0" class="font-bold text-center mt-4 text-blue-200">Nothing found</h4>
        <ul class="flex flex-col">
            <li v-for="transaction in transactions"
                class="py-3 flex flex-row items-center justify-between border-b border-solid border-blue-200">
                <span>
                    <h4 class="font-bold text-xs">{{ transaction.description }}</h4>
                    <span class="text-xs">{{ moment(transaction.created_at).format("DD/MM/YYYY hh:mm A") }}</span>
                </span>
                <div class="flex items-center justify-center">
                    <span v-if="transaction.type === 'income'" class="text-xl font-semibold">${{ transaction.amount
                        }}</span>
                    <span v-else class="text-xl font-semibold text-red-500">-${{ transaction.amount }}</span>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import moment from 'moment';
import { defineProps } from 'vue';

const { transactions } = defineProps(['transactions'])
</script>