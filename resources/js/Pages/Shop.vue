<template>
    <NotificationSimple
        :flashKey="flashKey"
        :flashMessage="flashMessage"
    />
    <Main>
        <Head title="Shop" />
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="text-xl font-bold text-gray-900">Our products</h2>

            <div class="mt-8 grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                <div v-if="products.data.length" v-for="product in products.data" :key="product.id">
                    <div class="relative">
                        <div class="relative h-72 w-full overflow-hidden rounded-lg">
                            <img :src="product.image_url" :alt="product.title" class="size-full object-cover" />
                        </div>
                        <div class="relative mt-4">
                            <h3 class="text-sm font-medium text-gray-900">{{ truncateSentence(product.title, 10) }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ truncateSentence(product.description, 30) }}</p>
                        </div>
                        <div class="absolute inset-x-0 top-0 flex h-72 items-end justify-end overflow-hidden rounded-lg p-4">
                            <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50" />
                            <p class="relative text-lg font-semibold text-white">{{ product.price }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="mt-6 cursor-pointer">
                            <button @click="removeProduct(product)" class="relative flex items-center justify-center rounded-md border border-transparent bg-gray-100 px-8 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200"
                            >Remove<span class="sr-only">, {{ product.name }}</span></button
                            >
                        </div>
                        <div class="mt-6 cursor-pointer">
                            <button @click="addProduct(product)" class="relative flex items-center justify-center rounded-md border border-transparent bg-gray-100 px-8 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200"
                            >Add to bag<span class="sr-only">, {{ product.name }}</span></button
                            >
                        </div>
                    </div>
                </div>
                <div v-else class="relative">
                    <p> {{message}} </p>
                </div>
            </div>

            <!-- Pagination Buttons -->
            <div class="sm:w-full">
                <div v-if="products.links" class="justify-center mt-4 sm:flex-row lg:flex gap-2">
                    <button
                        v-for="(link, index) in products.links"
                        :key="index"
                        :disabled="!link.url"
                        @click="fetchProducts(link.url.split('page=')[1])"
                        :class="{'font-bold bg-gray-200 px-3 py-1': link.active, 'px-3 py-1 border': !link.active}"
                    >
                        <span v-html="link.label"></span>
                    </button>
                </div>
            </div>
        </div>
    </Main>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Main from "@/Pages/Main.vue";
import {onMounted, ref} from 'vue';
import { truncateSentence } from "@/Composables/useTruncateSentence.vue";
import { useProducts } from "@/Composables/useProducts.vue";
import NotificationSimple from "@/Components/NotificationSimple.vue";
const { fetchProducts, products, message } = useProducts();
import { useForm } from "@/Composables/useForm.vue";
const { flashKey, flashMessage, addProduct, removeProduct } = useForm();

    // Lifecycle hook
    onMounted( () => {
        fetchProducts();
    });

</script>
