<script setup>
import ChatterLine from '@/Components/ChatterLine.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useTypingEvent} from '@/lib/composables';
import {PaperAirplaneIcon} from '@heroicons/vue/24/solid';
import {useForm, usePage} from '@inertiajs/vue3';
import {onMounted, onUnmounted, ref} from 'vue';

const props = defineProps({
    chat: {
        type: Object,
        required: true,
    },
});

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
const friendsTypingTimer = ref({});

onMounted(() => {
    messageInput.value.focus();
    Echo.private(`App.Models.User.${page.props.auth.user.id}`)
        .listen('MessageSent', (event) => {
            console.log('message sent came in', event);
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
    <div class="p-4">
        <div class="flex flex-col gap-2">
            <template v-for="message of props.chat.messages"
                      :key="message.id">
                <ChatterLine :timestamp="message.timestamp"
                             :label="participantByUserId(message.user_id)?.name ?? 'Unknown'"/>
                <span>{{ message.message }}</span>
            </template>
        </div>
        <div class="w-full mt-8">
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
    </div>
</template>
