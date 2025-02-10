<template>
    <NotificationSimple
        :flashKey="flashKey"
        :flashMessage="flashMessage"
    />
    <Main>
            <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Shopping Cart</h1>
                <form
                    @submit.prevent="true"
                    class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16"
                >
                    <section aria-labelledby="cart-heading" class="lg:col-span-7">
                        <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                        <ul role="list" class="divide-y divide-gray-200 border-b border-t border-gray-200">
                            <li v-if="form.selectedProducts.length > 0" v-for="(product, productIdx) in form.selectedProducts" :key="product.id" class="flex py-6 sm:py-10">
                                <div class="shrink-0">
                                    <img :src="product.image_url" :alt="product.title" class="size-24 rounded-md object-cover sm:size-48" />
                                </div>

                                <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                                    <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                        <div>
                                            <div class="flex justify-between">
                                                <h3 class="text-sm">
                                                    <a :href="product.href" class="font-medium text-gray-700 hover:text-gray-800">{{ product.title }}</a>
                                                </h3>
                                            </div>
                                            <div class="mt-1 flex text-sm">
                                                <p class="text-gray-500">{{ product.color }}</p>
                                                <p v-if="product.description" class="ml-4 border-l border-gray-200 pl-4 text-gray-500">{{ product.description }}</p>
                                            </div>
                                            <p class="mt-1 text-sm font-medium text-gray-900">{{ product.price }}</p>
                                        </div>

                                        <div class="mt-4 sm:mt-0 sm:pr-9">
                                            <div class="grid w-full max-w-16 grid-cols-1">
                                                <select
                                                    :name="`quantity-${productIdx}`"
                                                    :aria-label="`Quantity, ${product.title}`"
                                                    v-model="product.quantity"
                                                    @change="updateQuantity(product, $event.target.value)"
                                                    class="col-start-1 row-start-1 appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                >
                                                    <option v-for="n in 100" :key="n" :value="n">
                                                        {{ n }}
                                                    </option>
                                                </select>
                                                <ChevronDownIcon
                                                    class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                                    aria-hidden="true"
                                                />
                                            </div>

                                            <div class="absolute right-0 top-0">
                                                <button
                                                    type="button"
                                                    @click="removeProduct(product)"
                                                    class="-m-2 inline-flex p-2 text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Remove</span>
                                                    <XMarkIcon class="size-5" aria-hidden="true" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="mt-4 flex space-x-2 text-sm text-gray-700">
                                        <CheckIcon v-if="product.inStock" class="size-5 shrink-0 text-green-500" aria-hidden="true" />
                                        <ClockIcon v-else class="size-5 shrink-0 text-gray-300" aria-hidden="true" />
                                        <span>{{ product.stock > 1 ? 'In stock' : `No more stock, re-stocking will take longer than 1 week` }}</span>
                                    </p>
                                </div>
                            </li>
                            <li v-else class="py-6 sm:py-10">
                                <div class="flex justify-center items-center">
                                    <p class="text-sm text-gray-500">Your cart is empty</p>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <!-- Order summary -->
                    <section aria-labelledby="summary-heading" class="mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
                        <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

                        <dl class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">€{{ totals.subtotal.toFixed(2) }}</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="flex items-center text-sm text-gray-600">
                                    <span>Shipping estimate</span>
                                    <a href="#" class="ml-2 shrink-0 text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Learn more about how shipping is calculated</span>
                                        <QuestionMarkCircleIcon class="size-5" aria-hidden="true" />
                                    </a>
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">€{{totals.shipping.toFixed(2)}}</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="flex text-sm text-gray-600">
                                    <span>Tax estimate</span>
                                    <a href="#" class="ml-2 shrink-0 text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Learn more about how tax is calculated</span>
                                        <QuestionMarkCircleIcon class="size-5" aria-hidden="true" />
                                    </a>
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">€{{totals.tax.toFixed(2)}}</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">Order total</dt>
                                <dd class="text-base font-medium text-gray-900">€{{totals.total.toFixed(2)}}</dd>
                            </div>
                        </dl>

                        <div class="mt-6">
                            <button
                                type="submit"
                                :disabled="form.selectedProducts.length === 0"
                                @click="handleCheckout"
                                class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50 disabled:opacity-25 disabled:cursor-not-allowed"
                            >
                                Checkout
                            </button>
                        </div>
                    </section>
                </form>
            </div>
    </Main>
</template>

<script setup>
import { ChevronDownIcon } from '@heroicons/vue/16/solid'
import { CheckIcon, ClockIcon, QuestionMarkCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid'
import Main from "@/Pages/Main.vue";
import { useForm } from "@/Composables/useForm.vue";
import {onMounted, ref} from "vue";
import NotificationSimple from "@/Components/NotificationSimple.vue";
const { flashKey, flashMessage, form, totals, removeProduct, updateQuantity, clearForm, fetchTotals } = useForm();
import { router } from '@inertiajs/vue3'

    // Methods
    const handleCheckout = () => {
        axios.post(route('order.create'), {
            selectedProducts: form.value.selectedProducts
        })
            .then(response => {
                form.value.orderData = response.data.data;
                router.visit(route('payment-success'));
            })
            .catch(error => {
                alert(error.response?.data?.message || "An error occurred during checkout.");
            });
    };

    // Lifecycle hooks
    onMounted(() => {
        fetchTotals();
    });


</script>

<style scoped>
    select {
        appearance: none !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: white;
        border: 1px solid #ccc;
    }
</style>
