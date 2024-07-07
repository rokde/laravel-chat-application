<script setup>
import Avatar from '@/Components/Avatar.vue';
import ChatterLine from '@/Components/ChatterLine.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useTypingEvent} from '@/lib/composables';
import {ScrollArea} from '@/shadcn/ui/scroll-area';
import {chatMessages} from '@/Stores/chat-messages';
import {ArrowUturnLeftIcon, PaperAirplaneIcon} from '@heroicons/vue/24/solid';
import {Link, useForm, usePage} from '@inertiajs/vue3';
import {nextTick, onMounted, onUnmounted, ref} from 'vue';

const props = defineProps({
    chat: {
        type: Object,
        required: true,
    },
});

chatMessages.setMessages(props.chat.id, props.chat.messages);
const messages = ref(props.chat.messages);

const participantByUserId = (userId) => {
    return props.chat.participants.filter((participant) => participant.user_id === userId)[0] ?? null
};

const messageInput = ref(null);
const form = useForm({
    message: null,
});

const send = () => {
    form.post(route('chats.messages.store', [props.chat.id]), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => form.reset(),
        onError: () => {
            messageInput.value.focus();
        },
    });
}

const page = usePage();
// const friendsTyping: Ref<{ id: number; name: string }[]> = ref<{ id: number; name: string }[]>([]);
const friendsTyping = ref([]);
const messageBottom = ref(null);

onMounted(() => {
    messageBottom.value.scrollIntoView();

    messageInput.value.focus();
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

const sendTypingEvent = useTypingEvent(`chat.${props.chat.id}`, {
    id: page.props.auth.user.id,
    name: page.props.auth.user.name,
}, friendsTyping);
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
        <span class="block h-6 text-slate-700 italic">
            <span v-if="friendsTyping.length"
                  class="animate-pulse">
                {{ friendsTyping.map(friend => friend.name).join(', ') }} is typing...
            </span>
        </span>
        <form class="w-full flex items-center gap-2" @submit.prevent="send">
            <div class="flex-grow col-span-6 sm:col-span-4">
                <TextInput
                    id="message"
                    v-model="form.message"
                    ref="messageInput"
                    type="text"
                    @keydown="sendTypingEvent"
                    placeholder="Input message..."
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.message" class="mt-2"/>
            </div>
            <div>
                <PrimaryButton :disabled="form.processing">
                    <PaperAirplaneIcon class="w-5 h-5 text-indigo-500"/>
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>
