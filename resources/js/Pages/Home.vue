<template>
<Main>
    <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
        <div class="hidden sm:mb-8 sm:flex sm:justify-center">
            <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                Start shopping right now!
                <Link :href="route('shop')" class="font-semibold text-indigo-600">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    Click here <span aria-hidden="true">&rarr;</span>
                </Link>
            </div>
        </div>
        <div class="text-center">
            <h1 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Products that make you smile!</h1>
            <p class="mt-8 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat.</p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <Link :href="route('shop')" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Shop</Link>
            </div>
        </div>
    </div>
</Main>
</template>
<script setup>
import Main from "@/Pages/Main.vue";
import { Link } from "@inertiajs/vue3";
</script>
