<template>
    <Toolbar title="Checks Control" classes="bg-blue-100 text-blue-400" />

    <Loading v-if="!isLoaded" />
    <div v-else class="max-w-screen-md mx-auto p-3 text-blue-500">
        <h4 v-if="checks.length === 0" class="font-bold text-center mt-4 text-blue-200">Nothing found</h4>
        <ul class="flex flex-col">
            <li v-for="check in checks"
                class="py-3 flex flex-row items-center justify-between border-b border-solid border-blue-200 hover:text-blue-300 hover:cursor-pointer"
                @click="goToCheckDetails(check.id)">
                <span>
                    <h4 class="font-bold text-xs">{{ check.user }}</h4>
                    <span class="text-xs">{{ check.created_at }}</span>
                </span>
                <div class="flex items-center justify-center">
                    <span class="text-xl font-semibold">${{ check.amount.toFixed(2) }}</span>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import http from '../services/http';
import Loading from './Loading.vue';
import Toolbar from './Toolbar.vue';

const router = useRouter()

const isLoaded = ref(false)

const checks = ref([])

onMounted(() => {
    http().get('/checks/pending')
        .then((response) => (checks.value = response.data))
        .catch((error) => (console.log(error)))
        .finally(() => (isLoaded.value = true))
})

const goToCheckDetails = (id) => {
    router.push({ name: 'checkDetails', params: { id } })
}
</script>