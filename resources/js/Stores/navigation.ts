import {route} from "ziggy-js";
import {ChatBubbleOvalLeftIcon, UserIcon} from "@heroicons/vue/24/solid";

export const navigation = [
    {
        title: 'Conversations',
        icon: ChatBubbleOvalLeftIcon,
        url: route('chats.index'),
        active: () => route().current('chats.index') || route().current('chats.show'),
    },
    {
        title: 'Contacts',
        icon: UserIcon,
        url: route('contacts.index'),
        active: () => route().current('contacts.index') || route().current('contacts.show'),
    },
];
