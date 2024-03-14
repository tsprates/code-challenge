<template>
    <Toolbar title="Check Details" classes="bg-blue-100 text-blue-400" />

    <Loading v-if="!isLoaded" />

    <div class="max-w-screen-md mx-auto mt-4">
        <div class="flex flex-col gap-y-2">
            <p class="flex flex-col p-4">
                <span class="text-xs uppercase text-blue-300 flex items-start justify-start gap-2"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd"
                            d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                            clip-rule="evenodd" />
                    </svg> Customer</span>
                <span class="col-span-3 text-xl pl-5 text-blue-400 placeholder:text-blue-300 py-2">
                    {{ check.customer }}
                </span>
            </p>
        </div>

        <div class="flex flex-col gap-y-2">
            <p class="flex flex-col p-4">
                <span class="text-xs uppercase text-blue-300 flex items-start justify-start gap-2"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path
                            d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                        <path
                            d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                    </svg>
                    Email</span>
                <span class="col-span-3 text-xl pl-5 text-blue-400 placeholder:text-blue-300 py-2">
                    {{ check.email }}
                </span>
            </p>
        </div>

        <div class="flex flex-col gap-y-2">
            <p class="flex flex-col p-4">
                <span class="text-xs uppercase text-blue-300 flex items-start justify-start gap-2"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 inline-block">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                    </svg> Amount</span>
                <span class="col-span-3 text-xl pl-5 text-blue-400 placeholder:text-blue-300 py-2">
                    ${{ check.amount }} USD
                </span>
            </p>
        </div>

        <div class="my-2">
            <img alt="Check" :src="check.picture" class="w-[90%] h-36 mx-auto" v-if="check.picture" />
        </div>

        <div class="fixed bottom-2 grid grid-cols-2 gap-2 left-0 md:relative md:bottom-1 md:mt-5 p-2 w-full"
            v-if="isLoaded">
            <button type="button" :class="{ 'button-reject': true, 'bg-blue-100': submittingReject }"
                @click="rejectCheck"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-4 h-4">
                    <path fill-rule="evenodd"
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                        clip-rule="evenodd" />
                </svg> Reject</button>

            <button type="button" :class="{ 'button-accept': true, 'bg-blue-200': submittingAccept }"
                @click="acceptCheck"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-4 h-4">
                    <path fill-rule="evenodd"
                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                        clip-rule="evenodd" />
                </svg> Accept</button>
        </div>
    </div>
</template>


<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import http from '../services/http';
import Loading from './Loading.vue';
import Toolbar from './Toolbar.vue';

const route = useRoute()
const { id } = route.params

const router = useRouter()

const isLoaded = ref(false)

const submittingAccept = ref(false)
const submittingReject = ref(false)

const check = reactive({
    customer: null,
    email: null,
    date: null,
    picture: null,
    amount: null,
})

onMounted(() => {
    http().get(`/checks/${id}`)
        .then((response) => {
            check.customer = response.data.user
            check.email = response.data.email
            check.amount = response.data.amount
            check.date = response.data.created_at
            check.picture = response.data.picture
        })
        .catch((error) => (console.log(error)))
        .finally(() => (isLoaded.value = true))
})

const acceptCheck = () => {
    submittingAccept.value = true

    http().patch(`/checks/${id}/status`, { 'status': 'accepted' })
        .then(() => alert(`Check accepted!`))
        .catch((error) => (console.log(error)))
        .finally(() => {
            submittingAccept.value = false
            router.go(-1)
        })
}

const rejectCheck = () => {
    submittingReject.value = true

    http().patch(`/checks/${id}/status`, { 'status': 'rejected' })
        .then(() => alert(`Check rejected!`))
        .catch((error) => (console.log(error)))
        .finally(() => {
            submittingReject.value = false
            router.go(-1)
        })
}
</script>