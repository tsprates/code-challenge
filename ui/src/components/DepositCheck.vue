<template>
    <Toolbar title="Purchase" classes="bg-blue-100 text-blue-400" />

    <CurrentBalance />

    <div class="max-w-screen-md mx-auto">
        <form @submit.prevent="depositCheck">
            <div class="flex flex-col gap-y-2">
                <div class="flex flex-col p-4">
                    <label for="amount"
                        class="text-xs font-semibold uppercase py-2 text-blue-300 flex items-start justify-start gap-2"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 inline-block">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                        </svg> Amount</label>
                    <div class="grid grid-cols-4 gap-2 items-end">
                        <input type="number" id="amount" name="amount" placeholder="0.00" required step="0.01"
                            autocomplete="off" v-model="amount" v-bind="amountAttrs"
                            :class="{ 'col-span-3': true, 'input': true, 'input-error': errors.amount }" />
                        <span class="font-bold text-lg text-blue-400 text-center">USD</span>
                    </div>
                    <div v-if="errors.amount" class="label-error">{{ errors.amount }}</div>
                </div>

                <div class="flex flex-col p-4">
                    <span
                        class="text-xs font-semibold uppercase text-blue-300 flex items-start justify-start gap-2"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg> Date</span>
                    <span class="input">{{ moment().format('MMMM, YYYY') }}</span>
                </div>

                <div class="flex flex-col p-4">
                    <label for="description"
                        class="text-xs font-semibold uppercase text-blue-300 flex items-start justify-start gap-2"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                clip-rule="evenodd" />
                        </svg> Description</label>
                    <input type="text" id="description" name="description" required autocomplete="off"
                        v-model="description" v-bind="descriptionAttrs"
                        :class="{ 'input': true, 'input-error': errors.description }" />
                    <div v-if="errors.description" class="label-error">{{ errors.description }}</div>
                </div>
            </div>

            <!-- preview picture -->
            <div class="input-file" v-if="!picture">
                <label for="picture">
                    <span class="flex flex-col items-center justify-center text-blue-300 active:text-blue-200">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd"
                                d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.25 6a.75.75 0 0 0-1.5 0v4.94l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V9.75Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-xs font-semibold uppercase">Upload Check Picture</span>
                    </span>
                </label>
            </div>
            <label for="picture" v-if="picture">
                <img alt="Check" class="w-[90%] mx-auto h-32 object-fill" :src="picture" />
            </label>
            <input type="file" id="picture" name="picture" accept="image/*" class="hidden" @change="setPicture" />
            <div v-if="errors.picture" class="label-error text-center">{{ errors.picture }}</div>
            <!-- preview picture -->

            <div class="fixed bottom-2 left-0 md:relative md:bottom-1 md:mt-5 p-2 w-full">
                <button type="submit" :disabled="submitting"
                    :class="{ button: true, 'bg-blue-200': submitting }">Deposit Check</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import moment from 'moment';
import { useForm } from 'vee-validate';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import * as yup from 'yup';
import http from '../services/http';
import CurrentBalance from './CurrentBalance.vue';
import Toolbar from './Toolbar.vue';

const router = useRouter()

const { errors, handleSubmit, defineField } = useForm({
    validationSchema: yup.object({
        amount: yup.number().typeError('Amount must be a numeric value').required('Amount is required'),
        description: yup.string().min(3, 'Description must be at least 3 characters').required('Description is required'),
        picture: yup.mixed().required('Picture is required'),
        pictureFile: yup.mixed().required('Picture file is required'),
    }),
})

const [amount, amountAttrs] = defineField('amount');
const [description, descriptionAttrs] = defineField('description');
const [picture] = defineField('picture');
const [pictureFile] = defineField('pictureFile');

const submitting = ref(false)

const depositCheck = handleSubmit((values) => {
    const data = new FormData()
    data.append('amount', values.amount)
    data.append('description', values.description)
    data.append('picture', values.pictureFile)

    submitting.value = true

    http().post('/incomes', data, { 'Content-Type': `multipart/form-data; boundary=${data._boundary}` })
        .then(() => {
            alert('Successful deposit!')
            router.go(-1)
        })
        .catch((error) => {
            alert('Error: Unable to submit the form. Please try again later.')
            console.error(error)
        })
        .finally(() => (submitting.value = false))
})

const setPicture = (event) => {
    const file = event.target.files[0]
    if (file) {
        pictureFile.value = file
        picture.value = URL.createObjectURL(file)
    }
}
</script>