<template>
    <Main>
        <div v-if="form.selectedProducts.length > 0" class="relative lg:min-h-full">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-1 lg:gap-x-8 lg:px-8 lg:py-32 xl:gap-x-24">
                <div class="flex justify-center items-center">
                    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                        <h2 class="text-lg font-bold text-green-600">Payment Successful!</h2>
                        <p class="mt-2 text-gray-600">Redirecting in {{ countdown }} seconds...</p>
                    </div>
                </div>
                <div class="lg:col-start-1">
                    <h1 class="text-sm font-medium text-indigo-600">Payment successful</h1>
                    <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">Thanks for ordering</p>
                    <p class="mt-2 text-base text-gray-500">We appreciate your order, we’re currently processing it. So hang tight and we’ll send you confirmation very soon!</p>

                    <dl class="mt-16 text-sm font-medium">
                        <dt class="text-gray-900">Tracking number</dt>
                        <dd class="mt-2 text-indigo-600">51547878755545848512</dd>
                    </dl>

                    <ul role="list" class="mt-6 divide-y divide-gray-200 border-t border-gray-200 text-sm font-medium text-gray-500">
                        <li v-for="product in selectedProducts" :key="product.id" class="flex space-x-6 py-6">
                            <img :src="product.image_url" :alt="product.title" class="size-24 flex-none rounded-md bg-gray-100 object-cover" />
                            <div class="flex-auto space-y-1">
                                <h3 class="text-gray-900">
                                    <a :href="product.href">{{ product.title }}</a>
                                </h3>
                                <p>{{ product.article_code }}</p>
                                <p>{{ product.description }}</p>
                            </div>
                            <p class="flex-none font-medium text-gray-900">{{ product.price }}</p>
                        </li>
                    </ul>

                    <dl class="space-y-6 border-t border-gray-200 pt-6 text-sm font-medium text-gray-500">
                        <div class="flex justify-between">
                            <dt>Subtotal</dt>
                            <dd class="text-gray-900">€{{ totals.subtotal.toFixed(2) }}</dd>
                        </div>

                        <div class="flex justify-between">
                            <dt>Shipping</dt>
                            <dd class="text-gray-900">€{{totals.shipping.toFixed(2)}}</dd>
                        </div>

                        <div class="flex justify-between">
                            <dt>Taxes</dt>
                            <dd class="text-gray-900">€{{totals.tax.toFixed(2)}}</dd>
                        </div>

                        <div class="flex items-center justify-between border-t border-gray-200 pt-6 text-gray-900">
                            <dt class="text-base">Total</dt>
                            <dd class="text-base">€{{totals.total.toFixed(2)}}</dd>
                        </div>
                    </dl>

                    <dl class="mt-16 grid grid-cols-2 gap-x-4 text-sm text-gray-600">
                        <div>
                            <dt class="font-medium text-gray-900">Shipping Address</dt>
                            <dd class="mt-2">
                                <address class="not-italic">
                                    <span class="block">{{ orderData.customer_name }}</span>
                                    <span class="block">{{ orderData.customer_email }}</span>
                                    <span class="block">{{ orderData.customer_phone_number }}</span>
                                    <span class="block">{{ orderData.customer_street_name }}, {{ orderData.customer_house_number }}, </span>
                                    <span class="block">{{ orderData.customer_city}}, {{ orderData.customer_postal_code}}</span>
                                </address>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-900">Payment Information</dt>
                            <dd class="mt-2 space-y-2 sm:flex sm:space-x-4 sm:space-y-0">
                                <div class="flex-none">
                                    <svg aria-hidden="true" width="36" height="24" viewBox="0 0 36 24" class="h-6 w-auto">
                                        <rect width="36" height="24" rx="4" fill="#224DBA" />
                                        <path d="M10.925 15.673H8.874l-1.538-6c-.073-.276-.228-.52-.456-.635A6.575 6.575 0 005 8.403v-.231h3.304c.456 0 .798.347.855.75l.798 4.328 2.05-5.078h1.994l-3.076 7.5zm4.216 0h-1.937L14.8 8.172h1.937l-1.595 7.5zm4.101-5.422c.057-.404.399-.635.798-.635a3.54 3.54 0 011.88.346l.342-1.615A4.808 4.808 0 0020.496 8c-1.88 0-3.248 1.039-3.248 2.481 0 1.097.969 1.673 1.653 2.02.74.346 1.025.577.968.923 0 .519-.57.75-1.139.75a4.795 4.795 0 01-1.994-.462l-.342 1.616a5.48 5.48 0 002.108.404c2.108.057 3.418-.981 3.418-2.539 0-1.962-2.678-2.077-2.678-2.942zm9.457 5.422L27.16 8.172h-1.652a.858.858 0 00-.798.577l-2.848 6.924h1.994l.398-1.096h2.45l.228 1.096h1.766zm-2.905-5.482l.57 2.827h-1.596l1.026-2.827z" fill="#fff" />
                                    </svg>
                                    <p class="sr-only">Visa</p>
                                </div>
                                <div class="flex-auto">
                                    <p class="text-gray-900">Ending with 4242</p>
                                    <p>Expires 12 / 21</p>
                                </div>
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-16 border-t border-gray-200 py-6 text-right">
                        <Link :href="route('shop')" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Continue Shopping
                            <span aria-hidden="true"> &rarr;</span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="flex justify-center items-center mt-20">
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-lg font-bold text-red-600">No products selected, go buy some products first!</h2>
                <p class="mt-2 text-gray-600">Redirecting in {{ countdown }} seconds...</p>
            </div>
        </div>
    </Main>
</template>

<script setup>
import Main from "@/Pages/Main.vue";
import {Link} from "@inertiajs/vue3";
import { useForm } from "@/Composables/useForm.vue";
import {onMounted, ref} from "vue";
const { form, totals, clearForm, fetchTotals } = useForm();
import { router } from '@inertiajs/vue3'


    const selectedProducts = ref([]);
    const orderData = ref([]);
    const countdown = ref(30);

    // Methods
    const interval = setInterval(() => {
        countdown.value--;
        if (countdown.value === 0) {
            clearInterval(interval);
            router.visit(route('home')); // Redirect after countdown
        }
    }, 1000);

    // Lifecycle hooks
    onMounted(() => {
        fetchTotals();
        selectedProducts.value = form.value.selectedProducts;
        orderData.value = form.value.orderData.data;
        clearForm();
    });

</script>
