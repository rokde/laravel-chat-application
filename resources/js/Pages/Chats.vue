<script setup>
import ChatWindow from '@/Blocks/ChatWindow.vue';
import TextInput from '@/Components/TextInput.vue';
import Typography from '@/Components/UI/data-display/Typography.vue';
import ChatLayout from '@/Layouts/ChatLayout.vue';
import ConversationsList from '@/Pages/Chats/Partials/ConversationsList.vue';
import {ChatBubbleOvalLeftIcon} from "@heroicons/vue/24/solid";
import {MagnifyingGlassIcon} from '@heroicons/vue/24/solid/index.js';
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
});

const openConversation = (conversation) => {
    router.get(route('chats.show', conversation));
}
</script>

<template>
    <ChatLayout title="Chats">
        <template #sidebarHeader>
            <p class="text-black opacity-60 dark:text-white text-xl leading-4 tracking-[.01rem] outline-none"
               tabindex="0">Messages</p>
            <div>
                <button
                    class="group flex justify-center items-center outline-none rounded-full focus:outline-none transition-all duration-200 focus:bg-gray-50 hover:bg-gray-50 dark:hover:bg-gray-700 dark:focus:bg-gray-600 w-7 h-7"
                    aria-label="compose conversation" title="compose conversation">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" aria-hidden="true"
                         class="w-[1.25rem] h-[1.25rem] text-indigo-300 hover:text-indigo-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                    </svg>
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
            <div>
                <ConversationsList :conversations="props.chats"
                                   :selected="props.chat"
                                   @selected="openConversation($event)"/>
            </div>
        </template>


        <div>
            <ChatWindow v-if="chat"
                        :chat="chat"/>
            <template v-else>
                <div class="h-full flex flex-col justify-center items-center">
                    <div
                        class="w-10 h-10 mr-4 mb-5 flex justify-center items-center rounded-full bg-gray-50 dark:bg-gray-700 transition duration-500"
                    >
                        <ChatBubbleOvalLeftIcon
                            class="w-7 h-7 text-gray-400 dark:text-white dark:opacity-70"
                        />
                    </div>

                    <Typography variant="heading-2" class="mb-3"> No chat selected</Typography>

                    <Typography variant="body-2" class="flex">
                        Select a conversation from the conversation menu.
                    </Typography>
                </div>
            </template>
        </div>

        <!--        <FixedSidebarContainer>-->
        <!--            <template #sidebar>-->
        <!--                <FriendListWindow :chats="props.chats"-->
        <!--                                  :chat="props.chat"-->
        <!--                                  :friends="props.friends"/>-->
        <!--            </template>-->

        <!--            <div>-->
        <!--                <ChatWindow v-if="chat"-->
        <!--                            :chat="chat"/>-->
        <!--                <InviteFriendsToChatWindow v-else-->
        <!--                                           :friends="props.friends"/>-->
        <!--            </div>-->
        <!--        </FixedSidebarContainer>-->
    </ChatLayout>
</template>
