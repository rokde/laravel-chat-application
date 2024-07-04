<script setup lang="ts">
import {Head} from "@inertiajs/vue3";

const props = defineProps<{
    title: string
}>()
</script>

<template>
    <div class="w-full h-screen flex items-center justify-center px-4">
        <Head :title="props.title"/>

        <slot/>
    </div>
</template>
