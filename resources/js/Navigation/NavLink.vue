<script setup>
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    icon: {
        type: Function,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    notifications: {
        type: Number,
        default: 0,
    },
    active: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <div class="mb-0 md:mb-6">
        <Link
            :href="href"
            class="group relative focus:outline-none"
            :title="props.title"
            :aria-label="
                props.notifications
                  ? props.title + ' ' + props.notifications + ' new notifications'
                  : props.title
            ">
            <!--icon-->
            <component
                :is="props.icon"
                class="w-7 h-6 group-focus:text-indigo-400 hover:text-indigo-400 active:text-indigo-400 active:scale-110 dark:text-gray-500 transition ease-out duration-200"
                :class="(props.active) ? ['text-indigo-400', 'dark:text-indigo-400'] : [' text-gray-300']"
            />

            <!--notification pill-->
            <span
                v-if="props.notifications > 0"
                class="absolute right-0 top-3 w-5 h-5 flex items-center justify-center outline-none bg-indigo-400 text-xs text-white border border-white dark:border-gray-800 rounded-full transition duration-500"
            >
                {{ props.notifications }}
            </span>
        </Link>
    </div>
</template>
