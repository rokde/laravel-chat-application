<script setup lang="ts">
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger
} from "@/shadcn/ui/dropdown-menu";
import Avatar from "@/Components/Avatar.vue";
import {computed} from "vue";
import {Link, router, usePage} from "@inertiajs/vue3";
import {route} from "ziggy-js";

const user = computed(() => usePage().props.auth.user);

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Avatar :name="user?.name"
                    :image-url="$page.props.jetstream.managesProfilePhotos ? user?.profile_photo_url : null"
                    class="cursor-pointer"/>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Manage Account</DropdownMenuLabel>
            <DropdownMenuSeparator/>
            <DropdownMenuItem>
                <Link :href="route('profile.show')" class="w-full">
                    Profile
                </Link>
            </DropdownMenuItem>
            <DropdownMenuItem v-if="$page.props.jetstream.hasApiFeatures">
                <Link :href="route('api-tokens.index')" class="w-full">API Tokens</Link>
            </DropdownMenuItem>
            <DropdownMenuSeparator/>
            <DropdownMenuItem>
                <form @submit.prevent="logout" class="w-full">
                    <button type="submit" class="w-full text-left">Logout</button>
                </form>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
