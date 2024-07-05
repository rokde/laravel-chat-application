<script setup>
import {MoonIcon, SunIcon} from '@heroicons/vue/24/outline';
import {useDark, useToggle} from '@vueuse/core';

const isDark = useDark();
const toggleDark = useToggle(isDark);
</script>

<template>
    <button type="button"
            class="dark:bg-transparent dark:text-gray-500 dark:hover:text-yellow-100"
            @click="toggleDark()">
        <MoonIcon v-if="isDark" class="w-6 h-6"/>
        <SunIcon v-else class="w-6 h-6"/>
    </button>
</template>
