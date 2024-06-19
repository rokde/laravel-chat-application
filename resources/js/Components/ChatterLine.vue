<script setup>
import dayjs from 'dayjs';
import localizedFormat from 'dayjs/plugin/localizedFormat';
import relativeTime from 'dayjs/plugin/relativeTime';
import 'dayjs/locale/de';

const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    timestamp: {
        type: String,
        required: true,
    },
});

dayjs.extend(relativeTime);
dayjs.extend(localizedFormat);
dayjs.locale('de');
</script>

<template>
    <div class="flex gap-4 items-baseline">
        <span class="font-bold">{{ props.label }}</span>
        <span :title="dayjs(props.timestamp).format('L LT')"
              class="text-xs text-gray-300">{{ dayjs(props.timestamp).fromNow() }}</span>
    </div>
</template>
