<template>
    <div class="max-w-screen-md mx-auto bg-blue-100 text-blue-400 text-xl p-4">{{ moment().format('MMMM, YYYY') }}</div>
</template>

<script setup>
import moment from 'moment';
</script>