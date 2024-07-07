<script setup>
import Avatar from '@/Components/Avatar.vue';
import ChatterLine from '@/Pages/Chats/Partials/ChatterLine.vue';
import MessageInput from '@/Pages/Chats/Partials/MessageInput.vue';
import {ScrollArea} from '@/shadcn/ui/scroll-area';
import {chatMessages} from '@/Stores/chat-messages';
import {ArrowUturnLeftIcon} from '@heroicons/vue/24/solid';
import {Link, usePage} from '@inertiajs/vue3';
import {nextTick, onMounted, onUnmounted, ref} from 'vue';

const props = defineProps({
    chat: {
        type: Object,
        required: true,
    },
});

chatMessages.setMessages(props.chat.id, props.chat.messages);

const participantByUserId = (userId) => {
    return props.chat.participants.filter((participant) => participant.user_id === userId)[0] ?? null
};

const page = usePage();
const messageBottom = ref(null);

onMounted(() => {
    messageBottom.value.scrollIntoView();

    Echo.private(`App.Models.User.${page.props.auth.user.id}`)
        .listen('MessageSent', async (event) => {
            chatMessages.addMessage(props.chat.id, event.message);

            await nextTick();
            messageBottom.value.scrollIntoView();
        })
        .error((error) => {
            console.error('error message sent', error);
        });
});

onUnmounted(() => {
    Echo.leave(`App.Models.User.${page.props.auth.user.id}`);
});
</script>

<template>
    <div class="grow-0">
        <div class="flex items-center justify-between px-4 py-2 space-x-4">
            <div class="grow-0 lg:hidden">
                <Link :href="route('chats.index')">
                    <ArrowUturnLeftIcon class="w-6 h-6"/>
                </Link>
            </div>
            <div class="grow">{{ props.chat.name }}</div>
            <div class="flex -space-x-4 justify-center">
                <template v-for="participant of chat.participants" :
                          key="participant.id">
                    <Avatar v-if="chat.participants.length > 2 || participant.user_id !== page.props.auth.user.id"
                            :name="participant.name"
                            class="ring ring-white"/>
                </template>
            </div>
        </div>
    </div>
    <ScrollArea class="flex-1 grow h-full p-4">
        <div class="flex flex-col gap-2">
            <template v-for="message of chatMessages.messages[props.chat.id]"
                      :key="message.id">
                <ChatterLine
                    :timestamp="message.timestamp ?? message.created_at"
                    :sender="participantByUserId(message.user_id)"
                    :message="message.message"
                    :its-me="message.user_id === page.props.auth.user.id"
                />
            </template>
            <div ref="messageBottom" class="w-0 h-0"></div>
        </div>
    </ScrollArea>
    <div class="grow-0">
        <MessageInput :chat-id="props.chat.id"></MessageInput>
    </div>
</template>
