<script setup>
import Avatar from '@/Components/Avatar.vue';
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import Logo from '@/Navigation/Logo.vue';
import NavLink from '@/Navigation/NavLink.vue';
import {ChatBubbleOvalLeftIcon, UserIcon} from '@heroicons/vue/24/solid/index.js';
import {usePage} from '@inertiajs/vue3';

const page = usePage();
</script>

<template>
    <div
        class="w-full md:w-20 md:h-full md:py-7 py-5 px-5 flex flex-row md:flex-col items-center transition-all duration-500 bg-gray-100 dark:bg-gray-700">
        <Logo/>

        <div class="grow">
            <nav aria-label="Main navigation">
                <ul class="flex md:block justify-between items-center">
                    <li>
                        <NavLink title="Conversations"
                                 :href="route('chats.index')"
                                 :icon="ChatBubbleOvalLeftIcon"
                                 :active="route().current('chats.index') || route().current('chats.show')"/>
                    </li>
                    <li>
                        <NavLink title="Contacts"
                                 :href="route('contacts.index')"
                                 :icon="UserIcon"
                                 :active="route().current('contacts.index') || route().current('contacts.show')"/>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- secondary -->
        <div>
            <nav aria-label="Extra navigation" class="hidden md:block">
                <ul>
                    <li>
                        <ThemeSwitcher/>
                    </li>
                </ul>
            </nav>
            <hr class="hidden md:block mb-6 mt-4 border-gray-100 dark:border-gray-600"/>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <Avatar :name="$page.props.auth.user.name" :size="8"/>
            </div>
        </div>
    </div>
</template>
