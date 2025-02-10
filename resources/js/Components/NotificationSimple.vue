<template>
    <!-- Global notification live region, render this permanently at the end of the document -->
    <div aria-live="assertive"
         class="z-10 pointer-events-none fixed flex sm:items-center px-4 py-6 sm:p-6 inset-0 lg:items-center">
        <div class="flex w-full flex-col items-center space-y-4">
            <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
            <transition enter-active-class="transform ease-out duration-300 transition" enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-if="localFlashMessage || localFlashError"
                     class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                     :class="{
                    'bg-orange-500' : localFlashMessage,
                    'bg-red-700' : localFlashError,
                }"
                >
                    <div class="p-4">
                        <div class="flex items-start">
                            <div v-if="localFlashMessage" class="flex-shrink-0">
                                <CheckCircleIcon class="h-6 w-6 text-green-400" aria-hidden="true" />
                            </div>
                            <div v-else-if="localFlashError" class="flex-shrink-0">
                                <XCircleIcon class="h-6 w-6 text-white" aria-hidden="true" />
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-medium text-white">{{ localFlashMessage ? localFlashMessage : localFlashError }}</p>
                            </div>
                            <div class="ml-4 flex flex-shrink-0">
                                <button type="button" @click="localFlashMessage = null; localFlashError = null;" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                    <span class="sr-only">Close</span>
                                    <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script setup>
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/24/outline'
import { XMarkIcon } from '@heroicons/vue/20/solid'
import {nextTick, ref, watch} from "vue";

    // Define props
    const props = defineProps({
        flashMessage: String,
        flashError: String,
        flashKey: String,
    });

    // Create a local state for flashMessage
    const localFlashMessage = ref(props.flashMessage);
    const localFlashError = ref(props.flashError);

    // Watch for changes in flashMessage prop and update the local state
    watch(() => props.flashKey, () => {
        localFlashMessage.value = props.flashMessage;
        localFlashError.value = props.flashError;

        // Reset the timeout whenever the flashKey changes (new message is triggered)
        nextTick(() => {
            setTimeout(() => {
                localFlashMessage.value = null;
                localFlashError.value = null;
            }, 8000);
        });
    },
        { immediate: true }
    );
</script>
