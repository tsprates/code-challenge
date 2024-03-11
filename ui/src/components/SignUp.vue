<template>
    <div class="max-w-screen-md mx-auto">
        <div class="text-center pt-16 text-xl bg-blue-500 text-white">
            <h1 class="p-3">BNB Bank</h1>
        </div>

        <form class="flex flex-col gap-3 space-y-1 pt-8" @submit.prevent="login">
            <p class="flex flex-row items-center justify-center">
                <input type="text" placeholder="name" v-model="name"
                    class="rounded-3xl w-[80%] p-3 mt-2 border-2 border-solid border-blue-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-200 focus:outline-none placeholder:text-blue-200" />
            </p>
            <p class="flex flex-row items-center justify-center">
                <input type="text" placeholder="email" v-model="email"
                    class="rounded-3xl w-[80%] p-3 mt-2 border-2 border-solid border-blue-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-200 focus:outline-none placeholder:text-blue-200" />
            </p>
            <p class="flex items-center justify-center">
                <input type="password" placeholder="password" v-model="password"
                    class="rounded-3xl w-[80%] p-3 mt-2 border-2 border-solid border-blue-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-200 focus:outline-none placeholder:text-blue-200" />
            </p>
            <p class="flex items-center justify-center">
                <button type="submit" placeholder="password"
                    class="rounded-md w-[90%] p-3 mt-2 bg-blue-500 text-white uppercase active:bg-blue-400">Login</button>
            </p>
        </form>

        <div class="text-center mt-4">
            <button type="button" class="text-sm text-blue-300 w-[50%]" @click="goToLogin">Already have an
                account?</button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import http from '../services/http';

const router = useRouter()

const name = ref(null)
const email = ref(null)
const password = ref(null)

const login = () => {
    const payload = {
        name: name.value,
        email: email.value,
        password: password.value,
    }

    http().post("/auth/register", payload)
        .then(() => {
            alert('User succesfully registered!')
            router.push({ name: 'login' })
        })
        .catch((error) => {
            alert('Invalid crendetials!')
            console.log(error)
        })
}

const goToLogin = () => {
    router.push({ name: 'login' })
}
</script>