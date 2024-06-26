<script setup>
import Avatar from '@/Components/Avatar.vue';
import ListEntryCard from '@/Components/ListEntryCard.vue';
import {usersOnline} from '@/Stores/users-online.js';
import {Link, router} from '@inertiajs/vue3';

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

const chats = props.chats.map((chat) => {
    return {
        ...chat,
        ping: false,
    };
});

const openChat = (chatId) => {
    router.visit(route('chats.show', chatId));
};

const createChatWithFriend = (friend) => {
    router.post(route('chats.store'), {
        participants: [friend],
        name: friend.name,
    });
};
</script>

<template>
    <div class="bg-gray-300 dark:bg-gray-700 p-4">
        <h3 class="font-bold text-xl flex items-center justify-between">
            Chats
            <Link :href="route('chats.index')"
                  as="button"
                  type="button"
                  title="Create a new chat"
                  class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                +
            </Link>
        </h3>
        <template v-for="chat of chats"
                  :key="chat.id">
            <ListEntryCard :label="chat.name"
                           :selected="chat.id === props.chat?.id"
                           :ping="chat.ping"
                           @click="openChat(chat.id)"/>
            <!--            <ChatOverviewCard :chat="chat" :avatar="chat.title"/>-->
        </template>
        <h3 class="font-bold text-xl mt-8">Friends</h3>
        <template v-for="friend of props.friends"
                  :key="friend.id">
            <ListEntryCard :label="friend.name"
                           @click="createChatWithFriend(friend)">
                <template #icon>
                    <Avatar :name="friend.name" :status="usersOnline.isOnline(friend.id) ? 'online' : 'offline'"/>
                </template>
            </ListEntryCard>
        </template>
    </div>
</template>
