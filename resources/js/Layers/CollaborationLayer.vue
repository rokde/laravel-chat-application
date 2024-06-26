<script setup>
import Notification from '@/Components/Notification.vue';
import {usersOnline} from '@/Stores/users-online.js';
import {usePage} from '@inertiajs/vue3';
import {onMounted, onUnmounted, ref, watchEffect} from 'vue';

const notifications = ref([]);
const page = usePage();

onMounted(() => {
    Echo.private(`App.Models.User.${page.props.auth.user.id}`)
        .notification((notification) => {
            console.log(`notification was sent to ${page.props.auth.user.id}`);
            notifications.value.push({
                show: true,
                content: notification.content,
            })
        })
        .error((error) => {
            console.error('error on notification', error);
        });
});

onUnmounted(() => {
    Echo.leave(`App.Models.User.${page.props.auth.user.id}`);
})

watchEffect((onCleanup) => {
    Echo.join('online')
        .here((users) => {
            users.forEach((user) => usersOnline.addUser(user));
        })
        .joining((user) => {
            usersOnline.addUser(user);
        })
        .leaving((user) => {
            usersOnline.deleteUser(user);
        })
        .error((error) => {
            console.error('online channel error', error);
        });

    onCleanup(() => Echo.leave('online'));
}, []);
</script>

<template>
    <div>
        <slot/>
        <div aria-live="assertive"
             class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6 z-50">
            <ul class="flex w-full flex-col items-center space-y-4 sm:items-end">
                <Notification v-for="notification in notifications" v-model:show="notification.show">
                    {{ notification.content }}
                </Notification>
            </ul>
        </div>
    </div>
</template>
