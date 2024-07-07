<script setup lang="ts">
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger
} from "@/shadcn/ui/dropdown-menu";
import {computed} from "vue";
import {Link, router, usePage} from "@inertiajs/vue3";
import {route} from "ziggy-js";

const user = computed(() => usePage().props.auth.user);

const switchToTeam = (team: any) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <div class="cursor-pointer">{{ user?.current_team?.name ?? user?.name }}</div>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Manage Team</DropdownMenuLabel>
            <DropdownMenuSeparator/>
            <DropdownMenuItem>
                <Link :href="route('teams.show', user.current_team)" class="w-full">Team Settings</Link>
            </DropdownMenuItem>
            <DropdownMenuItem v-if="$page.props.jetstream.canCreateTeams">
                <Link :href="route('teams.create')" class="w-full">Create New Team</Link>
            </DropdownMenuItem>
            <!-- Team Switcher -->
            <template v-if="user?.all_teams?.length > 1">
                <DropdownMenuSeparator/>
                <DropdownMenuLabel>Switch Teams</DropdownMenuLabel>
                <template v-for="team in $page.props.auth.user.all_teams"
                          :key="team.id">
                    <DropdownMenuItem>
                        <form @submit.prevent="switchToTeam(team)" class="w-full">
                            <button type="submit" class="w-full text-left flex items-center">
                                <svg
                                    v-if="team.id == $page.props.auth.user.current_team_id"
                                    class="me-2 h-5 w-5 text-green-400"
                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>

                                <span>{{ team.name }}</span>
                            </button>
                        </form>
                    </DropdownMenuItem>
                </template>
            </template>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
