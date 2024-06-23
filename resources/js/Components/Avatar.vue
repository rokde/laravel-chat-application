<script setup>
import {computed} from 'vue';

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    imageUrl: {
        type: [String, null],
        default: null,
    },
    status: {
        type: [String, null],
        default: null,
    },
    size: {
        type: Number,
        default: 6,
    },
});

const initials = computed(() => {
    return props.name.split(' ').map(c => c[0]).join('');
});

const colors = {
    online: 'bg-emerald-500',
    offline: 'bg-gray-300',
    away: 'bg-amber-500',
    busy: 'bg-red-600',
};

const classesBasedOnSize = computed(() => {
    const definitions = {
        6: {
            container: `w-${props.size} h-${props.size}`,
            image: `rounded-full w-${props.size} h-${props.size}`,
            initials: 'text-xs font-normal',
            statusOnline: `left-4 w-2 h-2 border ${colors.online}`,
            statusOffline: `left-4 w-2 h-2 border ${colors.offline}`,
            statusAway: `left-4 w-2 h-2 border ${colors.away}`,
            statusBusy: `left-4 w-2 h-2 border ${colors.busy}`,
        },
        8: {
            container: `w-${props.size} h-${props.size}`,
            image: `rounded-full w-${props.size} h-${props.size}`,
            initials: 'text-sm font-medium',
            statusOnline: `left-5 w-3 h-3 border ${colors.online}`,
            statusOffline: `left-5 w-3 h-3 border ${colors.offline}`,
            statusAway: `left-5 w-3 h-3 border ${colors.away}`,
            statusBusy: `left-5 w-3 h-3 border ${colors.busy}`,
        },
        10: {
            container: `w-${props.size} h-${props.size}`,
            image: `rounded-full w-${props.size} h-${props.size}`,
            initials: 'text-base font-medium',
            statusOnline: `left-7 w-3.5 h-3.5 border-2 ${colors.online}`,
            statusOffline: `left-7 w-3.5 h-3.5 border-2 ${colors.offline}`,
            statusAway: `left-7 w-3.5 h-3.5 border-2 ${colors.away}`,
            statusBusy: `left-7 w-3.5 h-3.5 border-2 ${colors.busy}`,
        },
    };

    return definitions.hasOwnProperty(props.size) ? definitions[props.size] : definitions[10];
});
</script>

<template>
    <div class="relative bg-gray-100 flex justify-center items-center rounded-full"
         :class="classesBasedOnSize.container">
        <img v-if="props.imageUrl"
             :class="classesBasedOnSize.container"
             :src="imageUrl"
             alt="">
        <span v-else
              class="text-gray-600"
              :class="classesBasedOnSize.initials">
            {{ initials }}
        </span>
        <span v-if="props.status === 'online'"
              class="absolute bottom-0 border-white rounded-full"
              :class="classesBasedOnSize.statusOnline"></span>
        <span v-if="props.status === 'offline'"
              class="absolute bottom-0 border-white rounded-full"
              :class="classesBasedOnSize.statusOffline"></span>
        <span v-if="props.status === 'away'"
              class="absolute bottom-0 border-white rounded-full"
              :class="classesBasedOnSize.statusAway"></span>
        <span v-if="props.status === 'busy'"
              class="absolute bottom-0 border-white rounded-full"
              :class="classesBasedOnSize.statusBusy"></span>
    </div>
</template>
