<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
import {route} from 'ziggy-js';
import ThemeSwitcher from "@/Components/ThemeSwitcher.vue";
import {computed} from "vue";
import {navigation} from "@/Stores/navigation";

const navigationItems = computed(() => {
    return navigation;
})
</script>

<template>
    <nav class="flex flex-col items-center gap-4 px-2 py-4">
        <Link
            :href="route('dashboard')"
            class="group flex h-9 w-9 shrink-0 items-center justify-center gap-2 rounded-full text-lg font-semibold text-primary-foreground md:h-8 md:w-8 md:text-base dark:bg-primary"
        >
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6 transition-all group-hover:scale-110 stroke-current"
                 viewBox="0 0 576 576">
                <path
                    d="M265.792 1.574c-56.1 8.5-103.6 42.4-127.9 91.2-9.5 19-13 34.7-13 57.2.1 18 1.8 27.2 8.3 44.6 2.3 5.9 4.1 11.1 4.1 11.5 0 .4-4.4 6.5-9.7 13.5-21.3 28.3-37.6 55.1-54.7 89.9-21.6 43.8-43.3 95.9-44.4 106.8-.9 9 5.6 19.9 14.3 23.8 5.3 2.4 14.7 2.4 20.1 0 4.6-2.1 8.7-6.7 23.7-26.8 5.9-7.8 11-14.4 11.6-14.7.5-.3 1.2 2.4 1.6 6 2.2 20.4 10 46.7 19.6 66.2 26.7 53.8 72.8 89.3 132.9 102.3 13.7 3 47.4 3.8 62.2 1.5 62.4-9.8 115.3-47.9 142.9-102.9 10.1-20.1 16.8-41.9 19.1-62.6 1.5-13.4-.4-14.4 18.7 10.5 15.7 20.5 18.3 22.6 28 22.5 14 0 24.3-10 24.4-23.6 0-8.6-6.4-25.5-29.9-79-7.7-17.7-30.3-61.9-38.8-76-10-16.6-20.6-32.1-31.4-45.9l-8.5-10.9 1.7-4.6c9.1-23.5 11-33.4 11-55.1 0-14.7-.2-17.6-2.6-26.6-4.9-18.5-13.4-36.5-24.4-51.5-8.9-12.2-28.3-30.7-41.4-39.6-13.4-9.1-34.6-18.9-51.4-23.8-18.2-5.2-46.5-6.9-66.1-3.9zm-32.3 72c11.3 2.7 21.7 9.8 29.3 19.9 4.4 6 6.1 9.6 8.9 19.5 2.2 7.8 4.8 11.4 9.8 13.9 5.4 2.6 8.1 2.6 13.4.2 5.3-2.4 8.1-6.4 10.5-15.3 5.2-18.6 18.2-32.4 35.7-37.8 13.6-4.2 32.8-2 44.8 5.1 7.9 4.7 19.1 16.1 24.2 24.8 21.4 36.2 10.6 88.3-23.4 113.6-10.8 8-14.2 11.3-15.5 15.2-2.1 6.6-.8 8.6 17.6 26.8 13.7 13.5 18.7 19.2 24.4 27.9 24.8 37.5 34.8 77.5 29.6 119.2-1.8 14.9-4.3 24.7-9.5 37.6-14.5 36.2-40.1 64.3-75.5 82.9-29.6 15.5-67.4 20.5-102.5 13.3-29-5.9-57.1-22.2-80.5-46.5-11.6-12.2-19.5-23.4-26.4-38-16.2-33.8-19.8-67-11.6-106.1 5-24 17-50.6 31.2-69.1 6.6-8.5 20.6-23 28.1-28.9 6.3-5.1 10.1-10.7 10.2-15.2 0-5-4.2-10.6-12.4-16.5-21.9-15.9-34.7-37.1-37.6-62.7-1.9-16.2 1.1-34.7 7.7-47.9 14.9-30 40.2-43 69.5-35.9z"/>
                <path
                    d="M205.992 124.474c-7.9 5.5-9.7 15.3-4.2 23.6 7.1 10.9 22.4 9.7 28.3-2.2 7.3-14.7-10.5-30.6-24.1-21.4zm146.2-.1c-7.1 4.9-9.1 15.2-4.4 23.3 3.1 5.2 7.5 7.7 13.6 7.6 13.9-.2 21.3-14.9 13.3-26.4-4.9-7.1-15.5-9.2-22.5-4.5zm-97.3 27.5c-8.5 1.2-12.1 8.5-7.7 15.6 3.7 6 34.2 40.1 37.4 41.8 5.8 3 8.1 1.4 23.9-17 22.8-26.4 22.8-26.4 22.8-30.3 0-2-.7-4.6-1.6-5.9-3.4-4.8-6-5.1-39.1-5-16.9.1-33 .5-35.7.8z"/>
            </svg>
            <span class="sr-only">App</span>
        </Link>

        <Link
            v-for="item of navigationItems"
            :key="item.title"
            :title="item.title"
            :href="item.url"
            class="flex h-9 w-9 items-center justify-center rounded-lg text-muted-foreground transition-colors hover:text-foreground md:h-8 md:w-8"
        >
            <component :is="item.icon"
                       class="h-5 w-5"
                       :class="{
                        'text-primary': item.active()
                    }"/>
            <span class="sr-only">{{ item.title }}</span>
        </Link>
    </nav>
    <nav class="mt-auto flex flex-col items-center gap-4 px-2 py-4">
        <ThemeSwitcher/>
    </nav>
</template>
