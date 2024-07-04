<script setup>
import Avatar from '@/Components/Avatar.vue';
import {Link} from '@inertiajs/vue3';
import dayjs from 'dayjs';
import localizedFormat from 'dayjs/plugin/localizedFormat';
import relativeTime from 'dayjs/plugin/relativeTime';
import 'dayjs/locale/de';

dayjs.extend(relativeTime);
dayjs.extend(localizedFormat);
dayjs.locale('de');

const props = defineProps({
    chat: {
        type: Object,
        required: true,
    },
    users: {
        type: Array,
        default: () => [],
    },
    avatar: {
        type: String,
        default: null,
    },
    imageUrl: {
        type: String,
        default: null,
    },
    unread: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <Link :href="route('chats.show', [props.chat.id])"
          class="flex items-center justify-center"
          :class="{'font-bold': props.unread}">
        <Avatar :name="props.avatar"
                :imageUrl="props.imageUrl"/>

        <div class="flex-1">
            <div class="flex items-center justify-between">
                <span>{{ props.chat.name }}</span>
                <span>{{ dayjs(props.chat.latestMessage.timestamp).fromNow() }}</span>
            </div>
            <div>{{ props.chat.latestMessage.message }}</div>
        </div>
    </Link>
</template>

<style scoped>

</style>
