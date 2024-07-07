<script setup>
import Avatar from '@/Components/Avatar.vue';
import dayjs from 'dayjs';
import localizedFormat from 'dayjs/plugin/localizedFormat';
import relativeTime from 'dayjs/plugin/relativeTime';
import 'dayjs/locale/de';

const props = defineProps({
    message: {
        type: String,
        required: true,
    },
    timestamp: {
        type: String,
        required: true,
    },
    sender: {
        type: Object,
        required: true,
    },
    itsMe: {
        type: Boolean,
        default: false,
    },
    footer: {
        type: String,
        default: null,
    },
});

dayjs.extend(relativeTime);
dayjs.extend(localizedFormat);
dayjs.locale('de');
</script>

<template>
    <div class="grid grid-cols-2 gap-x-3 py-1"
         :class="{
            'chat-start place-items-start': !props.itsMe,
            'chat-end place-items-end': props.itsMe,
         }">
        <div class="row-span-2 self-end"
             :class="{
                'col-start-1': !props.itsMe,
                'col-start-2': props.itsMe,
             }">
            <Avatar :name="props.sender.name"/>
        </div>
        <div class="row-start-1 text-sm leading-5"
             :class="{
                'col-start-2': !props.itsMe,
                'col-start-1': props.itsMe,
             }">
            {{ props.sender.name }}
            <time class="text-sm opacity-50"
                  :title="dayjs(props.timestamp).format('L LT')">
                {{ dayjs(props.timestamp).fromNow() }}
            </time>
        </div>
        <div
            class="chat-bubble relative block w-fit py-2 px-4 rounded-lg min-w-10 min-h-10"
            :class="{
                'col-start-2 rounded-es-none bg-primary-foreground text-secondary-foreground': !props.itsMe,
                'col-start-1 rounded-ee-none bg-secondary-foreground text-primary-foreground': props.itsMe,
             }">
            {{ props.message }}
        </div>
        <div class="row-start-3 opacity-50 text-xs leading-6 italic"
             :class="{
                'col-start-2': !props.itsMe,
                'col-start-1': props.itsMe,
             }">{{ footer }}
        </div>
    </div>
</template>

<style>
/**
 * Taken from https://daisyui.com/components/chat/
 */
.chat-start {
    grid-template-columns: auto 1fr;
}

.chat-end {
    grid-template-columns: 1fr auto;
}

.chat-bubble {
    max-width: 90%;
}

.chat-start .chat-bubble:before {
    -webkit-mask-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMycgaGVpZ2h0PSczJyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnPjxwYXRoIGZpbGw9J2JsYWNrJyBkPSdtIDAgMyBMIDMgMyBMIDMgMCBDIDMgMSAxIDMgMCAzJy8+PC9zdmc+);
    mask-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMycgaGVpZ2h0PSczJyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnPjxwYXRoIGZpbGw9J2JsYWNrJyBkPSdtIDAgMyBMIDMgMyBMIDMgMCBDIDMgMSAxIDMgMCAzJy8+PC9zdmc+);
    inset-inline-start: -.749rem;
}

.chat-end .chat-bubble:before {
    -webkit-mask-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMycgaGVpZ2h0PSczJyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnPjxwYXRoIGZpbGw9J2JsYWNrJyBkPSdtIDAgMyBMIDEgMyBMIDMgMyBDIDIgMyAwIDEgMCAwJy8+PC9zdmc+);
    mask-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMycgaGVpZ2h0PSczJyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnPjxwYXRoIGZpbGw9J2JsYWNrJyBkPSdtIDAgMyBMIDEgMyBMIDMgMyBDIDIgMyAwIDEgMCAwJy8+PC9zdmc+);
    inset-inline-start: 99.9%;
}

.chat-bubble:before {
    position: absolute;
    bottom: 0;
    height: .75rem;
    width: .75rem;
    background-color: inherit;
    content: "";
    -webkit-mask-size: contain;
    mask-size: contain;
    -webkit-mask-repeat: no-repeat;
    mask-repeat: no-repeat;
    -webkit-mask-position: center;
    mask-position: center;
}
</style>
