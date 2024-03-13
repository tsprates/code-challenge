<template>
    <div class="max-w-screen-md mx-auto">
        <div class="text-center pt-16 text-xl bg-blue-500 text-white">
            <h1 class="p-3">BNB Bank</h1>
        </div>

        <form class="flex flex-col gap-3 space-y-1 pt-8" @submit.prevent="login">
            <div class="flex flex-col items-center justify-center">
                <input type="text" placeholder="username" v-model="name"
                    :class="{ 'login-input': true, 'input-error': errors.name }" v-bind="nameAttrs" />
                <div v-if="errors.name" class="label-error">{{ errors.name }}</div>
            </div>

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
                <button type="submit" placeholder="password" :disable="submitting"
                    class="rounded-md w-[90%] p-3 mt-2 bg-blue-500 text-white uppercase active:bg-blue-400">Sign
                    Up</button>
            </p>

            <div class="text-center mt-4">
                <button type="button" class="text-sm text-blue-300 w-[50%]" @click="goToLogin">Already have an
                    account?</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm } from 'vee-validate';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import * as yup from 'yup';
import http from '../services/http';

const router = useRouter()

const { errors, handleSubmit, defineField } = useForm({
    validationSchema: yup.object({
        name: yup.string().min(5).required(),
        email: yup.string().email().required(),
        password: yup.string().min(5).required(),
    }),
})

const [name, nameAttrs] = defineField('name');
const [email, emailAttrs] = defineField('email');
const [password, passwordAttrs] = defineField('password');

const submitting = ref(false)

const login = handleSubmit((values) => {
    const payload = {
        name: values.name,
        email: values.email,
        password: values.password,
    }

    submitting.value = true

    http().post("/auth/register", payload)
        .then(() => {
            alert('User succesfully registered!')
            router.push({ name: 'login' })
        })
        .catch((error) => {
            console.log(error)
        })
        .finally(() => (submitting.value = false))
})

const goToLogin = () => {
    router.push({ name: 'login' })
}
</script>