<script setup lang="ts">
import {MicrophoneIcon} from '@heroicons/vue/24/outline';
import {StopCircleIcon} from '@heroicons/vue/24/solid';
import {ref} from "vue";

const recording = ref(false);
const mediaRecorder = ref(null);

const onMicrophoneClicked = async () => {
    if (recording.value) {
        recording.value = false;
        if (mediaRecorder.value) {
            mediaRecorder.value.stop();
            mediaRecorder.value = null;
        }
        return;
    }

    recording.value = true;
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            audio: true,
        });
        const newMediaRecorder = new MediaRecorder(stream);
        const chunks = [];

        newMediaRecorder.addEventListener('dataavailable', (event) => {
            chunks.push(event.data);
        });
        newMediaRecorder.addEventListener('stop', () => {
            let audioBlob = new Blob(chunks, {
                type: 'audio/ogg; codecs=opus',
            });
            let audioFile = new File([audioBlob], 'recorded_audio.ogg', {
                type: 'audio/ogg; codecs=opus',
            });

            emits('recorded', audioFile);
        });

        newMediaRecorder.start();
        mediaRecorder.value = newMediaRecorder;
    } catch (error) {
        console.error(error);
        recording.value = false;
    }
}

const emits = defineEmits<{
    (e: 'recorded', blob: any): void;
}>()
</script>

<template>
    <button @click="onMicrophoneClicked"
            type="button"
            class="text-gray-400 hover:text-gray-300 relative">
        <MicrophoneIcon v-if="!recording" class="w-6"/>
        <StopCircleIcon v-else class="w-6 text-red-600 animate-pulse"/>
    </button>
</template>
