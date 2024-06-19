<script setup>
import ChatterLine from '@/Components/ChatterLine.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {onMounted, ref} from 'vue';

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
        onSuccess: () => form.reset(),
        onError: () => {
            messageInput.value.focus();
        },
    });
}

onMounted(() => {
    messageInput.value.focus();
})
</script>

<template>
    <div class="bg-gray-200 dark:bg-gray-400 p-4">
        <div class="flex flex-col gap-2">
            <template v-for="message of props.chat.messages"
                      :key="message.id">
                <ChatterLine :timestamp="message.timestamp"
                             :label="participantByUserId(message.user_id)?.name ?? 'Unknown'"/>
                <span>{{ message.message }}</span>
            </template>
        </div>
        <div class="w-full mt-8">
            <form class="w-full flex items-center gap-2" @submit.prevent="send">
                <div class="flex-grow col-span-6 sm:col-span-4">
                    <TextInput
                        id="message"
                        v-model="form.message"
                        ref="messageInput"
                        type="text"
                        placeholder="Input message..."
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.message" class="mt-2"/>
                </div>
                <div>
                    <PrimaryButton :disabled="form.processing">
                        Submit
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
