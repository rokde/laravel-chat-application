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
                                  :friends="props.friends"/>
            </template>

            <div>
                <ChatWindow/>
            </div>
        </FixedSidebarContainer>
    </AppLayout>
</template>
