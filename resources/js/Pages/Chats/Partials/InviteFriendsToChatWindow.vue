<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {computed, ref} from 'vue';

const props = defineProps({
    friends: {
        type: Array,
        required: true,
    },
});

const checkableFriends = ref(props.friends.map((friend) => {
    return {...friend, checked: false};
}));

const isChecked = computed(() => checkableFriends.value.some((friend) => friend.checked))

const form = useForm({
    participants: [],
    name: null,
});

const send = () => {
    form.participants = checkableFriends.value.filter((friend) => friend.checked).map((friend) => {
        return {id: friend.id, name: friend.name};
    });

    form.post(route('chats.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <div class="bg-gray-200 dark:bg-gray-400 p-4">
        <div>Start a chat with your friends</div>
        <div>
            <form @submit.prevent="send" class="grid grid-cols-6">
                <div class="col-span-6 sm:col-span-4">
                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        placeholder="Topic of your chat..."
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.name" class="mt-2"/>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <div class="flex flex-col my-4">
                        <template v-for="participant of checkableFriends"
                                  :key="participant.id"
                        >
                            <label class="hover:bg-gray-100">
                                <input type="checkbox"
                                       v-model="participant.checked">
                                {{ participant.name }}
                            </label>
                        </template>
                        <InputError :message="form.errors.participants" class="mt-2"/>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <PrimaryButton :disabled="!isChecked || form.processing">
                        Create
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
