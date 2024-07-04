import {onMounted, onUnmounted} from 'vue';

export function useKeyupEvent(handler): void {
    onMounted(() => document.addEventListener("keyup", handler));
    onUnmounted(() => document.removeEventListener("keyup", handler));
}
