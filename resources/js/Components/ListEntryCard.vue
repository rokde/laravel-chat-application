<script setup>
const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    selected: {
        type: Boolean,
        default: false,
    },
    ping: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['click']);
</script>

<template>
    <button type="button"
            class="w-full px-3 py-2 flex hover:bg-gray-200 dark:hover:bg-gray-600 text-left relative gap-2"
            :class="{
                'bg-gray-400 dark:bg-gray-500': props.selected,
                'relative': props.ping && !props.selected,
            }"
            @click="$emit('click')">
        <span v-if="$slots.icon"
              class="w-6 h-6"><slot name="icon"/></span>
        <span :class="{'font-bold': props.ping && !props.selected}">{{ label }}</span>

        <span v-if="props.ping && !props.selected"
              class="flex absolute h-3 w-3 top-3 right-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
        </span>
    </button>
</template>
