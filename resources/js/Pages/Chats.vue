<script setup>
import ChatWindow from '@/Blocks/ChatWindow.vue';
import FriendListWindow from '@/Blocks/FriendListWindow.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import FixedSidebarContainer from '@/Layouts/Container/FixedSidebarContainer.vue';

const props = defineProps({
    chats: {
        type: Array,
        default: () => [],
    },
    chat: {
        type: [Object, null],
        default: null,
    },
    friends: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <AppLayout title="Dashboard">
        <FixedSidebarContainer>
            <template #sidebar>
                <FriendListWindow :chats="props.chats"
                                  :chat="props.chat"
                                  :friends="props.friends"/>
            </template>

            <div>
                <ChatWindow v-if="chat"
                            :chat="chat"/>
            </div>
        </FixedSidebarContainer>
    </AppLayout>
</template>
