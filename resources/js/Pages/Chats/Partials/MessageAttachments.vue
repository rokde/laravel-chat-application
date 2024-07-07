<script setup lang="ts">

interface Attachment {
    id: number;
    chat_message_id: number;
    mime: string;
    type: string;
    name: string;
    size: number;
    timestamp: string;
    url: string;
}

interface AttachmentProps {
    attachments: Attachment[];
}

const props = defineProps<AttachmentProps>();

defineEmits<{
    (e: 'click', attachment: Attachment): void;
}>()
</script>

<template>
    <div>
        {{ props.attachments.length }} Attachments:
        <ol class="list-inside list-decimal">
            <li v-for="attachment of props.attachments"
                :key="attachment.id">
                <a :href="attachment.url" download>{{ attachment.name }} | {{ attachment.size }} bytes</a>

                <div v-if="attachment.mime === 'audio/ogg'">
                    <audio controls>
                        <source :src="attachment.url" :type="attachment.mime"/>
                    </audio>
                </div>
            </li>
        </ol>
    </div>
</template>

<style scoped>

</style>
