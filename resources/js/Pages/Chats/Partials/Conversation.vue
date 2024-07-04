<script lang="ts" setup>
import Avatar from '@/Components/Avatar.vue';
import Typography from '@/Components/UI/data-display/Typography.vue';
import {humanReadableTimeDiff} from '@/helpers.js';
import {usersOnline} from '@/Stores/users-online.js';
import {usePage} from '@inertiajs/vue3';
import {computed} from 'vue';
import type {ConversationProps} from '@/types';

const props = withDefaults(defineProps<ConversationProps>(), {
    selected: false,
})

const isDirectConversation = computed(() => {
    return props.chat.participant_count === 2;
});
const conversationPartner = computed(() => {
    return props.chat.participants?.filter(p => p.user_id !== usePage().props.auth.user.id)[0] || {name: props.chat.name};
});
const multipleConversationPartner = computed(() => {
    return props.chat.participants?.filter(p => p.user_id !== usePage().props.auth.user.id)
        .map(p => p.name[0])
        .join(' | ');
});

defineEmits(['selected']);
</script>

<template>
    <div class="select-none">
        <button @click="$emit('selected', props.chat)"
                type="button"
                class="p-2 flex w-full items-center gap-2"
                :class="{
                    'bg-white dark:bg-gray-900': props.selected,
                }">
            <template v-if="isDirectConversation">
                <Avatar :name="conversationPartner.name" class="shrink-0"
                        :status="usersOnline.isOnline(conversationPartner.user_id) ? 'online' : 'offline'"/>
                {{ conversationPartner.user_id }}
            </template>
            <template v-else>
                <Avatar :name="multipleConversationPartner" class="shrink-0"/>
            </template>
            <div class="grow flex flex-col max-w-full text-left">
                <div class="flex items-start justify-between">
                    <span v-if="isDirectConversation"
                          class="font-bold">{{ conversationPartner.name }}</span>
                    <span v-else
                          class="font-bold">{{ props.chat.name }}</span>
                    <span v-if="props.chat.latestMessage?.timestamp">
                        {{ humanReadableTimeDiff(props.chat.latestMessage?.timestamp) }}
                    </span>
                </div>
                <Typography variant="body-5">{{ props.chat.latestMessage?.message }}</Typography>
            </div>
        </button>
    </div>
</template>
