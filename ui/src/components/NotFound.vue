<template>
    <div class="max-w-screen-md mx-auto">
        <div class="text-center pt-16 text-xl bg-blue-500 text-white">
            <h1 class="p-3">BNB Bank</h1>
        </div>
    </div>
    <div class="max-w-screen-md mx-auto">
        <h3 class="flex items-center justify-center gap-2 mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-blue-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg> <span class="font-bold text-center text-blue-400">Not Found 404</span>
        </h3>
        <div class="flex items-center justify-center">
            <button type="button"
                class="mt-8 font-bold p-2 rounded-sm shadow-md bg-blue-500 text-white hover:bg-blue-400 active:hover:bg-blue-300 hover:cursor-pointer"
                @click="$router.back()">Back</button>
        </div>
    </div>
</template>