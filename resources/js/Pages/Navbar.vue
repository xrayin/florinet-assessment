<template>
    <Disclosure as="header" class="" v-slot="{ open }">
        <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:divide-y lg:divide-orange-400 lg:px-8">
            <div class="relative flex h-16 justify-between">
                <div class="relative z-10 flex px-2 lg:px-0">
                    <div class="flex shrink-0 items-center">
                        <Link :href="route('home')">
                            <svg viewBox="0 0 152 152" fill="none" xmlns="http://www.w3.org/2000/svg" class="block h-9 w-auto">
                                <path d="m65.5 31.4-4.2 4.2L36.8 11c-5.8 11.7-3.9 26.2 5.8 36 1.2 1.2 2.5 2.3 3.9 3.3C58.7 59 75.7 57.9 86.6 47l7.4-7.4 9.5-9.5 11.8-11.8 1-1 6.8-6.8s-.7-.3-1.8-.8c-1.4-.6-3.5-1.3-6.2-1.9-1.2-.4-2.3-.7-3.5-1-3.9-.9-7.5-1.1-10.8-.9-1.3.1-2.6.3-3.9.5-5.7 1.1-10.2 3.7-13.9 7.3l-4.2 4.2-.5.5L59.9 0c-4.7 9.7-2.8 22.3 5.6 31.4z" style="fill:#f39200"/>
                                <path d="m79.8 121.6 4.2-4.2 24.5 24.5c5.8-11.7 3.9-26.2-5.8-35.9-1.2-1.2-2.6-2.3-3.9-3.3-12.2-8.7-29.2-7.6-40.1 3.3l-7.4 7.4-9.5 9.5L30 134.7l-1 1-6.8 6.8s.6.3 1.8.8c1.4.6 3.5 1.3 6.2 1.9 1.2.4 2.3.7 3.5 1 3.9.9 7.5 1.1 10.8.9 1.3-.1 2.6-.3 3.9-.5 5.7-1.1 10.2-3.7 13.9-7.3l4.2-4.2.5-.5 18.4 18.5c4.7-9.9 2.7-22.5-5.6-31.5z" style="fill:#2fac66"/>
                                <path d="m31.4 83.5 4.2 4.2L11 112.1c11.7 5.8 26.2 3.9 36-5.8 1.2-1.2 2.3-2.6 3.3-3.9C59 90.2 57.9 73.2 47 62.3l-7.4-7.4-9.5-9.5-11.8-11.8-1-1-6.8-6.8s-.3.6-.8 1.8c-.6 1.4-1.3 3.5-1.9 6.2-.4 1.2-.7 2.3-1 3.5C6 41.2 5.7 44.7 6 48c.1 1.3.3 2.6.5 3.9 1.1 5.7 3.7 10.2 7.3 13.9L18 70l.5.5L0 89c9.7 4.7 22.3 2.8 31.4-5.5z" style="fill:#951b81"/>
                                <path d="m113.9 69.5-4.2-4.2 24.5-24.5c-11.7-5.8-26.2-3.9-35.9 5.8-1.2 1.2-2.3 2.5-3.3 3.9-8.7 12.2-7.6 29.2 3.3 40.1l7.4 7.4 9.5 9.5 11.8 11.8 1 1 6.8 6.8s.3-.7.8-1.8c.6-1.4 1.3-3.5 1.9-6.2.4-1.2.7-2.3 1-3.5.9-3.9 1.1-7.5.9-10.8-.1-1.3-.3-2.6-.5-3.9-1.1-5.7-3.7-10.2-7.3-13.9l-4.2-4.2-.5-.5 18.5-18.4c-9.9-4.7-22.5-2.7-31.5 5.6z" style="fill:#e71d73"/>
                            </svg>
                        </Link>
                    </div>
                </div>
                <div class="relative z-0 flex flex-1 items-center justify-center px-2 sm:absolute sm:inset-0">
                    <div class="grid w-full grid-cols-1 sm:max-w-xs">
                        <input type="search" name="search" class="col-start-1 row-start-1 block w-full rounded-md bg-white py-1.5 pl-10 pr-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Search" />
                        <MagnifyingGlassIcon class="pointer-events-none col-start-1 row-start-1 ml-3 size-5 self-center text-gray-400" aria-hidden="true" />
                    </div>
                </div>
                <div class="relative z-10 flex items-center lg:hidden">
                    <!-- Mobile menu button -->
                    <DisclosureButton class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <span class="absolute -inset-0.5" />
                        <span class="sr-only">Open menu</span>
                        <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true" />
                        <XMarkIcon v-else class="block size-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
                <div class="hidden lg:relative lg:z-10 lg:ml-4 lg:flex lg:items-center">
                    <Link
                        :href="route('login')"
                        class="text-sm/6 font-semibold text-gray-900"
                    >
                        Log in <span aria-hidden="true">&rarr;</span>
                    </Link>
                </div>
            </div>
            <nav class="hidden lg:flex lg:space-x-8 lg:py-2" aria-label="Global">
                <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-100 text-gray-900' : 'text-gray-900 hover:bg-gray-50 hover:text-gray-900', 'inline-flex items-center rounded-md px-3 py-2 text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
            </nav>
        </div>

        <DisclosurePanel as="nav" class="lg:hidden" aria-label="Global">
            <div class="space-y-1 px-2 pb-3 pt-2">
                <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-gray-100 text-gray-900' : 'text-gray-900 hover:bg-gray-50 hover:text-gray-900', 'block rounded-md px-3 py-2 text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
            </div>
            <div class="border-t border-gray-200 pb-3 pt-4">
                <div class="flex items-center px-4">
                    <Link
                        :href="route('login')"
                        class="text-sm/6 font-semibold text-gray-900"
                    >
                        Log in <span aria-hidden="true">&rarr;</span>
                    </Link>
                </div>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import {Link} from "@inertiajs/vue3";

const navigation = [
    { name: 'Home', href: route('home'), current: route().current('home') },
    { name: 'Shop', href: route('shop'), current: route().current('shop') },
]
</script>
