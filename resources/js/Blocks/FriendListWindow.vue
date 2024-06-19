<script setup>
import ListEntryCard from '@/Components/ListEntryCard.vue';
import {router} from '@inertiajs/vue3';

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

const openChat = (chatId) => {
    router.visit(route('chats.show', chatId));
};

const createChatWithFriend = (friend) => {
    router.post(route('chats.store'), {
        participants: [friend],
    });
};
</script>

<template>
    <div class="bg-gray-300 dark:bg-gray-700 p-4">
        <h3 class="font-bold text-xl">Chats</h3>
        <template v-for="chat of chats"
                  :key="chat.id">
            <ListEntryCard :label="chat.name"
                           :selected="chat.id === props.chat?.id"
                           @click="openChat(chat.id)"/>
        </template>
        <h3 class="font-bold text-xl mt-8">Friends</h3>
        <template v-for="friend of friends"
                  :key="friend.id">
            <ListEntryCard :label="friend.name"
                           @click="createChatWithFriend(friend)"/>
        </template>
    </div>
</template>
