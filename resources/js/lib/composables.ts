import {onMounted, onUnmounted, Ref, ref} from 'vue';

export function useKeyupEvent(handler: any): void {
    onMounted(() => document.addEventListener("keyup", handler));
    onUnmounted(() => document.removeEventListener("keyup", handler));
}

export function useWindowHeight(handler: (height: Ref<number>) => void): void {
    const height: Ref<number> = ref<number>(0);
    const eventHandler = (): void => {
        height.value = window.innerHeight;
        handler(height);
    }

    onMounted(() => {
        window.addEventListener("resize", eventHandler)
        eventHandler();
    });
    onUnmounted(() => window.removeEventListener("resize", eventHandler));
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
    const friendsTypingTimer: Ref<{ [id: number]: any }> = ref<{ [id: number]: any }>({});

    onMounted(() => {
        window.Echo.private(channelId)
            .listenForWhisper(eventName, (event: { id: number; name: string }) => {
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
        window.Echo.private(channelId)
            .whisper(eventName, user);
    }
}
