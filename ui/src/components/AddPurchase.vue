<template>
    <Toolbar title="Purchase" classes="bg-blue-100 text-blue-400" />
    <div class="max-w-screen-md mx-auto">
        <form @submit.prevent="addPurchase">
            <div class="flex flex-col gap-y-2 py-4">
                <p class="flex flex-col p-4">
                    <label for="amount"
                        class="text-xs font-semibold uppercase py-2 text-blue-300 flex items-start justify-start gap-2"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 inline-block">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                        </svg> Amount</label>
                    <div class="grid grid-cols-4 gap-2 items-end">
                        <input type="number" name="amount" placeholder="0.00" required autocomplete="off" v-model="amount"
                            class="col-span-3 text-xl text-blue-400 placeholder:text-blue-300 font-semibold py-2 border-b-2 border-solid border-blue-200 focus:outline-none focus:border-blue-300" />
                        <span class="font-bold text-xl text-blue-400 text-center">USD</span>
                    </div>
                </p>
                <p class="flex flex-col p-4">
                    <span
                        class="text-xs font-semibold uppercase py-2 text-blue-300 flex items-start justify-start gap-2"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg> Date</span>
                    <span
                        class="text-xl text-blue-400 font-semibold py-2 border-b-2 border-solid  border-blue-200 focus:outline-none focus:border-blue-300">
                        {{ moment().format('MMMM, YYYY') }}</span>
                </p>
                <p class="flex flex-col p-4">
                    <label for="description"
                        class="text-xs font-semibold uppercase py-2 text-blue-300 flex items-start justify-start gap-2"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                clip-rule="evenodd" />
                        </svg> Description</label>
                    <input type="text" name="description" required autocomplete="off" v-model="description"
                        class="text-xl text-blue-400 placeholder:text-blue-300 font-semibold py-2 border-b-2 border-solid  border-blue-200 focus:outline-none focus:border-blue-300" />
                </p>
            </div>
            <div class="fixed bottom-2 left-0 md:relative md:bottom-1 md:mt-5 p-2 w-full">
                <button type="submit"
                    class="rounded-sm text-xs uppercase text-center py-3 w-full bg-blue-500 active:bg-blue-500/50 text-white">Add
                    Purchase</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import moment from 'moment';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import http from '../services/http';
import Toolbar from './Toolbar.vue';

const router = useRouter()

const amount = ref(null)

const description = ref(null)

const addPurchase = () => {
    const payload = {
        amount: amount.value,
        description: description.value,
    }

    console.log(payload)

    http().post('/expenses', payload)
        .then(() => {
            alert('Successful purchase!')
            router.go(-1)
        })
        .catch(() => {
            alert(`Error when submitting the form!`)
        })
}

</script>