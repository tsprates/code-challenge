<template>
  <div class="max-w-screen-md mx-auto">
    <div class="text-center pt-16 text-xl bg-blue-500 text-white">
      <h1 class="p-3">BNB Bank</h1>
    </div>

    <form class="flex flex-col gap-3 space-y-1 pt-8" @submit.prevent="login">
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
      <button type="button" class="text-sm text-blue-300 w-[50%]" @click="goToSignUp">Sign up</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import http from '../services/http';

const router = useRouter()

const email = ref(null)
const password = ref(null)

const login = () => {
  const payload = {
    email: email.value,
    password: password.value,
  }

  http().post("/auth/login", payload)
    .then((response) => {
      const { access_token } = response.data
      console.log(access_token)
      localStorage.setItem("token", access_token)
      router.push({ name: 'balance' })
    })
    .catch((error) => {
      alert('Invalid credentials!')
      console.log(error)
    })
}

const goToSignUp = () => {
  router.push({ name: 'signUp' })
}
</script>