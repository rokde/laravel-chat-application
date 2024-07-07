import {onMounted, onUnmounted, Ref, ref} from 'vue';

export function useKeyupEvent(handler: any): void {
    onMounted(() => document.addEventListener("keyup", handler));
    onUnmounted(() => document.removeEventListener("keyup", handler));
}


/**
 * whispering typing event on a private channel
 *
 * @param {string} channelId
 * @param {id: number; name: string} user who types
 * @param {Ref<{ id: number; name: string }[]>} friendsTyping gets modified on typing
 * @param {number} timeout milliseconds to show the user is typing
 *
 * @return {() => void} callback that should be called on keydown for signaling the typing
 */
export function useTypingEvent(channelId: string, user: {
    id: number;
    name: string
}, friendsTyping: Ref<{ id: number; name: string }[]>, timeout: number = 5000): () => void {
    const eventName = 'typing';
    const channel = window.Echo.private(channelId);
    const friendsTypingTimer: Ref<{ [id: number]: any }> = ref<{ [id: number]: any }>({});

    onMounted(() => {
        channel.listenForWhisper(eventName, (event: { id: number; name: string }) => {
            if (!friendsTyping.value.some(friend => friend.id === event.id)) {
                friendsTyping.value.push(event);
            }

            if (friendsTypingTimer.value.hasOwnProperty(event.id)) {
                clearTimeout(friendsTypingTimer.value[event.id]);
            }

            friendsTypingTimer.value[event.id] = setTimeout(() => {
                friendsTyping.value = friendsTyping.value.filter((friend) => friend.id !== event.id);
            }, timeout);
        })
            .error((error: Error): void => {
                console.error('error on typing', error);
            });
    });
    onUnmounted(() => {
        window.Echo.leave(channelId);
    });

    return (): void => {
        // @ts-ignore
        channel.whisper(eventName, user);
    }
}
