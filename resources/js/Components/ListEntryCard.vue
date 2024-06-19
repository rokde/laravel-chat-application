<script setup>
const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    selected: {
        type: Boolean,
        default: false,
    }
});

const emits = defineEmits(['click']);

</script>

<template>
    <button type="button"
            class="w-full px-3 py-2 flex hover:bg-gray-200 dark:hover:bg-gray-600 text-left"
            :class="{'bg-gray-400 dark:bg-gray-500': selected}"
            @click="$emit('click')">
        <span v-if="$slots.icon"
              class="w-6 h-6"></span>
        <span>{{ label }}</span>
    </button>
</template>
