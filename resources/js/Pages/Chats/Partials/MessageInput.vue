<script setup lang="ts">
import {onMounted, ref} from 'vue';
import {route} from 'ziggy-js';
import {useForm, usePage} from '@inertiajs/vue3';
import {useTypingEvent} from "@/lib/composables";
import {FaceSmileIcon, HandThumbUpIcon, PaperAirplaneIcon, PaperClipIcon, PhotoIcon} from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';
import TextareaInput from "@/Components/TextareaInput.vue";
import EmojiPicker from 'vue3-emoji-picker';
import {Popover, PopoverButton, PopoverPanel} from "@headlessui/vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import 'vue3-emoji-picker/css';

const props = defineProps<{
    chatId: number;
}>();

const page = usePage();

const fileInput = ref(null);
const photoInput = ref(null);

const messageInput = ref<typeof TextareaInput>();
const form = useForm({
    message: '',
    attachments: [],
});

const send = () => {
    if (fileInput.value) {
        form.attachments = form.attachments.concat(...fileInput.value.files);
    }
    if (photoInput.value) {
        form.attachments = form.attachments.concat(...photoInput.value.files);
    }

    form.post(route('chats.messages.store', [props.chatId]), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => form.reset(),
        onError: () => {
            messageInput.value.focus();
        },
    });
}

onMounted(() => {
    messageInput.value.focus();
})

const friendsTyping = ref([]);
const sendTypingEvent = useTypingEvent(`chat.${props.chatId}`, {
    id: page.props.auth.user.id,
    name: page.props.auth.user.name,
}, friendsTyping);

const proxyKeydownEvent = (event: KeyboardEvent) => {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        send();
    }

    sendTypingEvent();
}

const onEmojiSelected = (event: { i: string; n: string[]; r: string; t: string; u: string }) => {
    form.message += event.i;
}

const sendLike = () => {
    const bypassForm = useForm({
        message: '👍',
        attachments: [],
    });

    bypassForm.post(route('chats.messages.store', [props.chatId]), {
        preserveScroll: true,
        preserveState: false,
        onError: () => {
            messageInput.value.focus();
        },
    });
}
</script>

<template>
    <span class="block h-6 text-slate-700 italic">
        <span v-if="friendsTyping.length"
              class="animate-pulse">
            {{ friendsTyping.map(friend => friend.name).join(', ') }} is typing...
        </span>
    </span>
    <form class="flex flex-wrap items-start border-t border-slate-200 py-3" @submit.prevent="send">
        <div class="order-2 flex-1 sm:flex-none sm:order-1 p-2 space-x-2">
            <button type="button" class="text-gray-400 hover:text-gray-300 relative">
                <PaperClipIcon class="w-6"/>
                <input type="file" multiple
                       ref="fileInput"
                       class="absolute left-0 top-0 right-0 bottom-0 z-20 opacity-0 cursor-pointer">
            </button>
            <button type="button" class="text-gray-400 hover:text-gray-300 relative">
                <PhotoIcon class="w-6"/>
                <input type="file" multiple
                       ref="photoInput"
                       accept="image/*"
                       class="absolute left-0 top-0 right-0 bottom-0 z-20 opacity-0 cursor-pointer">
            </button>
        </div>

        <div class="order-1 px-3 sm:p-0 min-w-[220px] basis-full sm:basis-0 sm:order-2 flex-1 relative">
            <div class="flex">
                <TextareaInput
                    id="message"
                    v-model="form.message"
                    ref="messageInput"
                    type="text"
                    :rows.number="1"
                    @keydown="proxyKeydownEvent"
                    placeholder="Input message..."
                    class="input input-bordered w-full rounded-r-none resize-none overflow-y-auto max-h-40"
                />

                <PrimaryButton :disabled="form.processing"
                               class="btn rounded-l-none flex items-center rounded-r px-4 py-2 space-x-2 shadow">
                    <PaperAirplaneIcon class="w-6"/>
                    <span class="hidden sm:inline">Send</span>
                </PrimaryButton>
            </div>
            <InputError :message="form.errors.message" class="mt-2"/>
        </div>
        <div class="order-3 sm:order-3 p-2 flex space-x-2">
            <Popover class="relative h-6">
                <PopoverButton class="text-gray-400 hover:text-gray-300">
                    <FaceSmileIcon class="w-6"/>
                </PopoverButton>
                <PopoverPanel class="absolute z-10 right-0 bottom-full">
                    <EmojiPicker native @select="onEmojiSelected"/>
                </PopoverPanel>
            </Popover>
            <button type="button" class="text-gray-400 hover:text-gray-300" @click="sendLike">
                <HandThumbUpIcon class="w-6"/>
            </button>
        </div>
    </form>
</template>

<style scoped>

</style>
