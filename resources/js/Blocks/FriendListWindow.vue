<script setup>
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
    <div class="bg-gray-300 dark:bg-gray-700 p-4">
        <h3 class="font-bold text-xl">Chats</h3>
        <div v-for="chat of chats"
             :key="chat.id">
            {{ chat.name }}
        </div>
        <h3 class="font-bold text-xl mt-8">Friends</h3>
        <div v-for="friend of friends"
             :key="friend.id">
            {{ friend.name }}
        </div>
    </div>
</template>
