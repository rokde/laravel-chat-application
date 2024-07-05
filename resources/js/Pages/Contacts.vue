<script setup>
import Avatar from '@/Components/Avatar.vue';
import TextInput from '@/Components/TextInput.vue';
import ChatLayout from '@/Layouts/ChatLayout.vue';
import {usersOnline} from '@/Stores/users-online.js';
import {MagnifyingGlassIcon, UserPlusIcon} from '@heroicons/vue/24/solid';
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    friends: {
        type: Array,
        default: () => [],
    },
    contact: {
        type: [Object, null],
        default: null,
    },
});
</script>

<template>
    <ChatLayout title="Chats">
        <template #sidebarHeader>
            <p class="text-black opacity-60 dark:text-white text-xl leading-4 tracking-[.01rem] outline-none"
               tabindex="0">Contacts</p>
            <div>
                <button
                    class="group flex justify-center items-center outline-none rounded-full focus:outline-none transition-all duration-200 focus:bg-gray-50 hover:bg-gray-50 dark:hover:bg-gray-700 dark:focus:bg-gray-600 w-7 h-7"
                    aria-label="compose conversation" title="compose conversation">
                    <UserPlusIcon class="w-[1.25rem] h-[1.25rem] text-indigo-300 hover:text-indigo-400"/>
                </button>
            </div>
        </template>

        <template #sidebarTop>
            <div class="relative">
                <i class="absolute left-0 top-[.6563rem] ml-2 text-center pointer-events-none">
                    <MagnifyingGlassIcon
                        class="w-5 h-5 stroke-2 text-black opacity-40 dark:text-white dark:opacity-70"/>
                </i>
                <text-input class="w-full pl-8" placeholder="Search..."/>
            </div>
        </template>

        <template #sidebarContent>
            <div class="flex flex-col">
                <template v-for="friend of props.friends"
                          :key="friend.id">
                    <Link :href="route('contacts.show', [friend])"
                          class="flex items-center gap-4 hover:bg-gray-700 p-4">
                        <Avatar :name="friend.name"
                                :status="usersOnline.isOnline(friend.id) ? 'online' : 'offline'"/>
                        {{ friend.name }}
                    </Link>
                </template>
            </div>
        </template>

        <div>
            <div v-if="contact">
                <Avatar :name="contact.name"
                        :status="usersOnline.isOnline(contact.id) ? 'online' : 'offline'"/>
                {{ contact.name }}<br>
                {{ contact.email }}
            </div>
        </div>

    </ChatLayout>
</template>

<style scoped>

</style>
