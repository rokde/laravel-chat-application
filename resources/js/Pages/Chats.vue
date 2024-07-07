<script setup lang="ts">
import ChatWindow from '@/Pages/Chats/Partials/ChatWindow.vue';
import Typography from '@/Components/UI/data-display/Typography.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ConversationsList from '@/Pages/Chats/Partials/ConversationsList.vue';
import {ChatBubbleOvalLeftIcon} from "@heroicons/vue/24/solid";
import {router} from '@inertiajs/vue3';
import {route} from 'ziggy-js';
import {computed, ref} from "vue";
import {useWindowHeight} from "@/lib/composables";
import {ScrollArea} from "@/shadcn/ui/scroll-area";
import InviteFriendsToChatWindow from "@/Pages/Chats/Partials/InviteFriendsToChatWindow.vue";

const props = withDefaults(defineProps<{
    chats: object[];
    chat?: object;
    friends: { id: number; name: string; }[];
}>(), {
    chats: () => [],
});

const breadcrumb = computed(() => {
    const items = [];
    items.push({label: 'Chats', url: route('chats.index')});

    if (props.chat) {
        items.push({label: props.chat?.name})
    }

    return items;
});

const openConversation = (conversation: any) => {
    router.get(route('chats.show', conversation));
}

const contentHeight = ref<number>(0);
const content = ref<HTMLDivElement>();

useWindowHeight((height) => {
    contentHeight.value = height.value - (content.value?.offsetTop ?? 0) - 16;
})
</script>

<template>
    <AppLayout title="Chats"
               :breadcrumb="breadcrumb"
               :with-search="props.chat !== undefined">

        <div ref="content" class="grid grid-cols-12" :style="{height: `${contentHeight}px`}">
            <ScrollArea class="lg:block lg:col-span-4 xl:col-span-3 px-4"
                        :class="{
                            'col-span-12': !props.chat,
                            'hidden': props.chat,
                        }">
                <ConversationsList :conversations="props.chats"
                                   :selected="props.chat"
                                   @selected="openConversation($event)"/>
            </ScrollArea>
            <div class="lg:col-span-8 xl:col-span-9"
                 :class="{
                    'hidden': !props.chat,
                    'col-span-12': props.chat,
                 }">
                <div class="flex flex-col h-full bg-white col-span-12" :style="{height: `${contentHeight}px`}">
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

                            <InviteFriendsToChatWindow :friends="props.friends"/>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
