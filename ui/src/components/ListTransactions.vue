<template>
    <div class="p-3 text-blue-500">
        <slot></slot>
        <ul>
            <li v-for="transaction in transactions"
                class="py-3 flex flex-row items-center justify-between border-b border-solid border-blue-200">
                <span>
                    <h4 class="font-bold text-xs">{{ transaction.description }}</h4>
                    <span class="text-xs">{{ transaction.created_at }}</span>
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
import { defineProps } from 'vue';

const { transactions } = defineProps(['transactions'])
</script>