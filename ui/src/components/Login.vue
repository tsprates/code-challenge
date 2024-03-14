<template>
  <div class="max-w-screen-md mx-auto">
    <div class="text-center pt-16 text-xl bg-blue-500 text-white">
      <h1 class="p-3">BNB Bank</h1>
    </div>

    <form class="flex flex-col gap-3 space-y-1 pt-8" @submit.prevent="login">
      <div class="flex flex-col items-center justify-center">
        <input type="text" placeholder="email" v-model="email"
          :class="{ 'login-input': true, 'input-error': errors.email }" v-bind="emailAttrs" />
        <div v-if="errors.email" class="label-error">{{ errors.email }}</div>
      </div>

      <div class="flex flex-col items-center justify-center">
        <input type="password" placeholder="password" v-model="password"
          :class="{ 'login-input': true, 'input-error': errors.password }" v-bind="passwordAttrs" />
        <div v-if="errors.password" class="label-error">{{ errors.password }}</div>
      </div>

      <p class="flex items-center justify-center">
        <button type="submit" placeholder="password" :disabled="submitting"
          class="rounded-md w-[90%] p-3 mt-2 bg-blue-500 text-white uppercase active:bg-blue-400 disabled:opacity-20 disabled:cursor-none">Login</button>
      </p>

      <div class="text-center mt-4">
        <button type="button" class="text-sm text-blue-300 w-[50%]" @click="goToSignUp">Sign up</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { useForm } from 'vee-validate';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import * as yup from 'yup';
import http from '../services/http';

const router = useRouter()

const { errors, handleSubmit, defineField } = useForm({
  validationSchema: yup.object({
    email: yup.string().email('Invalid email').required('Email is required'),
    password: yup.string().min(5, 'Password must be at least 5 characters').required('Password is required'),
  }),
})

const [email, emailAttrs] = defineField('email');
const [password, passwordAttrs] = defineField('password');

const submitting = ref(false)

const login = handleSubmit(async (values) => {
  submitting.value = true

  try {
    const response = await http().post("/auth/login", values)
    const { access_token } = response.data
    localStorage.setItem("token", access_token)
    router.push({ name: 'balance' })
  } catch (error) {
    alert('Invalid credentials!')
    console.error('Login failed:', error)
  } finally {
    submitting.value = false
  }
})

onMounted(async () => {
  const token = localStorage.getItem('token')

  if (token) {
    try {
      await http().post('/auth/me')
      console.log('Connected')
      router.push({ name: 'balance' })
    } catch (error) {
      alert('Unauthorized!')
      console.error('Error:', error)
    }
  }
})

const goToSignUp = () => router.push({ name: 'signUp' })
</script>