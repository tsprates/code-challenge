<template>
    <div :class="cssClasses">
        <span @click="showNav" class="absolute bottom-0 left-0 p-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </span>
        <h1 class="text-lg font-bold">BNB Bank</h1>
    </div>

    <div :class="{ 'nav': true, 'slideIn': isNavVisible, 'slideOut': isNavVisible === false }">
        <div class="nav-header">
            <h2>BNB Bank</h2>
        </div>
        <div class="nav-list">
            <router-link to="/balance" class="nav-item" @click="isNavVisible = false">
                <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z" />
                    </svg>
                </span>
                <span class="nav-label">Balance</span>
            </router-link>

            <router-link to="/incomes" class="nav-item" @click="isNavVisible = false">
                <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m9 9 6-6m0 0 6 6m-6-6v12a6 6 0 0 1-12 0v-3" />
                    </svg>
                </span>
                <span class="nav-label">Incomes</span>
            </router-link>

            <router-link to="/expenses" class="nav-item" @click="isNavVisible = false">
                <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m15 15-6 6m0 0-6-6m6 6V9a6 6 0 0 1 12 0v3" />
                    </svg>
                </span>
                <span class="nav-label">Expenses</span>
            </router-link>
        </div>
    </div>

    <div id="mask" class="mask" v-if="isNavVisible" @click="hideNav">
    </div>

</template>

<script setup>
import { computed, defineProps, ref } from 'vue';

const { title, classes } = defineProps({
    title: {
        type: String,
        default: 'BNB Bank'
    },
    classes: {
        type: String,
        default: 'bg-blue-400'
    }
})

const cssClasses = computed(() => `header ${classes}`)

const isNavVisible = ref(null);

const showNav = () => {
    isNavVisible.value = true;
}

const hideNav = () => {
    isNavVisible.value = false;
}
</script>

<style scoped>
@keyframes slideIn {
    from {
        transform: translate(-208px);
    }

    to {
        transform: translate(0);
    }
}

@keyframes slideOut {
    from {
        transform: translate(0);
    }

    to {
        transform: translate(-208px);
    }
}

.slideIn {
    animation-name: slideIn;
    animation-duration: 100ms;
    animation-timing-function: ease-in-out;
    transform: translate(0);
}

.slideOut {
    animation-name: slideOut;
    animation-duration: 100ms;
    animation-timing-function: ease-in-out;
    transform: translate(-208px);
}
</style>