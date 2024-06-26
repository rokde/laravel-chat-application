<script setup>
import Conversation from '@/Pages/Chats/Partials/Conversation.vue';

const props = defineProps({
    conversations: {
        type: Array,
        default: () => [],
    },
    selected: {
        type: [Object, null],
        default: null,
    },
})
defineEmits(['selected']);
</script>

<template>
    <div class="">
        <Conversation v-for="conversation of props.conversations"
                      :chat="conversation"
                      :key="conversation.id"
                      :selected="conversation.id === props.selected?.id"
                      @selected="$emit('selected', $event)"/>
    </div>
</template>
